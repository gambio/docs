<?php
/* --------------------------------------------------------------
   ProductListingCollectedEventListener.php 2021-12-01
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\GambioDev\CrossProductGraduatedPrices;

use Gambio\Shop\Sample\Listings\Event\ListingCollectedEvent;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;

/**
 * Example event listener for product listings.
 *
 * This event listener simulates a module which functionality is to provide cross product graduated prices.
 * Cross products graduated prices are e.g. if you can choose between 10 different T-Shirts and the price of
 * one unit is 10 €, five unit 8 € (per unit) and at ten units for 5 € (per unit) for example.
 *
 * The module somehow checks if listing items are affected by cross product graduated prices and if yes,
 * the graduated price for that item has to be determined somehow, and it must be attached to the listings' data
 * structure.
 *
 * Attaching additional data to product listing items can be done by using the events API method:
 *
 * ```php
 *  $event->extendItem(
 *      ProductListingItemId::fromInt($productListingId),
 *      '[additional_data_namespace]',
 *      'data of any type can be passed'
 * );
 * ```
 */
class CrossProductGraduatedPricesEventListener
{
    private const ADDITIONAL_DATA_NAMESPACE = 'gx_cross_product_graduated_prices';
    
    private const SAMPLE_PRODUCT_IDS = [
        1,
        // ..
    ];
    
    private const SAMPLE_GRADUATED_PRICES = [
        [
            'quantity' => 1,
            'price'    => 99.99,
        ],
        // ...
    ];
    
    
    public function __invoke(ListingCollectedEvent $event): ListingCollectedEvent
    {
        $productListingIds = $event->getListingItemIds();
        
        foreach ($productListingIds as $productListingId) {
            if ($this->hasCrossProductGraduatedPrices($productListingId)) {
                $event->extendItem($productListingId,
                                   static::ADDITIONAL_DATA_NAMESPACE,
                                   static::SAMPLE_GRADUATED_PRICES);
            }
        }
        
        return $event;
    }
    
    
    private function hasCrossProductGraduatedPrices(ListingItemId $listingItemId): bool
    {
        return in_array($listingItemId->asInt(), static::SAMPLE_PRODUCT_IDS, true);
    }
}