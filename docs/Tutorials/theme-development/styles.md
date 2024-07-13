# Working with stylesheets

We can easily extend, replace and add stylesheet files with the new theme system.

## Directory structure

The styles are placed in the `styles` folder of a theme directory. As with the HTML templates, there also is a
division into the `system` and `custom` directories.

This is what the structure looks like:

```text
Darkness
 └─ styles
     ├─ system
     └─ custom
```

Please recreate this folder structure again before you continue.


## The `system` folder

### New stylesheets

To create a new style for a theme, a new `.scss` file has to be created in the `system` folder. Make sure that the
name is **unique** and does not coincide with the name of a style file in the parent theme.

For our example we will create several `.scss` files. First of all, let's stylize our HTML widgets we created earlier:

Create the file `darkness_map_widget.scss` with this content:

```scss
// Map widget
#darkness-map-widget {
  transition: ease 0.5s opacity;
  opacity: 0.75;

  > iframe {
    width: 100%;
    height: 500px;
    border: 0;
    margin: 0;
    overflow: hidden;
    background: none !important;
  }

  &:hover {
    opacity: 1;
  }
}
```

Next, create the file `darkness_video_widget.scss` with this content:

```scss
// Video widget
#darkness-video-widget {
  text-align: center;

  > iframe {
    width: 885px;
    height: 350px;
    border: 0;
    margin: 0;
    overflow: hidden;
  }
}
```

Now, let's create the stylesheet for the dark mode. Create the file `darkness_mode.scss` and insert this:

```scss
// Dark mode styles
$light-color: white !important;
$dark-color: #212121 !important;

body.darkmode {
  color: $light-color;
  background-color: $dark-color;

  #outer-wrapper,
  #header,
  .swiper-slide,
  .product-container,
  #topbar-container,
  .navbar-default,
  ul.navbar-nav,
  .navbar-nav a,
  #categories {
    background-color: $dark-color;
  }

  h1,
  h2,
  .product-container *,
  .cart,
  .navbar-nav a {
    color: $light-color;
  }

  #header svg,
  #header svg * {
    fill: $light-color;
  }

  #header .gambio-admin a,
  h1::after,
  h2::after {
    background-color: $light-color;
    color: $dark-color;
  }
}
```

And finally, let's stylize our dark mode switcher in the navigation menu by creating the file
`darkness_switcher.scss` with this content:

```scss
// Dark mode switcher
body {
  #darkmode-switcher {
    > a {
      &:hover,
      &:focus {
        background-color: transparent !important;
      }

      > span {
        position: relative;
        top: 4px;

        > .fa-moon {
          display: initial;
        }

        > .fa-sun {
          display: none;
        }
      }
    }
  }

  &.darkmode {
    #darkmode-switcher {
      .fa-moon {
        display: none;
      }

      .fa-sun {
        display: initial;
      }
    }
  }
}
```

> Please note that these style sheets are not automatically included. We will come to that step later.


## The `custom` folder

### Global stylesheets

With the new theme system, it is possible to load your own stylesheets on every page of the shop in a comfortable
way. An exemplary use case is when you want to apply a stylesheet that influences many different areas of the shop.

As with HTML templates, it is also possible to create only one file that contains all style definitions and
inclusions. Fot this it is important that the file name is **unique** and does not collide with any stylesheet
file from the parent theme.

In our example we want to include our stylesheets for our modifications and add some additional small style changes.
In order to do this we create a new file `darkness.scss` in the `custom` folder of our `Darkness` theme and insert
this content:

```scss
#header .gambio-admin {
  left: 0;
}

#darkness-promotion {
  margin: 6rem auto;
  border-radius: 12px;
  padding: 12px;
  background-color: white;
  color: #212121;
  font-size: 2rem;
}

@import "../system/darkness_map_widget";
@import "../system/darkness_video_widget";
@import "../system/darkness_mode";
@import "../system/darkness_switcher";
```


## Conclusion

At the end of this workshop part the folder structure should look like this:

```
Darkness
 └─ styles
     ├─ system
     │   ├─ darkness_map_widget.scss
     │   ├─ darkness_video_widget.scss
     │   ├─ darkness_mode.scss
     │   └─ darkness_switcher.scss
     └─ custom
         └─ darkness.scss
```

We have now learned how to add and extend stylesheets.
