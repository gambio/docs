<?php
/* --------------------------------------------------------------
   __listing_example.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace Example;

use Gambio\Admin\Application\GambioAdminBootstrapper;
use Gambio\Core\Application\Application;
use Gambio\Core\Application\DependencyInjection\Abstraction\LeagueContainer;
use Gambio\Shop\Sample\Listings\Filter\ExtendFilter;
use Gambio\Shop\Sample\Listings\Filter\SimpleFilter;
use Gambio\Shop\Sample\Listings\ListingPagination;
use Gambio\Shop\Sample\Listings\ListingService;
use Gambio\Shop\Sample\Listings\ListingServiceProvider;

ini_set('display_errors', '1');

require_once __DIR__ . '/vendor/autoload.php';

$application = new Application(LeagueContainer::create());
(new GambioAdminBootstrapper())->boot($application);
$application->registerProvider(ListingServiceProvider::class);

/** @var ListingService $service */
$service = $application->get(ListingService::class);

$simpleFilter = new SimpleFilter();
$extendFilter = new ExtendFilter();
$pagination   = new class implements ListingPagination { };

$sampleListing   = $service->getListing($simpleFilter, $pagination);
$extendedListing = $service->getListing($extendFilter, $pagination);
print_r($sampleListing->toArray());
print_r($extendedListing->toArray());
