<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bar
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Bar
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var Foo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Foo", inversedBy="bars")
     */
    private $foo;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Bar
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set foo
     *
     * @param \AppBundle\Entity\Foo $foo
     * @return Bar
     */
    public function setFoo(\AppBundle\Entity\Foo $foo = null)
    {
        $this->foo = $foo;

        return $this;
    }

    /**
     * Get foo
     *
     * @return \AppBundle\Entity\Foo 
     */
    public function getFoo()
    {
        return $this->foo;
    }
}
