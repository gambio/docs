<?php
/* --------------------------------------------------------------
   AllListingsConfigBasedSampleExtender.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\ListingSample\WithExtender\Extender;

use Gambio\Core\Configuration\Services\ConfigurationFinder;
use Gambio\Shop\Sample\Listings\Extender\ListingExtender;
use Gambio\Shop\Sample\Listings\Filter\ListingFilter;
use Gambio\Shop\Sample\Listings\Model\Listing;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;
use Gambio\Shop\Sample\Listings\Model\ListingItemIds;

/**
 * This example is similar to the AllListingsSampleExtender example, but uses a core service to determine
 * if the listing should be extended.
 *
 * This demonstrates a slightly more complex use case. All components which are registered in the DI-Container can
 * be injected.
 */
class AllListingsConfigBasedSampleExtender implements ListingExtender
{
    private const LISTENER_NAMESPACE = 'sample-all-config-based-extender';
    
    private ConfigurationFinder $configurationFinder;
    
    
    public function __construct(ConfigurationFinder $configurationFinder)
    {
        $this->configurationFinder = $configurationFinder;
    }
    
    
    public function extend(Listing $listing, ListingFilter $filter): void
    {
        if (!$this->isEnabled($this->configurationFinder->get('some-configuration'))) {
            return;
        }
        $firstItemId  = new ListingItemId(1);
        $secondItemId = new ListingItemId(2);
        $sampleIds    = new ListingItemIds($firstItemId, $secondItemId);
        
        $listing->extendItem($firstItemId, static::LISTENER_NAMESPACE, 'value');
        $listing->extendItems($sampleIds, static::LISTENER_NAMESPACE, 'value');
        $listing->extendListing(static::LISTENER_NAMESPACE, 'value');
    }
    
    
    private function isEnabled(?string $configuration): bool
    {
        $enabled = ['true', '1', 'on'];
        
        return in_array(strtolower((string)$configuration), $enabled);
    }
}