<?php
/* --------------------------------------------------------------
   AllListingsSampleListener.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\ListingSample\WithEvent\Listener;

use Gambio\Shop\Sample\Listings\Event\ListingCollectedEvent;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;
use Gambio\Shop\Sample\Listings\Model\ListingItemIds;

/**
 * Example to extend product listing with events and listeners.
 *
 * This event listener is executed for all product listings, because it is attached to the
 * Gambio\Shop\Sample\Listings\Event\ListingCollectedEvent event which is dispatched no matter what filter is used.
 *
 * The listener implementor must decide when to extend and what items should be extended.
 */
class AllListingsSampleListener
{
    private const LISTENER_NAMESPACE = 'sample-all-listener';
    
    
    public function __invoke(ListingCollectedEvent $event): ListingCollectedEvent
    {
        // extend listing based on current listing items
        
        // this sample would extend all listing items with an id below 10
        $listingItemIds = $event->getListingItemIds();
        foreach ($listingItemIds as $listingItemId) {
            if ($listingItemId->asInt() < 10) {
                $event->extendItem($listingItemId, '[namespace]', 'value');
            }
        }
        
        // alternatively, the listing can be extended manually
        $firstItemId  = new ListingItemId(1);
        $secondItemId = new ListingItemId(2);
        $sampleIds    = new ListingItemIds($firstItemId, $secondItemId);
        
        $event->extendItem($firstItemId, static::LISTENER_NAMESPACE, 'value');
        $event->extendItems($sampleIds, static::LISTENER_NAMESPACE, 'value');
        $event->extendListing(static::LISTENER_NAMESPACE, 'value');
        
        return $event;
    }
}