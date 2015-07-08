<?php

namespace CherryPick\Bundle\JsEntitiesBundle;

use CherryPick\Bundle\JsEntitiesBundle\JavaScript\Metadata;
use Symfony\Component\Templating\EngineInterface;

/**
 * @package CherryPick\Bundle\JsEntitiesBundle
 * @author moellers
 */
class TwigEntityGenerator
{

    private $templating;

    /**
     * TwigEntityGenerator constructor.
     * @param $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * Generates an entity from metadata.
     *
     * @param Metadata $meta
     */
    public function generateEntity(Metadata $meta)
    {
        // Render and save.
        $content = $this->templating->render('CherryPickJsEntitiesBundle::entity.js.twig', ['meta' => $meta]);
        file_put_contents($meta->filename, $content);
    }

    /**
     * @param string $namespace
     * @param Metadata[] $metas
     * @param string $targetFile
     */
    public function generateNamespace($namespace, array $metas, $targetFile)
    {
        // Render and save.
        $content = $this->templating->render(
            'CherryPickJsEntitiesBundle::namespace.js.twig',
            ['namespace' => $namespace, 'metas' => $metas]
        );
        file_put_contents($targetFile, $content);
    }
}
