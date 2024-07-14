<?php
/* --------------------------------------------------------------
  ExampleWidget.php 2019-10-24
  Gambio GmbH
  http://www.gambio.de
  Copyright (c) 2019 Gambio GmbH
  Released under the GNU General Public License (Version 2)
  [http://www.gnu.org/licenses/gpl-2.0.html]
  --------------------------------------------------------------*/

use Gambio\StyleEdit\Core\Components\TextBox\Entities\TextBox;
use Gambio\StyleEdit\Core\Language\Entities\Language;
use Gambio\StyleEdit\Core\Widgets\Abstractions\AbstractWidget;

/**
 * Class ExampleWidget
 */
class ExampleWidget extends AbstractWidget
{
    /**
     * This property must exist because in the fieldset of the
     * widget.json is an input with the id text
     *
     * @var TextBox
     */
    protected $text;
    
    /**
     * This method will be executed upon saving your
     * widget content to the content zone html
     *
     * @param Language|null $currentLanguage
     *
     * @return string
     */
    public function htmlContent(?Language $currentLanguage): string
    {
        return $this->text->value($currentLanguage);
    }
    
    
    /**
     * This method will be executed to create the preview in StyleEdit
     *
     * @param Language|null $currentLanguage
     *
     * @return string
     */
    public function previewContent(?Language $currentLanguage): string
    {
        return $this->htmlContent($currentLanguage) . '&nbsp;<strong>not visible outside of StyleEdit4</strong>';
    }
    
    
    /**
     * Executed only upon saving
     */
    public function persist(): void
    {
        file_put_contents(__DIR__ . '/ExampleWidget.txt', 'This methods is only executed upon saving');
    }
    
    
    /**
     * Specify data which should be serialized to JSON
     * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $result            = $this->jsonObject;
        $result->fieldsets = $this->fieldsets;
        
        return $result;
    }
}