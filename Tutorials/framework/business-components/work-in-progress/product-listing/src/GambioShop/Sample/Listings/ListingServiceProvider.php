<?php
/* --------------------------------------------------------------
   ListingServiceProvider.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Gambio\Shop\Sample\Listings;

use Gambio\Core\Application\DependencyInjection\AbstractServiceProvider;
use Psr\EventDispatcher\EventDispatcherInterface;

class ListingServiceProvider extends AbstractServiceProvider
{
    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            ListingService::class,
        ];
    }
    
    
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->application->registerShared(ListingService::class)->addArgument(EventDispatcherInterface::class);
    }
}