<?php

namespace Programarivm\EasyAclBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('programarivm_easy_acl');

        $treeBuilder
            ->getRootNode()
                ->children()
                    ->arrayNode('roles')
                        ->arrayPrototype()
                            ->children()
                                ->integerNode('hierarchy')->end()
                                ->scalarNode('name')->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('access')
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('role')->end()
                                ->arrayNode('routes')
                                    ->scalarPrototype()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
