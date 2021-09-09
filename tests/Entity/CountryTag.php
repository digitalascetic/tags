<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 09:49
 */

namespace DigitalAscetic\BaseTagBundle\Test\Entity;


/**
 * Class CountryTag
 * @package DigitalAscetic\BaseEntityBundle\Test\Entity
 *
 * @TagPacker("CountryTagPacker")
 */
class CountryTag
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $tagId;

}