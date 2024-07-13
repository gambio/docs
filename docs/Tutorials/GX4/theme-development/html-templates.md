# Creating HTML templates

The new theme system allows to replace and extend the HTML templates of the parent theme. In addition, Smarty blocks
can be replaced. You can also create your own HTML templates.


## Directory structure

In a theme directory there is a folder called `html`. This directory can contain two other directories, `system`
and `custom`, each containing HTML templates.

The structure looks like this:

```text
Darkness
 └─ html
     ├─ system
     └─ custom
```

Before we continue, please recreate the exact folder structure above in your `Darkness` theme.


## The `system` folder


### New HTML templates

Completely new HTML template files can be added by creating a new HTML file.

Please note that the name of the HTML template has to be **unique** if another theme is extended. Otherwise the HTML
template of a parent theme with the same name will be replaced.

In our example, we create two new HTML templates in the `system` folder:

File `darkness_map_widget.html`:

```smarty
{* Map widget *}
<div id="darkness-map-widget">
   <iframe src="https://maps.google.com/maps?q=parellelweg%2030%2C%2028219%20bremen&t=&z=17&ie=UTF8&iwloc=&output=embed"></iframe>
</div>
```

and the file `darkness_video_widget.html`:

```smarty
{* Video widget *}
<div id="darkness-video-widget">
  <iframe src="https://www.youtube.com/embed/GrO5tFXuPNA?ecver=1&amp;iv_load_policy=3&amp;rel=0&amp;showinfo=0&amp;yt:stretch=16:9&amp;autohide=1&amp;color=white"></iframe>
</div>
```

Now the structure should look like this:

```text
Darkness
    └─── html
          ├─── system
          │       ├─── darkness_map_widget.html
          │       └─── darkness_video_widget.html
          └─── custom
```

The goal is to integrate the newly created HTML template into our theme by displaying it on the home page. More on
this later.


### Replacing HTML templates

Since we inherit `Darkness` from the parent theme `Malibu`, we can replace the HTML templates of `Malibu` in our theme.

To do so, we have to create an HTML template in the `system` folder that has exactly the same name as the HTML
template of the parent theme.

You could, for example, remove the entire header by creating an empty file `layout_header.html` in the `system` folder.
This would overload the `layout_header.html` file of the parent theme `Malibu`.Do not do this for now, as we
need our header for further customizations in this workshop.


## The `custom` folder

### Extending areas of multiple HTML templates

The new theme system also allows you to extend the Smarty blocks of various HTML templates of the parent theme. In
doing so, you can extend several Smarty blocks from several HTML templates in a single file.

It is important here that the name of the HTML template we're creating is **unique** and does not collide with the
name of any HTML template from the parent theme.

In this workshop we want to achieve these modifications:

- Replace the footer with the Maps widget we created earlier
- Insert a YouTube video below the main content
- Replace the logo with our custom text "The Darkness"
- Add a dark mode switcher to the top navigation bar
- Include the promotional Content Manager entry that we created previously and show it on the top of the main content

We create a file called `darkness_modifications.html` in the `custom` folder of our `Darkness` theme and add the
desired modifications into that file:

```smarty
{* This file modifies blocks of all areas *}

{* Replace logo *}
{block name="layout_header_logo"}
  <h1>THE DARKNESS</h1>
{/block}

{* Add dark mode switcher to top bar *}
{block name="layout_secondary_navigation_wishlist_if" append}
  <li class="navbar-topbar-item" id="darkmode-switcher">
    <a class="dropdown-toggle" href="#">
      <span>
        <span class="fa fa-moon fa-2x"></span>
        <span class="fa fa-sun fa-2x"></span>
      </span>
    </a>
  </li>
{/block}

{* Insert content manager entry into the main content *}
{block name="index_outer_wrapper_imageslider" prepend}
  <div id="darkness-promotion" class="container">
    {content_manager group=1111101}
  </div>
{/block}
```


### Extending areas of a specific HTML template

Furthermore it's possible to extend only the areas of a specific HTML template. To do this, an HTML template with the
same name as the HTML template to be extended has to be created in the `custom` folder of our `Darkness` theme, in the
`system` folder of the parent theme.

In our example, we only want to modify some areas of the index page. Therefore, we create the file `index.html` in
the `custom` folder of our `Darkness` theme and then insert our modifications and include our previously defined
HTML snippets:

```smarty
{* This file modifes blocks in the index.html file of the parent theme only *}

{* Replace footer with map widget *}
{block name="index_inner_wrapper_footer"}
  {include file="get_usermod:{$tpl_path}darkness_map_widget.html"}
{/block}

{* Insert video widget under the main content *}
{block name="index_inner_wrapper_main_content" append}
  {include file="get_usermod:{$tpl_path}darkness_video_widget.html"}
{/block}
```


## Conclusion

At the end of this part of the workshop, we have created the following folder structure:

```text
Darkness
 ├─ ...
 └─ html
     ├─ system
     │   ├─ darkness_map_widget.html
     │   └─ darkness_video_widget.html
     └─ custom
         ├─ darkness_modifications.html
         └─ index.html
```

Now we have learned how to work with HTML templates. You can see that we have complete
flexibility for creating and extending HTML templates with the theme system.
