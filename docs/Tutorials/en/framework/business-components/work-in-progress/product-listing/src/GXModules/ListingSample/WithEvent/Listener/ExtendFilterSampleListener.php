<?php
/* --------------------------------------------------------------
   ExtendFilterSampleListener.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\ListingSample\WithEvent\Listener;

use Gambio\Core\Application\ValueObjects\Environment;
use Gambio\Shop\Sample\Listings\Event\ExtendFilterEvent;
use Gambio\Shop\Sample\Listings\Model\ListingItemId;
use Gambio\Shop\Sample\Listings\Model\ListingItemIds;

/**
 * This listener behaves similar like the AllListingsConfigBasedSampleListener listener
 * (but checks for environment instead of a configuration).
 *
 * The big difference is, that this listener is only executed for listings using the
 * Gambio\Shop\Sample\Listings\Filter\ExtendFilter, because the listener is attached to the
 * Gambio\Shop\Sample\Listings\Event\ExtendFilterEvent which is only dispatched when using that filter.
 */
class ExtendFilterSampleListener
{
    private const LISTENER_NAMESPACE = 'sample-extend-filter-listener';
    
    private Environment $environment;
    
    
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }
    
    
    public function __invoke(ExtendFilterEvent $event): ExtendFilterEvent
    {
        if (!$this->environment->isDev()) {
            return $event;
        }
        
        $firstItemId  = new ListingItemId(1);
        $secondItemId = new ListingItemId(2);
        $sampleIds    = new ListingItemIds($firstItemId, $secondItemId);
        
        $event->extendItem($firstItemId, static::LISTENER_NAMESPACE, 'value');
        $event->extendItems($sampleIds, static::LISTENER_NAMESPACE, 'value');
        $event->extendListing(static::LISTENER_NAMESPACE, 'value');
        
        return $event;
    }
}