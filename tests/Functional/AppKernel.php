<?php

namespace DigitalAscetic\TagsBundle\Test\Functional;

use DigitalAscetic\TagsBundle\DigitalAsceticTagsBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function __construct(string $environment, bool $debug)
    {
        parent::__construct($environment, false);
    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new MonologBundle(),
            new DoctrineBundle(),
            new DigitalAsceticTagsBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $confDir = $this->getProjectDir() . '/tests/Functional/config';
        $loader->load($confDir . '/{packages}/*' . self::CONFIG_EXTS, 'glob');

        if (is_dir($confDir . '/packages/' . $this->environment)) {
            $loader->load($confDir . '/packages/' . $this->environment . '/**/*' . self::CONFIG_EXTS, 'glob');
        }
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/DigitalAsceticTagsBundle';
    }
}
