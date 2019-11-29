<?php

declare(strict_types=1);

namespace Setono\SyliusCatalogPromotionsPlugin\Form\Type;

use Sylius\Bundle\PromotionBundle\Form\Type\Core\AbstractConfigurationCollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PromotionRuleCollectionType extends AbstractConfigurationCollectionType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('entry_type', PromotionRuleType::class);
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_catalog_promotions_promotion_rule_collection';
    }
}
