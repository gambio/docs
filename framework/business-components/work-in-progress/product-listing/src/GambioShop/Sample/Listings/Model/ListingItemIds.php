<?php
/* --------------------------------------------------------------
   ListingItemIds.php 2021-12-21
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings\Model;

class ListingItemIds
{
    /**
     * @var ListingItemId[]
     */
    private array $ids;
    
    
    public function __construct(ListingItemId ...$ids)
    {
        $this->ids = $ids;
    }
    
    
    public function contains(ListingItemId $id): bool
    {
        foreach ($this->ids as $itemId) {
            if ($itemId->equals($id)) {
                return true;
            }
        }
        
        return false;
    }
}