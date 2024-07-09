<?php
/* --------------------------------------------------------------
   ListingRepository.php 2021-12-21
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings;

use Gambio\Shop\Sample\Listings\Model\Listing;
use Gambio\Shop\Sample\Listings\Model\ListingItem;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;

class ListingRepository
{
    public static function getSampleListing(): Listing
    {
        $items = [];
        $id    = 1;
        
        for ($i = 0; $i < 20; $i++) {
            $name    = "Sample product $id";
            $items[] = new ListingItem(new ListingItemId($id), $name);
            $id++;
        }
        
        return new Listing(...$items);
    }
}