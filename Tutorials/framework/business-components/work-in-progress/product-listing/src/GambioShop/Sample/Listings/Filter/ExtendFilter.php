<?php
/* --------------------------------------------------------------
   ExtendFilter.php 2021-12-21
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings\Filter;

use Gambio\Shop\Sample\Listings\Event\ExtendFilterEvent;
use Gambio\Shop\Sample\Listings\Model\Listing;
use Gambio\Shop\Sample\Listings\Model\ListingItemIds;

class ExtendFilter implements ListingFilter
{
    public function getFilterIds(): ListingItemIds
    {
        return new ListingItemIds();
    }
    
    
    public function getFilterEvent(Listing $listing): ?object
    {
        return new ExtendFilterEvent($listing);
    }
}