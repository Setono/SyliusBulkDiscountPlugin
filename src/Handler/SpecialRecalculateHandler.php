<?php

declare(strict_types=1);

namespace Setono\SyliusBulkSpecialsPlugin\Handler;

use Psr\Log\LoggerInterface;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusBulkSpecialsPlugin\Doctrine\ORM\ProductRepositoryInterface;
use Setono\SyliusBulkSpecialsPlugin\Model\ProductInterface;
use Setono\SyliusBulkSpecialsPlugin\Model\SpecialInterface;

class SpecialRecalculateHandler extends AbstractSpecialHandler
{
    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var ProductRecalculateHandlerInterface */
    protected $productRecalculateHandler;

    public function __construct(
        LoggerInterface $logger,
        ProductRepositoryInterface $productRepository,
        ProductRecalculateHandlerInterface $productRecalculateHandler
    ) {
        parent::__construct($logger);

        $this->productRepository = $productRepository;
        $this->productRecalculateHandler = $productRecalculateHandler;
    }

    /**
     * @throws StringsException
     */
    public function handleSpecial(SpecialInterface $special): void
    {
        $this->log(sprintf(
            "Special '%s' recalculate started...",
            $special->getCode()
        ));

        // @see Good explanation at https://stackoverflow.com/a/26698814
        $iterableResult = $this->productRepository->findBySpecialQueryBuilder($special)->getQuery()->iterate();

        foreach ($iterableResult as $productRow) {
            /** @var ProductInterface $product */
            $product = $productRow[0];

            if (!$product->hasSpecial($special)) {
                $product->addSpecial($special);

                $this->log(sprintf(
                    "Special '%s' assigned to Product '%s'",
                    $special->getCode(),
                    $product->getCode()
                ));

                $this->productRepository->add($product);
            }

            $this->productRecalculateHandler->handleProduct($product);
        }

        $this->log(sprintf(
            "Special '%s' recalculate finished.",
            $special->getCode()
        ));
    }
}
