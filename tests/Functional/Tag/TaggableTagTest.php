<?php

namespace DigitalAscetic\TagsBundle\Test\Functional\Tag;

use DigitalAscetic\TagsBundle\Model\ITagRelationship;
use DigitalAscetic\TagsBundle\Test\Entity\TaggableEntity;
use DigitalAscetic\TagsBundle\Test\Entity\TaggableRelationship;
use DigitalAscetic\TagsBundle\Test\Entity\TaggableTagEntity;
use DigitalAscetic\TagsBundle\Test\Entity\TaggableTagRelationship;
use Doctrine\ORM\QueryBuilder;

class TaggableTagTest extends BaseTagTest
{
    public function testAddTaggableTagRelation()
    {
        $tagCustom = $this->createCustomTag('Tag1');
        $this->em->persist($tagCustom);
        $this->em->flush();

        $this->assertEquals(1, $tagCustom->getId());

        $taggable = new TaggableTagEntity();
        $taggable->addTag($tagCustom);
        $this->em->persist($taggable);
        $this->em->flush();

        /** @var ITagRelationship $tagRelation */
        $tagRelation = $this->em->getRepository(TaggableTagRelationship::class)->findOneBy(['tag' => $tagCustom]);

        $this->assertNotNull($tagRelation);
        $this->assertEquals($tagRelation->getRelatedObject(), $taggable);
        $this->assertEquals(1, $taggable->getId());
    }

}