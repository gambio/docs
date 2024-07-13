<?php
/* --------------------------------------------------------------
   WithExtenderServiceProvider.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\ListingSample\WithExtender;

use Gambio\Core\Application\DependencyInjection\AbstractModuleBootableServiceProvider;
use Gambio\Core\Application\ValueObjects\Environment;
use Gambio\Core\Configuration\Services\ConfigurationFinder;
use Gambio\Shop\Sample\Listings\ListingService;
use GXModules\ListingSample\WithExtender\Extender\AllListingsConfigBasedSampleExtender;
use GXModules\ListingSample\WithExtender\Extender\AllListingsSampleExtender;
use GXModules\ListingSample\WithExtender\Extender\ExtendFilterSampleExtender;

class WithExtenderServiceProvider extends AbstractModuleBootableServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->application->inflect(ListingService::class)
            ->invokeMethod('registerExtender', [AllListingsSampleExtender::class]);
        $this->application->inflect(ListingService::class)
            ->invokeMethod('registerExtender', [AllListingsConfigBasedSampleExtender::class]);
        $this->application->inflect(ListingService::class)
            ->invokeMethod('registerExtender', [ExtendFilterSampleExtender::class]);
    }
    
    
    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            AllListingsSampleExtender::class,
            AllListingsConfigBasedSampleExtender::class,
            ExtendFilterSampleExtender::class,
        ];
    }
    
    
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->application->register(AllListingsSampleExtender::class);
        $this->application->register(AllListingsConfigBasedSampleExtender::class)
            ->addArgument(ConfigurationFinder::class);
        $this->application->register(ExtendFilterSampleExtender::class)
            ->addArgument(Environment::class);
    }
}