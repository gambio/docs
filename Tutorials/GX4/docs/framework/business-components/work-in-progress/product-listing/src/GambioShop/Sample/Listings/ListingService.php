<?php
/* --------------------------------------------------------------
   ListingService.php 2021-12-21
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings;

use Gambio\Shop\Sample\Listings\Event\ListingCollectedEvent;
use Gambio\Shop\Sample\Listings\Extender\ListingExtender;
use Gambio\Shop\Sample\Listings\Filter\ListingFilter;
use Gambio\Shop\Sample\Listings\Model\Listing;
use Psr\EventDispatcher\EventDispatcherInterface;

class ListingService
{
    private EventDispatcherInterface $eventDispatcher;
    
    /**
     * @var ListingExtender[]
     */
    private array $extenders = [];
    
    
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
    
    
    public function getListing(ListingFilter $filter, ListingPagination $pagination): Listing
    {
        $listing = ListingRepository::getSampleListing();
        
        foreach ($this->extenders as $extender) {
            $extender->extend($listing, $filter);
        }
        
        if ($event = $filter->getFilterEvent($listing)) {
            $this->eventDispatcher->dispatch($event);
        }
        $this->eventDispatcher->dispatch(new ListingCollectedEvent($listing));
        
        return $listing;
    }
    
    
    public function registerExtender(ListingExtender $extender): void
    {
        $this->extenders[get_class($extender)] = $extender;
    }
}