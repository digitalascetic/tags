<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 09:49
 */

namespace DigitalAscetic\BaseTagBundle\Test\Entity;


use DigitalAscetic\BaseTagBundle\Entity\TaggableTrait;

/**
 * Class CountryTag
 * @package DigitalAscetic\BaseEntityBundle\Test\Entity
 *
 * @TagPacker("CountryTagPacker")
 */
class CountryTag
{
    use TaggableTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $tagId;

}