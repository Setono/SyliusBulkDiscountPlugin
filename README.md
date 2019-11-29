# Sylius Catalog Promotions Plugin

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Quality Score][ico-code-quality]][link-code-quality]

Plugin for Sylius to define permanent or time-limited promotions for products and automatically update prices.

![Screenshot showing specials admin page](docs/admin-create.png)

## Install

### Add plugin to composer.json

```bash
composer require setono/sylius-catalog-promotions-plugin
```

### Register plugin

```php
<?php
# config/bundles.php

return [
    // ...
    Setono\SyliusCatalogPromotionsPlugin\SetonoSyliusCatalogPromotionsPlugin::class => ['all' => true],
    Sylius\Bundle\GridBundle\SyliusGridBundle::class => ['all' => true],
    // ...
];

```

**Note**, that we MUST define `SetonoSyliusCatalogPromotionsPlugin` BEFORE `SyliusGridBundle`.
Otherwise you'll see exception like this:

```bash
You have requested a non-existent parameter "setono_sylius_catalog_promotions.model.promotion.class".  
```

### Add config

```yaml
# config/packages/_sylius.yaml
imports:
    - { resource: "@SetonoSyliusCatalogPromotionsPlugin/Resources/config/app/config.yaml" }
```

### Add routing

```yaml
# config/routes.yaml
setono_sylius_catalog_promotions_admin:
    resource: "@SetonoSyliusCatalogPromotionsPlugin/Resources/config/admin_routing.yaml"
    prefix: /admin
```

### Extend core classes
#### Extend `ChannelPricing`
```php
<?php

declare(strict_types=1);

namespace App\Entity;

use Setono\SyliusCatalogPromotionsPlugin\Model\ChannelPricingInterface;
use Setono\SyliusCatalogPromotionsPlugin\Model\ChannelPricingTrait;
use Sylius\Component\Core\Model\ChannelPricing as BaseChannelPricing;

class ChannelPricing extends BaseChannelPricing implements ChannelPricingInterface
{
    use ChannelPricingTrait;
}
```

#### Extend `ChannelPricingRepository`
```php
<?php

declare(strict_types=1);

namespace App\Repository;

use Setono\SyliusCatalogPromotionsPlugin\Doctrine\ORM\ChannelPricingRepositoryTrait;
use Setono\SyliusCatalogPromotionsPlugin\Repository\ChannelPricingRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ChannelPricingRepository extends EntityRepository implements ChannelPricingRepositoryInterface
{
    use ChannelPricingRepositoryTrait;
}
```

#### Extend `ProductRepository`
```php
<?php

declare(strict_types=1);

namespace App\Repository;

use Setono\SyliusCatalogPromotionsPlugin\Doctrine\ORM\ProductRepositoryTrait;
use Setono\SyliusCatalogPromotionsPlugin\Repository\ProductRepositoryInterface;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;

class ProductRepository extends BaseProductRepository implements ProductRepositoryInterface
{
    use ProductRepositoryTrait;
}
```

#### Extend `ProductVariantRepository`
```php
<?php

declare(strict_types=1);

namespace App\Repository;

use Setono\SyliusCatalogPromotionsPlugin\Doctrine\ORM\ProductVariantRepositoryTrait;
use Setono\SyliusCatalogPromotionsPlugin\Repository\ProductVariantRepositoryInterface;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductVariantRepository as BaseProductVariantRepository;

class ProductVariantRepository extends BaseProductVariantRepository implements ProductVariantRepositoryInterface
{
    use ProductVariantRepositoryTrait;
}
```

#### Update config with extended classes
In your `config/packages/_sylius.yaml` file update the configured classes:

```yaml
sylius_core:
    resources:
        channel_pricing:
            classes:
                model: App\Entity\ChannelPricing
                repository: App\Repository\ChannelPricingRepository

sylius_product:
    resources:
        product:
            classes:
                repository: App\Repository\ProductRepository
        product_variant:
            classes:
                repository: App\Repository\ProductVariantRepository

```

### Update your schema

Create a migration file:

```bash
$ php bin/console doctrine:migrations:diff
```

If you have existing discounted products you should append this line to the `up` method in the migration file:
```php
<?php
namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191028134956 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // The generated SQL will be here
        // ...
        
        // append this line
        $this->addSql('UPDATE sylius_channel_pricing SET manually_discounted = 1 WHERE original_price IS NOT NULL AND price != original_price');
    }

    public function down(Schema $schema) : void
    {
        // ...
    }
}
```

Execute migration file:
```bash
$ php bin/console doctrine:migrations:migrate
```

### Install assets

```bash
bin/console sylius:install:assets
```

### Configure CRON to run next command every minute

```bash
$ php bin/console setono:sylius-catalog-promotions:process
```

[ico-version]: https://poser.pugx.org/setono/sylius-catalog-promotions-plugin/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/sylius-catalog-promotions-plugin/v/unstable
[ico-license]: https://poser.pugx.org/setono/sylius-catalog-promotions-plugin/license
[ico-github-actions]: https://github.com/Setono/SyliusCatalogPromotionsPlugin/workflows/CI/badge.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/SyliusCatalogPromotionsPlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/sylius-catalog-promotions-plugin
[link-github-actions]: https://github.com/Setono/SyliusCatalogPromotionsPlugin/actions
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/SyliusCatalogPromotionsPlugin
