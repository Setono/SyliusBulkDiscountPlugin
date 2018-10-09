<?php

declare(strict_types=1);

namespace AppBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver(
            array(
                realpath(__DIR__ . '/Resources/config/doctrine/model') => 'AppBundle\Model',
            ),
            array('doctrine.orm.entity_manager')
        ));
    }
}