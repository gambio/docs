<?php
/* --------------------------------------------------------------
   WithEventModule.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\ListingSample\WithEvent;

use Gambio\Core\Application\Modules\AbstractModule;
use Gambio\Shop\Sample\Listings\Event\ExtendFilterEvent;
use Gambio\Shop\Sample\Listings\Event\ListingCollectedEvent;
use GXModules\ListingSample\WithEvent\Listener\AllListingsConfigBasedSampleListener;
use GXModules\ListingSample\WithEvent\Listener\AllListingsSampleListener;
use GXModules\ListingSample\WithEvent\Listener\ExtendFilterSampleListener;

class WithEventModule extends AbstractModule
{
    public function eventListeners(): ?array
    {
        return [
            ListingCollectedEvent::class => [
                AllListingsSampleListener::class,
                AllListingsConfigBasedSampleListener::class,
            ],
            ExtendFilterEvent::class     => [
                ExtendFilterSampleListener::class,
            ],
        ];
    }
}