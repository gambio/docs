<?php
/* --------------------------------------------------------------
   AllListingsSampleExtender.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\ListingSample\WithExtender\Extender;

use Gambio\Shop\Sample\Listings\Extender\ListingExtender;
use Gambio\Shop\Sample\Listings\Filter\ListingFilter;
use Gambio\Shop\Sample\Listings\Model\Listing;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;
use Gambio\Shop\Sample\Listings\Model\ListingItemIds;

/**
 * Example to extend product listing with an extender.
 *
 * This extender is executed for all product listings, because it does not use the filter argument to restrict
 * the extensions.
 *
 * The extender implementor must decide when to extend and what items should be extended.
 */
class AllListingsSampleExtender implements ListingExtender
{
    private const LISTENER_NAMESPACE = 'sample-all-extender';
    
    
    public function extend(Listing $listing, ListingFilter $filter): void
    {
        // extend listing based on current listing items
        
        // this sample would extend all listing items with an id below 10
        $listingItemIds = $listing->getListingItemIds();
        foreach ($listingItemIds as $listingItemId) {
            if ($listingItemId->asInt() < 10) {
                $listing->extendItem($listingItemId, '[namespace]', 'value');
            }
        }
        
        // alternatively, the listing can be extended manually
        $firstItemId  = new ListingItemId(1);
        $secondItemId = new ListingItemId(2);
        $sampleIds    = new ListingItemIds($firstItemId, $secondItemId);
        
        $listing->extendItem($firstItemId, static::LISTENER_NAMESPACE, 'value');
        $listing->extendItems($sampleIds, static::LISTENER_NAMESPACE, 'value');
        $listing->extendListing(static::LISTENER_NAMESPACE, 'value');
    }
}