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
        $taggable->addTag($tag);
        $this->em->persist($taggable);
        $this->em->flush();

        /** @var ITagRelationship $tagRelation */
        $tagRelation = $this->em->getRepository($taggable->getEntityRelationshipClass())->findOneBy(['tag' => $tag]);

        $this->assertNotNull($tagRelation);
        $this->assertEquals($tagRelation->getRelatedObject(), $taggable);
        $this->assertEquals(1, $taggable->getId());
    }

    public function testRemoveTagRelation()
    {
        $tag = $this->createTag('Tag1');
        $this->em->persist($tag);
        $this->em->flush();

        $this->assertEquals(1, $tag->getId());

        $taggable = new TaggableEntity();
        $taggable->addTag($tag);
        $this->em->persist($taggable);
        $this->em->flush();

        $taggable->removeTag($tag);
        $this->em->persist($taggable);
        $this->em->flush();

        /** @var ITagRelationship $tagRelation */
        $tagRelation = $this->em->getRepository($taggable->getEntityRelationshipClass())->findOneBy(['tag' => $tag]);

        $this->assertNull($tagRelation);
    }


    public function testFindByTag()
    {
        $tag1 = $this->createTag('Tag1');
        $tag2 = $this->createTag('Tag2');

        $this->em->persist($tag1);
        $this->em->persist($tag2);
        $this->em->flush();

        $taggable1 = new TaggableEntity();
        $taggable1->addTag($tag1);
        $taggable1->addTag($tag2);
        $taggable2 = new TaggableEntity();
        $taggable2->addTag($tag2);

        $this->em->persist($taggable1);
        $this->em->persist($taggable2);

        $this->em->flush();

        /** @var QueryBuilder $qb */
        $qb = $this->em->getRepository(TaggableEntity::class)->createQueryBuilder('t');
        $qb->leftJoin(TaggableRelationship::class, 'tr', 'WITH', 't.id = tr.relatedObject')
            ->where('tr.tag = :tag')
            ->setParameter('tag', $tag1)
            ->addGroupBy('t.id');

        $results = $qb->getQuery()->getResult();

        $this->assertNotEmpty($results);
        $this->assertEquals(1, count($results));
        $this->assertEquals($taggable1->getId(), $results[0]->getId());
    }
}