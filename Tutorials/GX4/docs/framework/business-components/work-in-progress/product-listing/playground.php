<?php
/* --------------------------------------------------------------
   playground.php 2021-11-26
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Playground;

use Gambio\Core\Application\Application;
use Gambio\Core\Application\DependencyInjection\Abstraction\LeagueContainer;
use Gambio\Shop\Sample\ProductListing\Filter\SpecialsFilter;
use Gambio\Shop\Sample\ProductListing\Filter\TopProductsFilter;
use Gambio\Shop\Sample\ProductListing\Services\ListingItemCollection;
use Gambio\Shop\Sample\ProductListing\Services\ListingPagination;
use Gambio\Shop\Sample\ProductListing\Services\ListingService;

function display(ListingItemCollection $data): string
{
    return print_r($data, true);
}

// boot application
$application = new Application(LeagueContainer::create());

// get service from di container
/** @var ListingService $listingService */
$listingService = $application->get(ListingService::class);

// somehow create pagination and filters
$pagination = new class implements ListingPagination { };

$topProductsFilter = $application->get(TopProductsFilter::class);
$specialsFilter    = $application->get(SpecialsFilter::class);

// get listing data and do something with it
$topListing      = $listingService->getListing($topProductsFilter, $pagination);
$specialsListing = $listingService->getListing($specialsFilter, $pagination);

echo display($topListing);
echo display($specialsListing);
