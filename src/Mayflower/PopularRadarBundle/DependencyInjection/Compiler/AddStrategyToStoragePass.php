<?php

namespace Mayflower\PopularRadarBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * AddStrategyToStoragePass
 *
 * Compiler that adds strategies to the storage
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class AddStrategyToStoragePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('mayflower.popular_radar.strategy_storage')) {
            return;
        }

        $injectClient     = false;
        $clientDefinition = null;
        if ($container->hasDefinition('mayflower.popular_radar.guzzle.http_client')) {
            $clientDefinition = new Reference('mayflower.popular_radar.guzzle.http_client');
            $injectClient     = true;
        }

        $definition = $container->getDefinition('mayflower.popular_radar.strategy_storage');

        foreach ($container->findTaggedServiceIds('radar.voter') as $serviceId => $tags) {
            $voterDefinition = $container->getDefinition($serviceId);
            $className       = 'Mayflower\\PopularRadarBundle\\Model\\Comparison\\Strategy\\StrategyInterface';
            if (!in_array($className, class_implements($voterDefinition->getClass()))) {
                throw new \InvalidArgumentException(sprintf('Strategy must implement "%s"!', $className));
            }

            $definition->addMethodCall('addStrategy', array(new Reference($serviceId)));

            if ($injectClient) {
                $voterDefinition->addMethodCall('setHttpClient', array($clientDefinition));
            }
        }
    }
}
