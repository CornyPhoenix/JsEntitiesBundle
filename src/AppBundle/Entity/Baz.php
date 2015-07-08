<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Baz
 *
 * @ORM\Entity
 */
class Baz extends Foo
{

    /**
     * @var string
     *
     * @ORM\Column(name="blah", nullable=true)
     */
    private $blah;
}
