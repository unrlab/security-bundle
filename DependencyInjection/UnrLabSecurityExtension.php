<?php

namespace UnrLab\SecurityBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class UnrLabSecurityExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (isset($config['security_user_api_key'])) {
            $container->setParameter('security_user_api_key', $config['security_user_api_key']);
        }

        if (isset($config['security_rest_header'])) {
            $container->setParameter('security_rest_header', $config['security_rest_header']);
        }

        if (isset($config['security_user_repository'])) {
            $container->setParameter('security_user_repository', $config['security_user_repository']);
        }
    }
}
