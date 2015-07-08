<?php

namespace CherryPick\Bundle\JsEntitiesBundle\Warmer;

use CherryPick\Bundle\JsEntitiesBundle\JsEntityConverter;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

/**
 * @package CherryPick\Bundle\JsEntitiesBundle\Warmer
 * @author moellers
 */
class JsConverterWarmer implements CacheWarmerInterface
{
    /**
     * @var JsEntityConverter
     */
    private $converter;

    /**
     * JsConverterWarmer constructor.
     */
    public function __construct(JsEntityConverter $converter)
    {
        $this->converter = $converter;
    }

    public function warmUp($cacheDir)
    {
        $this->converter->convert($cacheDir);
    }

    public function isOptional()
    {
        return true;
    }
}
