# Adding new JavaScript

The including of additional JavaScript is determined by defined sections. It's important to follow a specific
directory structure inside your GXModule module. The following example shows the directory structure and the
available sections:

```plain
- GXModules/<Vendor>/<Module>/Shop/Themes/<Theme>/Javascript/
    - Account/
    - AccountHistory/
    - CallbackService/
    - Cart/
    - Cat/
    - Checkout/
    - Global/
    - GVSend/
    - Index/
    - Manufactures/
    - PriceOffer/
    - ProductInfo/
    - Wishlist/
```

**Note:** The `<Theme>` must be the directory name of an existing theme or `All`. In case of `All` the JS files
will be included for every theme.

Assuming you want to include a specific JavaScript (e.g. `my_alert.js`) into every page of the `Honeygrid` theme, then
you need to create the following file: `GXModules/<Vendor>/<Module>/Shop/Themes/<Theme>/Javascript/Global/my_alert.js`.