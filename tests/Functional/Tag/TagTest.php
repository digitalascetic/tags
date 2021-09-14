<?php

namespace DigitalAscetic\TagsBundle\Test\Functional\Tag;

use DigitalAscetic\TagsBundle\Test\Entity\TaggableEntity;

class TagTest extends BaseTagTest
{
    public function testPersistTag()
    {
        $tag = $this->createTag('Tag1');
        $this->em->persist($tag);
        $this->em->flush();

        $this->assertNotNull($tag);
        $this->assertEquals(1, $tag->getId());
    }

    public function testAddTag()
    {
        $tag = $this->createTag('Tag1');
        $this->em->persist($tag);
        $this->em->flush();

        $this->assertEquals(1, $tag->getId());

        $taggable = new TaggableEntity();
        $this->em->persist($taggable);
        $this->em->flush();

        $this->tagManager->packTags($taggable, [$tag]);

        $this->assertNotNull($taggable->getTags());
        $this->assertEquals(1, count($taggable->getTags()));
        $this->assertEquals('Tag1', array_values($taggable->getTags())[0]);
    }

    public function testRemoveTag()
    {
        $tag = $this->createTag('Tag2');
        $this->em->persist($tag);
        $this->em->flush();

        $taggable = new TaggableEntity();
        $this->em->persist($taggable);
        $this->em->flush();

        $this->tagManager->packTags($taggable, [$tag]);

        $this->assertNotNull($taggable->getTags());
        $this->assertEquals(1, count($taggable->getTags()));
        $this->assertEquals('Tag2', array_values($taggable->getTags())[0]);

        $this->tagManager->unPackTags($taggable, [$tag]);

        $this->assertEmpty($taggable->getTags());
    }
}