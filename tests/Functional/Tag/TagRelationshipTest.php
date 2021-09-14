<?php

namespace DigitalAscetic\TagsBundle\Test\Functional\Tag;

use DigitalAscetic\TagsBundle\Entity\TagsRelationship;
use DigitalAscetic\TagsBundle\Test\Entity\TaggableEntity;

class TagRelationshipTest extends BaseTagTest
{
    public function testAddTagRelation()
    {
        $tag = $this->createTag('Tag1');
        $this->em->persist($tag);
        $this->em->flush();

        $this->assertEquals(1, $tag->getId());

        $taggable = new TaggableEntity();
        $this->tagManager->packTags($taggable, [$tag]);
        $this->em->persist($taggable);
        $this->em->flush();

        /** @var TagsRelationship $tagRelation */
        $tagRelation = $this->em->getRepository(TagsRelationship::class)->findOneBy(['tag' => $tag]);

        $this->assertNotNull($tagRelation);
        $this->assertEquals($tagRelation->getObjectClass(), get_class($taggable));
        $this->assertEquals(1, $taggable->getId());
    }

}