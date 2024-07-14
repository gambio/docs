# Adding and extending CSS

Adding and extending CSS is quite simple and similar to the extension of HTML. The theme system allows to entirely
modify the existing CSS content of a specific theme.


## Modifying the CSS of a theme by creating a new one

The theme system allows creating a child theme for a specific theme, which allows creating an entirely new theme based
on that parent theme. In this tutorial we don't want to take a closer look into this topic because the tutorials
about [working with stylesheets] already describe how to do this.


## Modifying the CSS of a theme by extending an existing one

You can modify the styling of an existing theme by adding custom styles to it. Therefore, you need to follow the
file structure of the theme system and create a `main.scss` file inside your GXModules module.

Assuming you want to add (S)CSS code that is valid for all themes, then you need to create the following file:
`GXModules/<Vendor>/<Module>/Shop/Themes/All/Css/main.scss`. This `main.scss` file will be included automatically
while generating/building the styles of the corresponding theme.

Inside the `main.scss` you can add you own styles as well as import additional SCSS files if needed.



[working with stylesheets]: ./../../theme-development/styles.md