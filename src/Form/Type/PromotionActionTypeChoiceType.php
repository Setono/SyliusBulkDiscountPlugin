<?php

declare(strict_types=1);

namespace Setono\SyliusCatalogPromotionPlugin\Form\Type;

use Setono\SyliusCatalogPromotionPlugin\Model\Promotion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PromotionActionTypeChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => [
                'setono_sylius_catalog_promotion.form.promotion_action_type.choice.off' => Promotion::ACTION_TYPE_OFF,
                'setono_sylius_catalog_promotion.form.promotion_action_type.choice.increase' => Promotion::ACTION_TYPE_INCREASE,
            ],
            'empty_data' => Promotion::ACTION_TYPE_OFF,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_catalog_promotion_promotion_action_type_choice';
    }
}