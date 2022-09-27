<?php
declare(strict_types=1);

namespace Drupal\TheTribe\NotificationMS\Drupal;

use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ServiceProvider extends ServiceProviderBase
{
    public function register(ContainerBuilder $container)
    {
        $class = "'\TheTribe\NotificationMS\NotificationService";
        if (!$container->hasDefinition($class)) {
            $definition = new Definition($class);
            $definition->setAutowired(true);
            $container->setDefinition($class, $definition);
        }
    }
}

