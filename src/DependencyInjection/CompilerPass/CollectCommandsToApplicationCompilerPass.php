<?php
declare(strict_types=1);

namespace App\DependencyInjection\CompilerPass;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CollectCommandsToApplicationCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        $applicationDefinition = $container->getDefinition(Application::class);

        foreach ($container->getDefinitions() as $name => $definition) {
            if (is_a($definition->getClass(), Command::class, true)) {
                $applicationDefinition->addMethodCall('add', [new Reference($name)]);
            }
        }
    }
}
