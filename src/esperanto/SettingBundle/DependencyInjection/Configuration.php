<?php

namespace esperanto\SettingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('esperanto_setting');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
            // Driver used by the resource bundle
            ->children()
               ->scalarNode('driver')->defaultValue('doctrine/orm')->end()
            ->end()

            // The resources
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('setting')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('esperanto\SettingBundle\Entity\Setting')->end()
                                ->scalarNode('controller')->defaultValue('esperanto\SettingBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('esperanto\SettingBundle\Repository\SettingRepository')->end()
                                ->scalarNode('form')->defaultValue('esperanto\SettingBundle\Form\Type\SettingType')->end()
                                ->scalarNode('admin')->defaultValue('esperanto\AdminBundle\Admin\BaseAdmin')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
