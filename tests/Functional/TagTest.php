<?php

namespace DigitalAscetic\TagsBundle\Test\Functional;

use DigitalAscetic\TagsBundle\Model\ITaggable;
use DigitalAscetic\TagsBundle\Service\TagManager;
use DigitalAscetic\TagsBundle\Test\Entity\Tag;
use DigitalAscetic\TagsBundle\Test\Entity\TaggableEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class TagTest extends KernelTestCase
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var TagManager */
    private $tagManager;

    /** @var ITaggable */
    private $taggableEntity;

    protected function setUp(): void
    {
        $fs = new Filesystem();
        $fs->remove(sys_get_temp_dir().'/DigitalAsceticTagsBundle');

        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks

    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::bootKernel();
        self::importDatabaseSchema();
    }

    protected static function importDatabaseSchema()
    {
        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
            $schemaTool->dropDatabase();
            $schemaTool->createSchema($metadata);
        }
    }

    public function testPersistTag()
    {
        $tag = $this->createTag();
        $this->em->persist($tag);
        $this->em->flush();

        $this->assertNotNull($tag);
        $this->assertEquals(1, $tag->getId());
    }

    public function testAddTag()
    {
        $tag = $this->createTag();
        $this->em->persist($tag);
        $this->em->flush();

        $taggable = new TaggableEntity();
        $this->tagManager->packTag($taggable, $tag);
        $this->em->persist($taggable);
        $this->em->flush();

        $this->assertNotNull($taggable->getTags());
        $this->assertEquals(1, count($taggable->getTags()));
    }

    public function testRemoveTag()
    {
        $tag = $this->createTag();
        $this->em->persist($tag);
        $this->em->flush();

        $taggable = new TaggableEntity();
        $this->tagManager->packTag($taggable, $tag);

        $this->assertNotNull($taggable->getTags());
        $this->assertEquals(1, count($taggable->getTags()));

        $this->tagManager->removeTag($taggable, $tag);

        $this->assertEmpty($taggable->getTags());
    }

    private function createTag(): Tag
    {
        return new Tag('Tag1', '000000');
    }
}