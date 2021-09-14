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
        $this->em->persist($taggable);
        $this->em->flush();

        $this->tagManager->packTags($taggable, [$tag]);

        /** @var TagsRelationship $tagRelation */
        $tagRelation = $this->em->getRepository(TagsRelationship::class)->findOneBy(['tag' => $tag]);

        $this->assertNotNull($tagRelation);
        $this->assertEquals($tagRelation->getObjectClass(), get_class($taggable));
        $this->assertEquals(1, $taggable->getId());
    }

    public function testRemoveTagRelation()
    {
        $tag = $this->createTag('Tag1');
        $this->em->persist($tag);
        $this->em->flush();

        $this->assertEquals(1, $tag->getId());

        $taggable = new TaggableEntity();
        $this->em->persist($taggable);
        $this->em->flush();

        $this->tagManager->packTags($taggable, [$tag]);

        $this->tagManager->unPackTags($taggable, [$tag]);

        /** @var TagsRelationship $tagRelation */
        $tagRelation = $this->em->getRepository(TagsRelationship::class)->findOneBy(['tag' => $tag]);

        $this->assertNull($tagRelation);
    }

}