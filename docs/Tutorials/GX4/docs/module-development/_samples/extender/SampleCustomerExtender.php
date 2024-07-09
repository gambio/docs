<?php
/* --------------------------------------------------------------
   SampleCustomerExtender.php 2021-07-20
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

declare(strict_types=1);

/**
 * Class SampleCustomerExtender
 *
 * This is a sample overload for the CustomerExtenderComponent.
 *
 * @see CustomerExtenderComponent
 */
class SampleCustomerExtender extends SampleCustomerExtender_parent
{
    public function proceed()
    {
        parent::proceed();
        
        // logic for handling POST data like storing it
        
        // logic for getting data to prefill fields
        
        $this->addPersonalField('Middle name:', '<input type="text" name="middle_name" maxlength="32" />');
        $this->addCompanyField('Location:', '<input type="text" name="location" maxlength="32" />');
        $this->addAddressField('Floor:', '<input type="text" name="floor" maxlength="32" />');
        $this->addContactField('Mobile number:', '<input type="tel" name="mobile_number" />');
        $this->addAdditionalField('Reference Code:', '<input type="text" name="reference_code" />');
        $this->addExtraHtml('<div><p>Some extra HTML</p></div>');
    }
}