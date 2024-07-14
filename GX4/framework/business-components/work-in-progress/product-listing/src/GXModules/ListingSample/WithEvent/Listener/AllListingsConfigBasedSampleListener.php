<?php
/* --------------------------------------------------------------
   AllListingsConfigBasedSampleListener.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\ListingSample\WithEvent\Listener;

use Gambio\Core\Configuration\Services\ConfigurationFinder;
use Gambio\Shop\Sample\Listings\Event\ListingCollectedEvent;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;
use Gambio\Shop\Sample\Listings\Model\ListingItemIds;

/**
 * This example is similar to the AllListingsSampleListener listener example, but uses a core service to determine
 * if the listing should be extended.
 *
 * This demonstrates a slightly more complex use case. All components which are registered in the DI-Container can
 * be injected.
 */
class AllListingsConfigBasedSampleListener
{
    private const LISTENER_NAMESPACE = 'sample-all-config-based-listener';
    
    private ConfigurationFinder $configurationFinder;
    
    
    public function __construct(ConfigurationFinder $configurationFinder)
    {
        $this->configurationFinder = $configurationFinder;
    }
    
    
    public function __invoke(ListingCollectedEvent $event): ListingCollectedEvent
    {
        if (!$this->isEnabled($this->configurationFinder->get('some-configuration'))) {
            return $event;
        }
        $firstItemId  = new ListingItemId(1);
        $secondItemId = new ListingItemId(2);
        $sampleIds    = new ListingItemIds($firstItemId, $secondItemId);
        
        $event->extendItem($firstItemId, static::LISTENER_NAMESPACE, 'value');
        $event->extendItems($sampleIds, static::LISTENER_NAMESPACE, 'value');
        $event->extendListing(static::LISTENER_NAMESPACE, 'value');
        
        return $event;
    }
    
    
    private function isEnabled(?string $configuration): bool
    {
        $enabled = ['true', '1', 'on'];
        
        return in_array(strtolower((string)$configuration), $enabled);
    }
}