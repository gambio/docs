<?php
/* --------------------------------------------------------------
   ListingItem.php 2021-12-21
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings\Model;

class ListingItem
{
    private ListingItemId $id;
    
    private string        $name;
    
    private array         $extensions = [];
    
    
    public function __construct(ListingItemId $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }
    
    
    public function extend(string $namespace, $payload): void
    {
        $this->extensions[$namespace] = $payload;
    }
    
    
    public function getId(): ListingItemId
    {
        return $this->id;
    }
    
    
    public function toArray(): array
    {
        return [
            'id'         => $this->id->asInt(),
            'name'       => $this->name,
            'extensions' => $this->extensions,
        ];
    }
}