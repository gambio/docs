<?php
/* --------------------------------------------------------------
   FooBarServiceProvider.php 2021-12-01
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

namespace GXModules\GambioDev\CrossProductGraduatedPrices;

use Gambio\Core\Application\DependencyInjection\AbstractModuleServiceProvider;

class CrossProductGraduatedPricesServiceProvider extends AbstractModuleServiceProvider
{
    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            CrossProductGraduatedPricesEventListener::class,
        ];
    }
    
    
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->application->registerShared(CrossProductGraduatedPricesEventListener::class);
    }
}