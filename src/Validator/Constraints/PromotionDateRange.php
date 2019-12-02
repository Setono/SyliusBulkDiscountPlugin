<?php

declare(strict_types=1);

namespace Setono\SyliusCatalogPromotionPlugin\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class PromotionDateRange extends Constraint
{
    /** @var string */
    public $message = 'setono_sylius_catalog_promotion.promotion.end_date_cannot_be_set_prior_start_date';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return 'setono_sylius_catalog_promotion_promotion_date_range_validator';
    }
}
