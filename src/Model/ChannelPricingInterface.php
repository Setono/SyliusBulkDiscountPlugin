<?php

declare(strict_types=1);

namespace Setono\SyliusCatalogPromotionPlugin\Model;

use Sylius\Component\Core\Model\ChannelPricingInterface as BaseChannelPricingInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface ChannelPricingInterface extends BaseChannelPricingInterface, TimestampableInterface
{
    public function hasDiscount(): bool;

    public function getDiscountAmount(): ?int;

    /**
     * If $asInteger is true it returns the discount rounded to the nearest whole number
     */
    public function getDisplayableDiscount(bool $asInteger = false): ?float;

    /**
     * @return bool Returns true if this was discounted manually
     */
    public function isManuallyDiscounted(): bool;

    /**
     * todo we need to update this via the resource controller events
     */
    public function setManuallyDiscounted(bool $manuallyDiscounted): void;

    public function getMultiplier(): float;

    public function getBulkIdentifier(): ?string;

    public function resetBulkIdentifier(): void;
}
