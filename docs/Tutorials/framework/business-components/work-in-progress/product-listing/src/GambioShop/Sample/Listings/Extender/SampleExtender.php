<?php
/* --------------------------------------------------------------
   SampleExtender.php 2021-12-21
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings\Extender;

use Gambio\Shop\Sample\Listings\Filter\ListingFilter;
use Gambio\Shop\Sample\Listings\Model\Listing;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;
use Gambio\Shop\Sample\Listings\Model\ListingItemIds;

class SampleExtender implements ListingExtender
{
    public function extend(Listing $listing, ListingFilter $filter): void
    {
        $this->extendFirstItem($listing);
        $this->extendAllItemsWithIdBetween5And10($listing);
        $this->extendList($listing);
    }
    
    
    private function extendFirstItem(Listing $listing): void
    {
        $listing->extendItem(new ListingItemId(1), 'sample-first-item', ['payload' => 'data']);
    }
    
    
    private function extendAllItemsWithIdBetween5And10(Listing $listing): void
    {
        $ids = [];
        for ($i = 5; $i <= 10; $i++) {
            $ids[] = new ListingItemId($i);
        }
        
        $listing->extendItems(new ListingItemIds(...$ids), 'sample-five-to-ten', ['nested' => ['payload' => 'data']]);
    }
    
    
    private function extendList(Listing $listing): void
    {
        $listing->extendListing('sample-whole-listing', ['answer' => 42]);
    }
}