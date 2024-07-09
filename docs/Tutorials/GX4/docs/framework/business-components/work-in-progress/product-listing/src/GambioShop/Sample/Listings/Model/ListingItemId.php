<?php
/* --------------------------------------------------------------
   ListingItemId.php 2021-12-21
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings\Model;

class ListingItemId
{
    private int $id;
    
    
    public function __construct(int $id)
    {
        $this->id = $id;
    }
    
    
    public function equals(self $other): bool
    {
        return $this->id === $other->id;
    }
    
    
    public function asInt(): int
    {
        return $this->id;
    }
}