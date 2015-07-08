<?php

namespace CherryPick\Bundle\JsEntitiesBundle\JavaScript;

/**
 * @package CherryPick\Bundle\JsEntitiesBundle
 * @author moellers
 */
class Metadata
{
    /**
     * @var string
     */
    public $filename;

    /**
     * @var string
     */
    public $superFunctionName;

    /**
     * @var string
     */
    public $originalName;

    /**
     * @var string
     */
    public $namespace;

    /**
     * @var string
     */
    public $functionName;

    /**
     * @var Field[]
     */
    public $fields = array();

    /**
     * @var Association[]
     */
    public $associations = array();
}
