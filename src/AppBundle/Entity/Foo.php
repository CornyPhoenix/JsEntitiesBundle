<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Foo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Foo
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="age_in_years", type="integer")
     */
    private $ageInYears;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="money", type="decimal")
     */
    private $money;

    /**
     * @var Bar[]|Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Bar", mappedBy="foo")
     */
    private $bars;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bars = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Foo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAgeInYears()
    {
        return $this->ageInYears;
    }

    /**
     * Set age
     *
     * @param integer $ageInYears
     * @return Foo
     */
    public function setAgeInYears($ageInYears)
    {
        $this->ageInYears = $ageInYears;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Foo
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get money
     *
     * @return string
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set money
     *
     * @param string $money
     * @return Foo
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Add bars
     *
     * @param Bar $bars
     * @return Foo
     */
    public function addBar(Bar $bars)
    {
        $this->bars[] = $bars;

        return $this;
    }

    /**
     * Remove bars
     *
     * @param Bar $bars
     */
    public function removeBar(Bar $bars)
    {
        $this->bars->removeElement($bars);
    }

    /**
     * Get bars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBars()
    {
        return $this->bars;
    }
}
