<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 09:42
 */

namespace DigitalAscetic\BaseTagBundle\Entity;


interface ITag
{
     public function getName(): string ;

     public function getTagId(): int ;
}