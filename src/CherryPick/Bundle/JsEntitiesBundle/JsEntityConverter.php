<?php

namespace CherryPick\Bundle\JsEntitiesBundle;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @package CherryPick\Bundle\JsEntitiesBundle
 * @author moellers
 */
class JsEntityConverter
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TwigEntityGenerator
     */
    private $generator;

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * JsEntityConverter constructor.
     */
    public function __construct(EntityManager $entityManager, TwigEntityGenerator $generator, KernelInterface $kernel)
    {
        $this->entityManager = $entityManager;
        $this->generator = $generator;
        $this->kernel = $kernel;
    }

    public function convert($cacheDir)
    {
        $fs = new Filesystem();

        $targetDir = $cacheDir . '/js_entities';
        $webDir = $this->kernel->getRootDir() . '/../web/js';
        $fs->mkdir($targetDir);
        $fs->mkdir($webDir);

        $namespaces = [];
        $metas = $this->entityManager->getMetadataFactory()->getAllMetadata();
        foreach ($metas as $metadata) {
            $meta = $this->convertMetadata($metadata);

            $directory = $targetDir . '/' . $meta->namespace;
            $fs->mkdir($directory);

            $meta->filename = $directory . '/' . $meta->functionName . '.js';
            $this->generator->generateEntity($meta);

            if (!isset($namespaces[$meta->namespace])) {
                $namespaces[$meta->namespace] = array();
            }
            $namespaces[$meta->namespace][] = $meta;
        }

        foreach ($namespaces as $namespace => $metas) {
            $targetFile = $targetDir . '/' . $namespace . '.js';
            $webFile = $webDir . '/' . $namespace . '.js';
            $this->generator->generateNamespace($namespace, $metas, $targetFile);
            $fs->copy($targetFile, $webFile);
        }
    }

    /**
     * @param ClassMetadata $metadata
     * @return JavaScript\Metadata
     */
    private function convertMetadata(ClassMetadata $metadata)
    {
        $meta = new JavaScript\Metadata();
        $meta->originalName = $metadata->getName();
        $meta->namespace = str_replace('\\', '_', $metadata->getReflectionClass()->getNamespaceName());
        $meta->functionName = $metadata->getReflectionClass()->getShortName();

        $parent = $metadata->getReflectionClass()->getParentClass();
        $meta->superFunctionName = $parent ? $parent->getShortName() : 'DBEntity';

        // Convert fields.
        foreach ($metadata->getFieldNames() as $fieldName) {
            $field = new JavaScript\Field();
            $field->name = $fieldName;
            $field->methodName = ucfirst($fieldName);
            $field->type = $this->convertDoctrineType($metadata->getTypeOfField($fieldName));
            $field->isIdentifier = $metadata->isIdentifier($fieldName);

            $meta->fields[] = $field;
        }

        // Convert associations.
        foreach ($metadata->getAssociationNames() as $assocName) {
            $assoc = new JavaScript\Association();
            $assoc->name = $assocName;
            $assoc->methodName = ucfirst($assocName);
            $assoc->isCollection = $metadata->isCollectionValuedAssociation($assocName);
            $assoc->isSingle = $metadata->isSingleValuedAssociation($assocName);
            $assoc->singleName = Inflector::singularize($assoc->methodName);
            $assoc->invertedField = $metadata->getAssociationMappedByTargetField($assocName);

            $targetClass = new \ReflectionClass($metadata->getAssociationTargetClass($assocName));
            $assoc->singleType = $targetClass->getShortName();
            $assoc->type = $assoc->singleType . ($assoc->isCollection ? '[]' : '');

            $meta->associations[] = $assoc;
        }

        return $meta;
    }

    /**
     * @param string $type
     * @return string
     */
    private function convertDoctrineType($type)
    {
        $map = array(
            'array' => '{}',
            'simple_array' => '{}',
            'json_array' => '{}',
            'object' => '{}',
            'boolean' => 'Boolean',
            'integer' => 'Number',
            'smallint' => 'Number',
            'bigint' => 'Number',
            'string' => 'String',
            'text' => 'String',
            'datetime' => 'Date',
            'datetimetz' => 'Date',
            'date' => 'Date',
            'time' => 'Date',
            'decimal' => 'Number',
            'float' => 'Number',
            'blob' => '*',
            'guid' => '*',
        );

        if (!isset($map[$type])) {
            return '*';
        }

        return $map[$type];
    }
}
