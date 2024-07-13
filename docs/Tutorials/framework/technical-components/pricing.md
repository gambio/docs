# Pricing

For managing or determining prices we currently don't have a specific application server by hand, but currently we can
provide you the `Gambio\Admin\Modules\Price\Services\ProductPriceConversionService` service that allows you to convert
net prices into gross prices (and vice versa). The service minds the gross-admin configuration and automatically fetches
the specific tax rates based on the tax zone of the shop.

!!! Notice "Notice"
    There will be further services to manage and determining prices in general in the future.


The following example gives you an idea of how to use it:

```php
namespace GXModules\<Vendor>\<Module>;

use Gambio\Admin\Modules\Price\Services\ProductPriceConversionService;

/**
 * Class SampleClass
 * @package GXModules\<Vendor>\<Module>
 */
class SampleClass
{
    /**
     * @var ProductPriceConversionService
     */
    private $priceConversion;


    /**
     * SampleClass constructor.
     *
     * @param ProductPriceConversionService $priceConversionService
     */
    public function __construct(ProductPriceConversionService $priceConversionService)
    {
        $this->priceConversion = $priceConversionService;
    }


    /**
     * @param int   $productId
     * @param float $grossPrice
     *
     * @return float
     */
    public function getProductsNetPrice(int $productId, float $grossPrice): float
    {
        return $this->priceConversion->getNetPrice($grossPrice, $productId);
    }


    /**
     * @param int   $productId
     * @param float $netPrice
     *
     * @return float
     */
    public function getProductsGrossPrice(int $productId, float $netPrice): float
    {
        return $this->priceConversion->getGrossPrice($netPrice, $productId);
    }
}
```

!!! Notice "Notice"
    This example expects you to use the [Service Provider] to register your classes to the [Application Core]. If you are
    using the legacy architecture, you need to fetch this service using the [Legacy DI Container].


[Application Core]: ./../application-core.md
[Service Provider]: ./../details/service-provider.md
[Legacy DI Container]: ./../details/di-container.md#legacy-di-container