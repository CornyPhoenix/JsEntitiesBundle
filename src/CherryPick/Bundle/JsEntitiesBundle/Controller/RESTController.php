<?php

namespace CherryPick\Bundle\JsEntitiesBundle\Controller;

use AppBundle\Entity\Foo;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @package AppBundle\Controller
 * @author moellers
 *
 * @Route(service="cherrypick.controller.rest")
 */
class RESTController
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * RESTController constructor.
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Method("GET")
     * @Route(name="rest_find")
     */
    public function find(Request $request)
    {
        $entity = $this->em->getRepository(Foo::class)->find(1);
        return $this->respond($entity);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Method("POST")
     * @Route(name="rest_create")
     */
    public function create(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);

        $class = $data['$entity'];
        if (!class_exists($class)) {
            throw new NotFoundHttpException('Not Found');
        }

        $entity = new $class();

        $id = $data['id'];

        if ($id !== null) {
            throw new BadRequestHttpException('ID is set. This method is only for creation!');
        }

        foreach ($data as $key => $value) {
            if (is_array($value) && ($keys = array_keys($value)) && count($keys) == 1) {
                $type = $keys[0];
                $value = $value[$type];
                if ($type === '$date') {
                    $value = new \DateTime("@$value");
                }
            }

            $method = 'set' . ucfirst($key);
            if (method_exists($entity, $method)) {
                $entity->$method($value);
            }
        }

        $this->em->persist($entity);
        $this->em->flush();

        return $this->respond($entity);
    }

    private function respond($entity)
    {
        return new JsonResponse($this->serialize($entity));
    }

    private function serialize($entity)
    {
        if ($entity === null || is_scalar($entity)) {
            return $entity;
        }

        if ($entity instanceof \DateTime) {
            return array('$date' => $entity->getTimestamp());
        }

        $json = array('$entity' => get_class($entity));
        $metadata = $this->em->getClassMetadata(get_class($entity));

        foreach ($metadata->getFieldNames() as $field) {
            $method = 'get' . ucfirst($field);
            if (method_exists($entity, $method)) {
                $json[$field] = $this->serialize($entity->$method());
            }
        }

        return $json;
    }
}
