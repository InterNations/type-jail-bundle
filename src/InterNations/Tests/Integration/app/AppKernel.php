<?php
namespace InterNations\Bundle\TypeJailBundle\Tests\Integration\app;

use InterNations\Bundle\TypeJailBundle\InterNationsTypeJailBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private $rootConfig;

    private $seed;

    public function __construct($rootConfig, $environment, $debug)
    {
        $this->rootConfig = $rootConfig;
        parent::__construct($environment, $debug);
    }

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new InterNationsTypeJailBundle()
        ];
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir() . '/' . Kernel::VERSION . '/' . $this->rootConfig . '/cache/' . $this->environment;
    }

    public function getLogDir()
    {
        return sys_get_temp_dir() . '/' . Kernel::VERSION . '/' . $this->rootConfig . '/logs';
    }

    public function getContainerClass()
    {
        return parent::getContainerClass() . hash('sha256', $this->rootConfig . $this->debug);
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/' . $this->rootConfig);
    }
}
