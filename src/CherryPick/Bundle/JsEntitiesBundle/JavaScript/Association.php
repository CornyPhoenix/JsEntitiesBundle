<?php

namespace CherryPick\Bundle\JsEntitiesBundle\JavaScript;

/**
 * @package CherryPick\Bundle\JsEntitiesBundle\JavaScript
 * @author moellers
 */
class Association extends Field
{

    /**
     * @var bool
     */
    public $isCollection;

    /**
     * @var bool
     */
    public $isSingle;

    /**
     * @var string
     */
    public $singleName;

    /**
     * @var string
     */
    public $invertedField;

    /**
     * @var string
     */
    public $singleType;
}
