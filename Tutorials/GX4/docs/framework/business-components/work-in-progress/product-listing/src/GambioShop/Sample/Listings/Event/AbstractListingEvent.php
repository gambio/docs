<?php
/* --------------------------------------------------------------
   AbstractListingEvent.php 2021-12-21
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings\Event;

use Gambio\Shop\Sample\Listings\Model\Listing;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;
use Gambio\Shop\Sample\Listings\Model\ListingItemIds;

class AbstractListingEvent
{
    private Listing $listing;
    
    
    public function __construct(Listing $listing)
    {
        $this->listing = $listing;
    }
    
    
    public function getListingItemIds(): ListingItemIds
    {
        return $this->listing->getListingItemIds();
    }
    
    
    public function extendItem(ListingItemId $id, string $namespace, $payload): void
    {
        $this->listing->extendItem($id, $namespace, $payload);
    }
    
    
    public function extendItems(ListingItemIds $ids, string $namespace, $payload): void
    {
        $this->listing->extendItems($ids, $namespace, $payload);
    }
    
    
    public function extendListing(string $namespace, $payload): void
    {
        $this->listing->extendListing($namespace, $payload);
    }
}