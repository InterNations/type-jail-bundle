<?php
namespace InterNations\Bundle\TypeJailBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;

class ProxyDirCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $directory = $container->getParameter('inter_nations.type_jail.proxy_dir');
        $fs = new Filesystem();
        $fs->mkdir($directory);
    }
}
