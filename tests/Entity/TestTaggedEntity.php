<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 09:47
 */

namespace DigitalAscetic\BaseTagBundle\Test\Entity;

/**
 * Class TestTaggedEntity
 * @package DigitalAscetic\BaseEntityBundle\Test\Entity
 *
 */
class TestTaggedEntity
{

    private $name;

    /**
     * @var CountryTag[]
     * @TagProperty(class="DigitalAscetic\BaseEntityBundle\Test\Entity\CountryTag")
     */
    private $countryTags;

    /**
     * @var
     * @TagProperty(class="DigitalAscetic\BaseEntityBundle\Test\Entity\CategoryTag")
     */
    private $categoryTags;

}