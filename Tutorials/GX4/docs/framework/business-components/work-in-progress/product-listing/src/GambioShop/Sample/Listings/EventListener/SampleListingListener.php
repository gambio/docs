<?php
/* --------------------------------------------------------------
   SampleListingListener.php 2021-12-21
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings\EventListener;

use Gambio\Shop\Sample\Listings\Event\AbstractListingEvent;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;
use Gambio\Shop\Sample\Listings\Model\ListingItemIds;

class SampleListingListener
{
    public function __invoke(AbstractListingEvent $event): AbstractListingEvent
    {
        $this->extendFirstItem($event);
        $this->extendAllItemsWithIdBetween5And10($event);
        $this->extendList($event);
        
        return $event;
    }
    
    
    private function extendFirstItem(AbstractListingEvent $event): void
    {
        $event->extendItem(new ListingItemId(1), 'sample-first-item', ['payload' => 'data']);
    }
    
    
    private function extendAllItemsWithIdBetween5And10(AbstractListingEvent $event): void
    {
        $ids = [];
        for ($i = 5; $i <= 10; $i++) {
            $ids[] = new ListingItemId($i);
        }
        
        $event->extendItems(new ListingItemIds(...$ids), 'sample-five-to-ten', ['nested' => ['payload' => 'data']]);
    }
    
    
    private function extendList(AbstractListingEvent $event): void
    {
        $event->extendListing('sample-whole-listing', ['answer' => 42]);
    }
}