<?php

namespace Mayflower\PopularRadarBundle;

use Mayflower\PopularRadarBundle\DependencyInjection\Compiler\AddStrategyToStoragePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MayflowerPopularRadarBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddStrategyToStoragePass());
    }
}
