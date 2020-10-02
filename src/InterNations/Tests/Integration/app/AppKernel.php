<?php
namespace InterNations\Bundle\TypeJailBundle\Tests\Integration\app;

use InterNations\Bundle\TypeJailBundle\InterNationsTypeJailBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private string $rootConfig;

    public function __construct(string $rootConfig, string $environment, bool $debug)
    {
        $this->rootConfig = $rootConfig;
        parent::__construct($environment, $debug);
    }

    /** @return BundleInterface[] */
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new InterNationsTypeJailBundle()
        ];
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/' . Kernel::VERSION . '/' . $this->rootConfig . '/cache/' . $this->environment;
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/' . Kernel::VERSION . '/' . $this->rootConfig . '/logs';
    }

    public function getContainerClass(): string
    {
        return parent::getContainerClass() . hash('sha256', $this->rootConfig . $this->debug);
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/' . $this->rootConfig);
    }
}
