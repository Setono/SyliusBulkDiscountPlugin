<?php

declare(strict_types=1);

namespace Setono\SyliusCatalogPromotionsPlugin\Fixture\Factory;

use Setono\SyliusCatalogPromotionsPlugin\Factory\PromotionRuleFactoryInterface;
use Setono\SyliusCatalogPromotionsPlugin\Model\PromotionRuleInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionRuleExampleFactory extends AbstractExampleFactory
{
    /** @var PromotionRuleFactoryInterface */
    protected $promotionRuleFactory;

    /** @var array */
    protected $promotionRules;

    /** @var OptionsResolver */
    protected $optionsResolver;

    public function __construct(PromotionRuleFactoryInterface $promotionRuleFactory, array $promotionRules)
    {
        $this->promotionRuleFactory = $promotionRuleFactory;
        $this->promotionRules = $promotionRules;

        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    public function create(array $options = []): PromotionRuleInterface
    {
        $options = $this->optionsResolver->resolve($options);

        return $this->promotionRuleFactory->createByType(
            $options['type'],
            $options['configuration']
        );
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('type', function (): string {
                $promotionRuleCodes = array_keys($this->promotionRules);

                return $promotionRuleCodes[array_rand($promotionRuleCodes)];
            })
            ->setDefined('configuration')
            ->setAllowedTypes('configuration', ['string', 'array'])
        ;
    }
}
