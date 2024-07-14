# Working with JavaScript files

The theme system also allows you to comfortably work with JavaScript files.


## Directory structure

The files land in the `javascripts` folder of a theme directory. Again, there is a division into the `system` and
`custom` directories.

The JavaScript files are categorized as follows:

```text
Darkness
 └─ javascripts
     ├─ system
     └─ custom
```

Please recreate this folder structure so you can continue.


## The `system` folder

### Replacing and removing existing JavaScript files

To replace or remove a JavaScript file of a parent theme, a JavaScript file has to be created in the theme's `system`
folder, as with HTML templates and stylesheet files. This file has to have the same name as the parent theme file to be
replaced. The folder structure has to be taken into account.

In our example we do not want to have any page-up functionality. The button to go back to the top should not be
displayed. To do this, the new files `pageup.js` and `pageup.min.js` have to be created in the `system` folder of our
`Darkness` theme within a subfolder called `widgets`. Insert this content into both files:

```js
// We just overload the "pageup" widget with this noop module to hide the back-to-top button
gambio.widgets.module("pageup", [], function () {
  return {
    init(done) {
      done();
    },
  };
});
```

> The minified JavaScript file (with the extension `min.js`) is loaded for productive use, while the other file
> (`.js`) is used for the development environment.


## The `custom` folder

### Global JavaScript files

As with the style files, it is also possible to create new files for JavaScript files, which are loaded on every page
of the shop. To do this, a JavaScript file has to be created in the `custom` folder of the theme, which has a
**unique** name and does not collide with existing JavaScript files of the parent theme.

For our Darkness Theme we will create the JavaScript handler for the dark mode switcher button. We will
create a new JavaScript file with the unique name `darkness_switcher.js`, in the `custom` folder of our `Darkness`
theme. The content of this file looks like this:

```js
// Add dark mode toggle functionality. This script is always invoked
(function () {
  const switcher = document.querySelector("#darkmode-switcher");

  switcher.addEventListener("click", () =>
    document.body.classList.toggle("darkmode")
  );

  switcher.click();
})();
```

### JavaScript files for specific areas

It is still possible to create your own JavaScript files for certain areas of the shop. For this purpose, a subfolder,
which has a specific name, has to be created in the `custom` folder of the theme. Below are some examples:

- `Cart` for shopping cart page
- `Index` for the home page
- `Account` for the profile page

For our example theme we would like to create a JavaScript file that is only executed on the start page of the shop.
Therefore we create a subfolder `Index` in the `custom` folder of our `Darkness` theme and, in this folder, create a
new file called `darkness_greeting.js` with a `console.log()` statement and arbitrary text as content:

```js
// This file is executed on the main page only
(function () {
  console.log("Hello from the dark side!");
})();
```


## Conclusion

In this part of the workshop we learned about the functions for working with JavaScript files. We already
knew some things from the old _template_ system, such as creating area-specific JavaScript files.

The `javascripts` directory of our `Darkness` theme should now have the following structure:

```
Darkness
 └─ javascripts
     ├─ system
     │   └─ widgets
     │       ├─ pageup.js
     │       └─ pageup.min.js
     └─ custom
         ├─ darkness_switcher.js
         └─ Index
              └─ darkness_greeting.js
```
