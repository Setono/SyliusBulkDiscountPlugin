<?php

declare(strict_types=1);

namespace Setono\SyliusBulkSpecialsPlugin\Handler;

use Setono\SyliusBulkSpecialsPlugin\Model\ProductInterface;

abstract class AbstractProductHandler extends AbstractHandler implements ProductRecalculateHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle($object): void
    {
        if (!$object instanceof ProductInterface) {
            return;
        }

        $this->handleProduct($object);
    }
}
