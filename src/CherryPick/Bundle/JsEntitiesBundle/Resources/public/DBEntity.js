(function ($, exports) {

    /**
     * @constructor
     */
    var DBEntity = function () {
    };

    DBEntity.$entities = {};
    DBEntity.$websocket = new WebSocket('ws://localhost:843');
    DBEntity.$websocketTickets = [];
    DBEntity.$websocketPending = [];

    /**
     *
     * @param {WebSocket} event
     */
    DBEntity.$websocket.onmessage = function (event) {
        var data = event.data;
        var json = JSON.parse(data);

        DBEntity.$websocketTickets[json.ticket].isDone(DBEntity.parse(JSON.parse(json.response)));
    };

    /**
     */
    DBEntity.$websocket.onopen = function () {
        for (var i in DBEntity.$websocketPending) {
            DBEntity.$websocket.send(DBEntity.$websocketPending[i]);
        }

        DBEntity.$websocketPending = [];
    };

    /**
     * @param {String} originalName
     * @param {Object} protoProps
     * @return {Function}
     * @public
     * @static
     */
    DBEntity.extend = function (originalName, protoProps) {
        var parent = this;
        var child;

        if (protoProps && protoProps['constructor']) {
            child = protoProps.constructor;
        } else {
            child = function () {
                return parent.apply(this, arguments);
            };
        }

        $.extend(child, parent);

        var Surrogate = function () {
            this.constructor = child;
        };
        Surrogate.prototype = parent.prototype;
        child.prototype = new Surrogate;


        if (protoProps) $.extend(child.prototype, protoProps);

        child.__super__ = parent.prototype;

        DBEntity.$entities[originalName] = child;

        return child;
    };

    /**
     * @param {Object} data
     * @return {DBEntity}
     * @public
     * @static
     */
    DBEntity.parse = function (data) {
        if (!data.$entity) {
            return null;
        }

        var cls = DBEntity.$entities[data.$entity];
        var entity = new cls();
        entity.setValues(data);

        return entity;
    };

    /**
     * @param {String} method
     * @param {DBEntity} [entity]
     * @param {String} [url]
     * @return {XMLHttpRequest}
     * @public
     * @static
     */
    DBEntity.supplier = function (method, entity, url) {
        if (!url) {
            return DBEntity.supplierWebsocket(method, entity);
        }

        return DBEntity.supplierAjax(method, url, entity);
    };

    /**
     * @param method
     * @param data
     * @return {XMLHttpRequest}
     */
    DBEntity.supplierWebsocket = function (method, data) {
        function cls() {
            var doneCallbacks = [];
            this.done = function (callback) {
                doneCallbacks.push(callback);
            };

            this.isDone = function (data) {
                for (var i in doneCallbacks) {
                    doneCallbacks[i](data);
                }
            };
        }

        var obj = new cls();

        var ticket = DBEntity.$websocketTickets.push(obj) - 1;

        var options = JSON.stringify({
            ticket: ticket,
            method: method,
            request: data
        });

        if (DBEntity.$websocket.readyState == WebSocket.CONNECTING) {
            DBEntity.$websocketPending.push(options);
            return obj;
        }

        DBEntity.$websocket.send(options);
        return obj;
    };

    DBEntity.supplierAjax = function (method, url, data) {
        var options = {
            method: method,
            url: url,
            accepts: 'application/json',
            cache: false,
            contentType: 'application/json',
            converters: {
                "text json": function (data) {
                    var json = $.parseJSON(data);
                    return DBEntity.parse(json);
                }
            }
        };

        if (data) {
            options.data = JSON.stringify(data);
        }

        return $.ajax(options);
    };

    /**
     * @return {XMLHttpRequest}
     * @public
     * @static
     */
    DBEntity.get = function (url) {
        return DBEntity.supplier('GET', null, url);
    };

    /**
     * @return {XMLHttpRequest}
     * @public
     */
    DBEntity.prototype.persist = function (url) {
        DBEntity.supplier('POST', this, url)
            .done(function (data) {
                console.log(data);
            });
    };

    /**
     * @public
     * @abstract
     */
    DBEntity.prototype.toJSON = function () {
        /* abstract */
    };

    /**
     * @public
     */
    DBEntity.prototype.getValue = function (key) {
        var value = this[key];

        // Convert dates.
        if (value instanceof Date) {
            return {"$date": Math.floor(value.getTime() / 1000)};
        }

        return value;
    };

    /**
     * @public
     */
    DBEntity.prototype.setValue = function (key, value) {
        // Convert dates.
        if (value['$date']) {
            value = new Date(value['$date'] * 1000);
        }

        this[key] = value;
        return this;
    };

    /**
     * @public
     */
    DBEntity.prototype.setValues = function (values) {
        for (var field in values) {
            if (values.hasOwnProperty(field)) {
                if (field.match(/^\$.*/)) {
                    continue;
                }

                var value = values[field];
                this.setValue(field, value);
            }
        }
    };

    exports.DBEntity = DBEntity;
})(jQuery, window);
