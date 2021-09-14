<?php

namespace DigitalAscetic\TagsBundle\Test\Functional\Tag;

use DigitalAscetic\TagsBundle\Service\TagManagerInterface;
use DigitalAscetic\TagsBundle\Test\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

abstract class BaseTagTest extends KernelTestCase
{
    /** @var EntityManagerInterface */
    protected $em;

    /** @var TagManagerInterface */
    protected $tagManager;

    protected function setUp(): void
    {
        $fs = new Filesystem();
        $fs->remove(sys_get_temp_dir().'/DigitalAsceticTagsBundle');

        self::bootKernel();

        $this->importDatabaseSchema();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->tagManager = static::$kernel->getContainer()->get(TagManagerInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks

    }

    protected function importDatabaseSchema()
    {
        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
            $schemaTool->dropDatabase();
            $schemaTool->createSchema($metadata);
        }
    }

    protected function createTag(string $tagName): Tag
    {
        return new Tag($tagName, '000000');
    }
}