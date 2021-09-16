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
        $taggable->addTag($tag);
        $this->em->persist($taggable);
        $this->em->flush();

        $this->assertNotNull($taggable->getIdTags());
        $this->assertEquals(1, count($taggable->getIdTags()));
        $this->assertEquals($tag->getId(), $taggable->getIdTags()[0]);
    }

    public function testClearTags()
    {
        $tag = $this->createTag('Tag2');
        $this->em->persist($tag);
        $this->em->flush();

        $taggable = new TaggableEntity();
        $taggable->addTag($tag);
        $this->em->persist($taggable);
        $this->em->flush();

        $this->assertNotNull($taggable->getIdTags());
        $this->assertEquals(1, count($taggable->getIdTags()));
        $this->assertEquals($tag->getId(), $taggable->getIdTags()[0]);

        $taggable->removeTag($tag);

        $this->assertEmpty($taggable->getIdTags());
    }

    public function testRemoveTag()
    {
        $tag = $this->createTag('Tag1');
        $this->em->persist($tag);
        $tag2 = $this->createTag('Tag2');
        $this->em->persist($tag2);
        $this->em->flush();

        $taggable = new TaggableEntity();
        $taggable->addTag($tag);
        $taggable->addTag($tag2);
        $this->em->persist($taggable);
        $this->em->flush();

        $this->assertNotNull($taggable->getIdTags());
        $this->assertEquals(2, count($taggable->getIdTags()));
        $this->assertEquals($tag->getId(), $taggable->getIdTags()[0]);

        $taggable->removeTag($tag);
        $this->em->persist($taggable);
        $this->em->flush();

        $this->assertEquals(1, count($taggable->getIdTags()));
        $this->assertEquals($tag2->getId(), $taggable->getIdTags()[0]);
    }

    public function createTagWithCategory()
    {
        $tag = $this->createTag('Tag3');
        $tag->setCategory(TaggableEntity::class);
        $this->em->persist($tag);
        $this->em->flush();

        $this->assertEquals(TaggableEntity::class, $tag->getCategory());
    }
}