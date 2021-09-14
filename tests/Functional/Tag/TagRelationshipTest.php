<?php

namespace DigitalAscetic\TagsBundle\Test\Functional\Tag;

use DigitalAscetic\TagsBundle\Entity\TagsRelationship;
use DigitalAscetic\TagsBundle\Model\TagQueryResult;
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


    public function testFindByTag()
    {
        $tag1 = $this->createTag('Tag1');
        $tag2 = $this->createTag('Tag2');

        $this->em->persist($tag1);
        $this->em->persist($tag2);

        $taggable1 = new TaggableEntity();
        $taggable2 = new TaggableEntity();

        $this->em->persist($taggable1);
        $this->em->persist($taggable2);

        $this->em->flush();

        $this->tagManager->packTags($taggable1, [$tag1, $tag2]);
        $this->tagManager->packTags($taggable2, [$tag2]);

        $resultTag1 = $this->tagManager->findByTag($tag1);

        $this->assertNotEmpty($resultTag1);
        $this->assertEquals(1, count($resultTag1));

        $resultTag2 = $this->tagManager->findByTag($tag2);

        $this->assertNotEmpty($resultTag2);
        $this->assertEquals(2, count($resultTag2));
    }
}