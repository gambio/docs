<?php
/* --------------------------------------------------------------
   Listing.php 2021-12-21
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings\Model;

use ArrayIterator;

class Listing implements \IteratorAggregate
{
    private array $items;
    
    
    public function __construct(ListingItem ...$items)
    {
        $this->items = $items;
    }
    
    
    public function extendItem(ListingItemId $id, string $namespace, $payload): void
    {
        foreach ($this->items as $item) {
            if ($id->equals($item->getId())) {
                $item->extend($namespace, $payload);
            }
        }
    }
    
    
    public function extendItems(ListingItemIds $ids, string $namespace, $payload): void
    {
        foreach ($this->items as $item) {
            if ($ids->contains($item->getId())) {
                $item->extend($namespace, $payload);
            }
        }
    }
    
    
    public function extendListing(string $namespace, $payload): void
    {
        foreach ($this->items as $item) {
            $item->extend($namespace, $payload);
        }
    }
    
    
    public function getListingItemIds(): ListingItemIds
    {
        $ids = [];
        foreach ($this->items as $item) {
            $ids[] = $item->getId();
        }
        
        return new ListingItemIds(...$ids);
    }
    
    
    public function toArray(): array
    {
        $data = [];
        foreach ($this->items as $item) {
            $data[] = $item->toArray();
        }
        
        return $data;
    }
    
    
    /**
     * @return iterable|ListingItem[]
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->items);
    }
}