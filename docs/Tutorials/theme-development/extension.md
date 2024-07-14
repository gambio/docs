# Extending a theme

In this part we will take a look at the power feature of the new theme system. We will create a new theme based on
_Malibu_ and in the following chapters we will design the new theme step by step.


## Creation of a theme

First we create a new theme. To do this, we navigate to the `theme` folder in our shop and create a new folder
called `Darkness`.


## Configuration file

Then we change to the created folder and create a new file `theme.json`. The `theme.json` is the configuration
file of the theme and contains important meta data in JSON format which is read by the shop.

We open the file `theme.json` and add the following:

```
{
  "id": "Darkness",
  "title": "Darkness",
  "extends": "Malibu",
  "author": "Gambio",
  "version": "1.0.0",
  "contents": {}
}
```

- The `id` identifies our theme. It has to be exactly the same as the folder name.
- The `title` describes the title of the theme - this can be specified freely. It is often similar to the `id` and the
  folder name, but is formatted differently. For example, the folder name and the `id` could be:
  `GambioChristmasSpecial`, and the `title` could then be called `Gambio's Christmas Special Theme`.
- The field `extends` is optional. If our theme extends another theme, we have to enter the `id` of that theme as the
  value. For example, if we want to inherit the theme `Malibu`, we have to enter `"extends": "Malibu"`. If, on the
  other hand, we want to create a completely new theme, we exclude this field.
- The optional `author` field describes the author of the theme.
- The `version` is optional and describes the version of the theme. The format adheres to
  [Semantic Versioning].
- The last field `contents` is also optional and can contain content manager entries. You will learn more about it
  in later chapters.



[Semantic Versioning]: https://semver.org
