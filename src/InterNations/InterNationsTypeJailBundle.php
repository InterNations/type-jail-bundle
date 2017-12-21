<?php
namespace InterNations\Bundle\TypeJailBundle;

use InterNations\Bundle\TypeJailBundle\DependencyInjection\Compiler\ProxyDirCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class InterNationsTypeJailBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new ProxyDirCompilerPass(), PassConfig::TYPE_OPTIMIZE);
    }
}
