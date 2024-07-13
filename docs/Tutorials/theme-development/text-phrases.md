# Working with language files

You can easily create individual text phrases for each theme.


## Directory structure

All text phrases are placed into the `TextPhrases` folder of a theme. There a separate directory is created for each
language, as you can see below:

- `german`
- `english`

In these language directories `.php` files containing the text phrases are created. We can look at how the
folder structure for text phrases is structured below:

```
Darkness
 └─ TextPhrases
     ├─ english
     │   └─ darkness.lang.inc.php
     └─ german
         └─ darkness.lang.inc.php
```


## Text phrase file anatomy

A text phrase file always has the extension `lang.inc.php` and contains a two-dimensional PHP array called
`$t_language_text_section_content_array`. The content of the array is always structured according to the following
scheme: `Identifier => Phrase`.

This can be illustrated using the following example for a German text phrase file:
```php
$t_language_text_section_content_array = [
    'title' => 'Darkness',
    'description' => 'Das dunkle Theme mit starken Kontrasten'
];
```

For our `Darkness` theme we create the files `darkness.lang.inc.php` in the folders `german` and `english`, within
a `TextPhrases` folder for the languages German and English. We take the above example as file content and translate
it for the English text phrases file:

```php
$t_language_text_section_content_array = [
    'title' => 'Darkness',
    'description' => 'The dark theme with strong contrasts'
];
```

Now we should have the exact same folder structure as in the example shown above.
