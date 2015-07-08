(function ($, exports) {

    'use strict';

    exports.Bar = (function($) {
        /**
 * Generated JavaScript class for the
 * original {@link AppBundle\Entity\Bar} entity.
 *
 * @constructor
 * @extends {DBEntity}
 */
var Bar = DBEntity.extend('AppBundle\x5CEntity\x5CBar', {

    constructor: function () {
        // Initialize Associations.
        this.foo = null;

        // Initialize Fields.
        this.id = null;
        this.title = null;

        this.originalName = 'AppBundle\\Entity\\Bar';
    },

    /**
     * @return {Foo}
     * @public
     */
    getFoo: function() {
        return this.foo;
    },

    /**
     * @param {Foo} value
     * @return {Bar}
     * @public
     */
    setFoo: function(value) {
        return this.foo = value;
    },

    /**
     * @return {Number}
     * @public
     */
    getId: function() {
        return this.id;
    },

    /**
     * @return {String}
     * @public
     */
    getTitle: function() {
        return this.title;
    },

    /**
     * @param {String} value
     * @return {Bar}
     * @public
     */
    setTitle: function(value) {
        this.title = value;
        return this;
    },


    /**
     * Converts this Bar to a JSON string.
     *
     * @return {String}
     */
    toJSON: function(cache) {
        cache || (cache = []);
        var json = {"$entity": "AppBundle\x5CEntity\x5CBar"};

        json["foo"] = this.foo ? this.foo.getId() : null;
        json["id"] = this.getValue('id');
        json["title"] = this.getValue('title');

        return JSON.stringify(json);
    }
});

return Bar;
    })($);
    exports.Foo = (function($) {
        /**
 * Generated JavaScript class for the
 * original {@link AppBundle\Entity\Foo} entity.
 *
 * @constructor
 * @extends {DBEntity}
 */
var Foo = DBEntity.extend('AppBundle\x5CEntity\x5CFoo', {

    constructor: function () {
        // Initialize Associations.
        this.bars = [];

        // Initialize Fields.
        this.id = null;
        this.name = null;
        this.ageInYears = null;
        this.created = null;
        this.money = null;

        this.originalName = 'AppBundle\\Entity\\Foo';
    },

    /**
     * @return {Bar[]}
     * @public
     */
    getBars: function() {
        return this.bars;
    },

    /**
     * @param {Bar[]} value
     * @return {Foo}
     * @public
     */
    setBars: function(value) {
        return this.bars = value;
    },

    /**
     * @return {Boolean}
     * @public
     */
    hasBars: function() {
        return this.bars.length > 0;
    },

    /**
     * @param {Bar} value
     * @return {Foo}
     * @public
     */
    addBar: function(value) {
        value.foo = this;
        this.bars.push(value);
        return this;
    },

    /**
     * @param {Bar} value
     * @return {Foo}
     * @public
     */
    removeBar: function(value) {
        var index = this.bars.indexOf(value);

        if (index > -1) {
            this.bars.splice(index, 1);
        }

        return this;
    },

    /**
     * @return {Number}
     * @public
     */
    getId: function() {
        return this.id;
    },

    /**
     * @return {String}
     * @public
     */
    getName: function() {
        return this.name;
    },

    /**
     * @param {String} value
     * @return {Foo}
     * @public
     */
    setName: function(value) {
        this.name = value;
        return this;
    },

    /**
     * @return {Number}
     * @public
     */
    getAgeInYears: function() {
        return this.ageInYears;
    },

    /**
     * @param {Number} value
     * @return {Foo}
     * @public
     */
    setAgeInYears: function(value) {
        this.ageInYears = value;
        return this;
    },

    /**
     * @return {Date}
     * @public
     */
    getCreated: function() {
        return this.created;
    },

    /**
     * @param {Date} value
     * @return {Foo}
     * @public
     */
    setCreated: function(value) {
        this.created = value;
        return this;
    },

    /**
     * @return {Number}
     * @public
     */
    getMoney: function() {
        return this.money;
    },

    /**
     * @param {Number} value
     * @return {Foo}
     * @public
     */
    setMoney: function(value) {
        this.money = value;
        return this;
    },


    /**
     * Converts this Foo to a JSON string.
     *
     * @return {String}
     */
    toJSON: function(cache) {
        cache || (cache = []);
        var json = {"$entity": "AppBundle\x5CEntity\x5CFoo"};

        json["bars"] = this.bars.map(function (entity) { return entity.getId(); });
        json["id"] = this.getValue('id');
        json["name"] = this.getValue('name');
        json["ageInYears"] = this.getValue('ageInYears');
        json["created"] = this.getValue('created');
        json["money"] = this.getValue('money');

        return JSON.stringify(json);
    }
});

return Foo;
    })($);
    exports.Baz = (function($) {
        /**
 * Generated JavaScript class for the
 * original {@link AppBundle\Entity\Baz} entity.
 *
 * @constructor
 * @extends {Foo}
 */
var Baz = Foo.extend('AppBundle\x5CEntity\x5CBaz', {

    constructor: function () {
        // Initialize Associations.
        this.bars = [];

        // Initialize Fields.
        this.id = null;
        this.name = null;
        this.ageInYears = null;
        this.created = null;
        this.money = null;
        this.blah = null;

        this.originalName = 'AppBundle\\Entity\\Baz';
    },

    /**
     * @return {Bar[]}
     * @public
     */
    getBars: function() {
        return this.bars;
    },

    /**
     * @param {Bar[]} value
     * @return {Baz}
     * @public
     */
    setBars: function(value) {
        return this.bars = value;
    },

    /**
     * @return {Boolean}
     * @public
     */
    hasBars: function() {
        return this.bars.length > 0;
    },

    /**
     * @param {Bar} value
     * @return {Baz}
     * @public
     */
    addBar: function(value) {
        value.foo = this;
        this.bars.push(value);
        return this;
    },

    /**
     * @param {Bar} value
     * @return {Baz}
     * @public
     */
    removeBar: function(value) {
        var index = this.bars.indexOf(value);

        if (index > -1) {
            this.bars.splice(index, 1);
        }

        return this;
    },

    /**
     * @return {Number}
     * @public
     */
    getId: function() {
        return this.id;
    },

    /**
     * @return {String}
     * @public
     */
    getName: function() {
        return this.name;
    },

    /**
     * @param {String} value
     * @return {Baz}
     * @public
     */
    setName: function(value) {
        this.name = value;
        return this;
    },

    /**
     * @return {Number}
     * @public
     */
    getAgeInYears: function() {
        return this.ageInYears;
    },

    /**
     * @param {Number} value
     * @return {Baz}
     * @public
     */
    setAgeInYears: function(value) {
        this.ageInYears = value;
        return this;
    },

    /**
     * @return {Date}
     * @public
     */
    getCreated: function() {
        return this.created;
    },

    /**
     * @param {Date} value
     * @return {Baz}
     * @public
     */
    setCreated: function(value) {
        this.created = value;
        return this;
    },

    /**
     * @return {Number}
     * @public
     */
    getMoney: function() {
        return this.money;
    },

    /**
     * @param {Number} value
     * @return {Baz}
     * @public
     */
    setMoney: function(value) {
        this.money = value;
        return this;
    },

    /**
     * @return {String}
     * @public
     */
    getBlah: function() {
        return this.blah;
    },

    /**
     * @param {String} value
     * @return {Baz}
     * @public
     */
    setBlah: function(value) {
        this.blah = value;
        return this;
    },


    /**
     * Converts this Baz to a JSON string.
     *
     * @return {String}
     */
    toJSON: function(cache) {
        cache || (cache = []);
        var json = {"$entity": "AppBundle\x5CEntity\x5CBaz"};

        json["bars"] = this.bars.map(function (entity) { return entity.getId(); });
        json["id"] = this.getValue('id');
        json["name"] = this.getValue('name');
        json["ageInYears"] = this.getValue('ageInYears');
        json["created"] = this.getValue('created');
        json["money"] = this.getValue('money');
        json["blah"] = this.getValue('blah');

        return JSON.stringify(json);
    }
});

return Baz;
    })($);

})(jQuery, this);
