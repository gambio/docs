# Creating Content Manager entries

The new themes offer the possibility to create new Content Manager entries such as links and content elements
automatically. This is especially interesting for theme developers who want to include their own content in their
themes.

In order to make this possible, the field `contents` in the file `theme.json` has to be extended. This chapter is
dedicated to creating Content Manager entries in themes.


## Links

Links are navigation items and can be created very easily. For this purpose we add the field `linkPages` within the
field `contents` in the `theme.json`. This snippet will add an external link to the main navigation menu:

```
"contents": {
  "linkPages": [
    {
      "type": "link",
      "position": "mainNavigation",
      "status": 1,
      "name": {
        "de": "Gambio",
        "en": "Gambio"
      },
      "title": {
        "de": "Zu Gambio",
        "en": "Go to Gambio"
      },
      "link": {
        "de": "http://www.gambio.de",
        "en": "http://www.gambio.com"
      },
      "openInNewTab": 1
    }
  ]
}
```


## Info elements

Info elements are widget-like contents and can also be created automatically. To do this we have to create an
`infoElements` field within the `contents` field in the `theme.json` file. The following snippet will create a
promotional content that could be displayed in several areas (we will do this later):

```
"contents": {
  "linkPages": [...],
  "infoElements": [
    {
      "id": 1111101,
      "type": "content",
      "position": "start",
      "status": 1,
      "title": {
        "de": "Promotion",
        "en": "Promotion"
      },
      "heading": {
        "de": "Promotion",
        "en": "Promotion"
      },
      "text": {
        "de": "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed ...",
        "en": "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed ..."
      }
    }
  ]
}
```

> The contents of _linkPages_ have been shortened for the sake of clarity.


## Conclusion

Now we have added Content Manager entries. You can already select the theme in the Gambio Admin. When
activating it all defined Content Manager entries will be created.
