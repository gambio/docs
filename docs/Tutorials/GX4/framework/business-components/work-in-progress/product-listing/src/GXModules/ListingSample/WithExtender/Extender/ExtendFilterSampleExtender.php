<?php
/* --------------------------------------------------------------
   ExtendFilterSampleExtender.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\ListingSample\WithExtender\Extender;

use Gambio\Core\Application\ValueObjects\Environment;
use Gambio\Shop\Sample\Listings\Extender\ListingExtender;
use Gambio\Shop\Sample\Listings\Filter\ExtendFilter;
use Gambio\Shop\Sample\Listings\Filter\ListingFilter;
use Gambio\Shop\Sample\Listings\Model\Listing;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;
use Gambio\Shop\Sample\Listings\Model\ListingItemIds;

/**
 * This extender behaves similar like the AllListingsConfigBasedSampleExtender
 * (but checks for environment instead of a configuration).
 *
 * The big difference is, that this extender is only executed for listings using the
 * Gambio\Shop\Sample\Listings\Filter\ExtendFilter, because we check that the filter
 * is an instance of that class (Line: 47).
 */
class ExtendFilterSampleExtender implements ListingExtender
{
    private const LISTENER_NAMESPACE = 'sample-extend-filter-extender';
    
    private Environment $environment;
    
    
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }
    
    
    public function extend(Listing $listing, ListingFilter $filter): void
    {
        if (!$filter instanceof ExtendFilter || !$this->environment->isDev()) {
            return;
        }
        
        $firstItemId  = new ListingItemId(1);
        $secondItemId = new ListingItemId(2);
        $sampleIds    = new ListingItemIds($firstItemId, $secondItemId);
        
        $listing->extendItem($firstItemId, static::LISTENER_NAMESPACE, 'value');
        $listing->extendItems($sampleIds, static::LISTENER_NAMESPACE, 'value');
        $listing->extendListing(static::LISTENER_NAMESPACE, 'value');
    }
}