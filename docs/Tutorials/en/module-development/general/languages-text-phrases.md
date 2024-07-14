# Adding languages and managing text phrases

In this tutorial you will learn how to create new texts and modify existing ones as well as the general use of
language phrases.


## Language file in general

### What is a language file and where can you find it?

By default, all texts are supplied from the database. With a language file it is possible to create and change
the text phrases used in the shop.

Language files for your module are stored in the `GXModules/<Vendor>/<Module>/Shop/TextPhrases/{Language}/`
directory. `{Language}` is a placeholder for a specific language, e.g. `German` or `English`.

!!! Notice "Important"
    The original texts are located exclusively in the `lang/{Language}/original_sections` directory. The database
    text phrases are created based on the original language files and other language files (e.g. from modules, etc.)
    as well as text adjustments that can be made in the Gambio Admin.


### What is a section?

Sections are used to categorize the text phrases. The following naming convention is used when creating a language
file: `<SectionName>.lang.inc.php` or `<SectionName>.<Additional>.lang.inc.php`.

`<Additional>`, for example, can be used for a sort number or to accommodate a developer or module name. This makes
sense especially if you want to extend an existing section and ensure that the file is not overwritten by a foreign
module that happens to use the same section.


### What are text phrases?

Text phrases are are divided into two parts - a phrase **name** and phrase **text**. The phrase name is the variable
name that is used later in the code to output the phrase text.


## Structure of the language files

The typical structure of a language file is as follows:

```php
$t_language_text_section_content_array = array(
    'phrasen_name' => 'A text phrase.',
    'button_ok'    => 'OK'
);
```

You can see that the phrase name *button_ok* has been assigned the phrase text `OK`.


### Extending a section by using `<Additional>`

If a new language file `buttons.module_name.lang.inc.php` is created, it extends the section `buttons` by a new
phrase. The structure is the same as before:

```php
$t_language_text_section_content_array = array(
    'button_cancel' => 'Abbrechen'
);
```

### Overwriting texts

To overwrite a text phrase, the language files must be created with the same section name
`<SectionName>.lang.inc.php`. Your language files have a higher priority than the original language files.
Individual adjustments still have the highest priority.


## Using the language files in ...

### PHP

In PHP you need to use the `Gambio\Core\Language\TextManager` component, which is explained in the [architecture and
framework part] of our documentation.


### Smarty template

To load a language file into Smarty, use the following instruction:


```
{load_language_text section="buttons"}
```

After, the individual text variables can be inserted within the template using `{$txt.PHRASEN_NAME}`
(e.g. `{$txt.street}` or `{$txt.city}`).

It is also possible to group the phrases of a section for the template by a specific name.

```
{load_language_text section="buttons" name="buttons"}
```

Doing so, you can access the text phrases using `{$buttons.PHRASEN_NAME}`, e.g. `{$buttons.button_cancel}`.

### Javascript

For JavaScript we provide a service method that can be used like this:

```js
// jse.core.lang.translate([PHRASEN_NAME], [JS_SECTION_NAME])
const buttonLabel = jse.core.lang.translate('paylink', 'paypal3');
```

#### Initialisation for the admin area

In the controller an array of all needed sections can be specified during the instantiation of the
`AdminPageHttpControllerResponse` object:

```php
return MainFactory::create('AdminPageHttpControllerResponse', $title, $html, null, ['buttons']);
```

#### Initialisation for the store area

Via the PHP class `JSEngineConfiguration` the needed sections for the JavaScript are loaded. To add your
sections, an overload of the method `_getSections` is necessary. For example:

```php
protected function _getSections()
{
    $additionalSection = array('js_section_name' => 'section_name');
    $this->sections = array_merge($this->sections, $additionalSection);
    
    return parent::_getSections();
}
```
The section `section_name` is now available under the name 'js_section_name' in JavaScript. Usually it makes
sense not to choose a different name for `js_section_name`, e.g. for loading the paypal3-section:

```php
protected function _getSections()
{
    $additionalSection = array('paypal3' => 'paypal3');
    $this->sections = array_merge($this->sections, $additionalSection);
    
    return parent::_getSections();
}
```

### Possible problems and solutions

- **Smarty template**:  
  By default, the text variables are provided with the prefix `txt`. If several language files are included,
  there may be conflicts with the names. To avoid conflicts when several language files are included, you can
  specify a prefix.
  ```
  {load_language_text section="buttons" name="button"}
  ```
  The texts from the section `buttons` are now available with the prefix `button`, e.g. `{$button.ok}`
  or `{button.cancel}`
- **The changes made to a language file are not displayed**:  
  After adding new language files, you should perform the following operations in the Admin section of
  the **Cache** page: **Clear the page output cache**, **Clear the module information cache** and **Clear
  the text cache**.
- **Manual changes in the database table language_phrases_cache are not displayed**:  
  This is a pure cache table where changes are out of place and lost. Changes can be made via language files
  or via the **adapt texts** function in the admin.
- In the event of text errors, check that the correct encoding has been selected for the language file:
  **UTF-8 without BOM**.


## Adding a new language

To add a new language you need to copy all language files of an existing language, which can be found
in the `lang` directory and translate all of its text phrases.



[architecture and framework part]: ./../../framework/technical-components/text-phrases.md


