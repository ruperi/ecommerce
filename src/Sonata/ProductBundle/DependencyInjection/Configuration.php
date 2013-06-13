<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\ProductBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

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
        $node = $treeBuilder->root('sonata_product');

        $this->addProductSection($node);
        $this->addModelSection($node);

        return $treeBuilder;
    }

    /**
     * @param  \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     * @return void
     */
    private function addProductSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('products')
                    ->useAttributeAsKey('id')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('provider')->isRequired()->end()
                            ->scalarNode('manager')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * @param  \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     * @return void
     */
    private function addModelSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('class')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('product')->defaultValue('Application\\Sonata\\ProductBundle\\Entity\\Product')->end()
                        ->scalarNode('package')->defaultValue('Application\\Sonata\\ProductBundle\\Entity\\Package')->end()
                        ->scalarNode('product_category')->defaultValue('Application\\Sonata\\ProductBundle\\Entity\\ProductCategory')->end()
                        ->scalarNode('category')->defaultValue('Application\\Sonata\\ProductBundle\\Entity\\Category')->end()
                        ->scalarNode('delivery')->defaultValue('Application\\Sonata\\ProductBundle\\Entity\\Delivery')->end()

                        ->scalarNode('user')->defaultValue('Application\\Sonata\\UserBundle\\Entity\\User')->end()
                        ->scalarNode('media')->defaultValue('Application\\Sonata\\MediaBundle\\Entity\\Media')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}