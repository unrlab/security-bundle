<?php

namespace UnrLab\SecurityBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('unr_lab_security');
        $rootNode
            ->children()
                ->scalarNode('security_user_api_key')->cannotBeEmpty()->end()
                ->scalarNode('security_rest_header')->defaultValue('X-API-AccesS')->end()
                ->scalarNode('security_user_repository')->cannotBeEmpty()->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
