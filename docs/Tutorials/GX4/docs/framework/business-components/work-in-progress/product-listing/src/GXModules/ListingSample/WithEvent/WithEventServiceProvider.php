<?php
/* --------------------------------------------------------------
   WithEventServiceProvider.php 2021-12-22
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\ListingSample\WithEvent;

use Gambio\Core\Application\DependencyInjection\AbstractModuleServiceProvider;
use Gambio\Core\Application\ValueObjects\Environment;
use Gambio\Core\Configuration\Services\ConfigurationFinder;
use GXModules\ListingSample\WithEvent\Listener\AllListingsConfigBasedSampleListener;
use GXModules\ListingSample\WithEvent\Listener\AllListingsSampleListener;
use GXModules\ListingSample\WithEvent\Listener\ExtendFilterSampleListener;

class WithEventServiceProvider extends AbstractModuleServiceProvider
{
    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            AllListingsSampleListener::class,
            AllListingsConfigBasedSampleListener::class,
            ExtendFilterSampleListener::class,
        ];
    }
    
    
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->application->register(AllListingsSampleListener::class);
        $this->application->register(AllListingsConfigBasedSampleListener::class)
            ->addArgument(ConfigurationFinder::class);
        $this->application->register(ExtendFilterSampleListener::class)
            ->addArgument(Environment::class);
    }
}