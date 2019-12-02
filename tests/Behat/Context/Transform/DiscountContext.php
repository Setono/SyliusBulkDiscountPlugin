<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusCatalogPromotionPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Setono\SyliusCatalogPromotionPlugin\Model\PromotionInterface;
use Setono\SyliusCatalogPromotionPlugin\Repository\PromotionRepositoryInterface;
use Webmozart\Assert\Assert;

final class DiscountContext implements Context
{
    /** @var PromotionRepositoryInterface */
    private $promotionRepository;

    public function __construct(PromotionRepositoryInterface $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    /**
     * @Transform /^promotion "([^"]+)"$/
     * @Transform /^"([^"]+)" promotion/
     * @Transform :promotion
     */
    public function getDiscountByName($promotionName): PromotionInterface
    {
        /** @var PromotionInterface $promotion */
        $promotion = $this->promotionRepository->findOneBy(['name' => $promotionName]);

        Assert::notNull($promotion, sprintf('Discount with name "%s" does not exist', $promotionName));

        return $promotion;
    }
}
