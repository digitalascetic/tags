<?php

namespace DigitalAscetic\TagsBundle\Test\Functional\Tag;

use DigitalAscetic\TagsBundle\Model\ITagRelationship;
use DigitalAscetic\TagsBundle\Test\Entity\TaggableEntity;
use DigitalAscetic\TagsBundle\Test\Entity\TaggableRelationship;
use Doctrine\ORM\QueryBuilder;

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
        $taggable->addTag($tag);

        $this->tagManager->packTags($taggable, [$tag]);

        /** @var ITagRelationship $tagRelation */
        $tagRelation = $this->em->getRepository($taggable->getEntityRelationship())->findOneBy(['tag' => $tag]);

        $this->assertNotNull($tagRelation);
        $this->assertEquals($tagRelation->getObjectRelated(), $taggable);
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

        /** @var ITagRelationship $tagRelation */
        $tagRelation = $this->em->getRepository($taggable->getEntityRelationship())->findOneBy(['tag' => $tag]);

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

        /** @var QueryBuilder $qb */
        $qb = $this->em->getRepository(TaggableEntity::class)->createQueryBuilder('t');
        $qb->leftJoin(TaggableRelationship::class, 'tr', 'WITH', 't.id = tr.objectRelated')
            ->where('tr.tag = :tag')
            ->setParameter('tag', $tag1)
            ->addGroupBy('t.id');

        $results = $qb->getQuery()->getResult();

        $this->assertNotEmpty($results);
        $this->assertEquals(1, count($results));
        $this->assertEquals($taggable1->getId(), $results[0]->getId());
    }
}