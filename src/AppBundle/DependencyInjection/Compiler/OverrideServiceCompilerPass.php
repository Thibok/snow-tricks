<?php

/**
 * Set services in container to public
 */

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * OverrideServiceCompilerPass
 */
class OverrideServiceCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition('assetic.filter_manager')->setPublic(true);
        $container->getDefinition('assetic.filter.cssrewrite')->setPublic(true);
    }
}