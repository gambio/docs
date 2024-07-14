# Sample Modules

We know that most of the developers like to get their hands on some real samples, that's why we want to give you some.
The [Gambio Samples zip file] contains multiple examples for GX Modules. The only thing you need to do is to just
download the zip file and extract the content into the `GXModules` directory of the shop software. Afterwards you only
need to clear the module caches and will find some new menu items in the Gambio Admin.

The following sample modules are included:

1. **HelloWord:**  
   This simple examples just shows a "Hello World" admin page.
2. **CacheCleaner:**  
   This one is a bit more complex and shows an admin page that contains a JS script which triggers some cache clearing
   actions via background HTTP requests.
3. **TwigAdminEngine:**  
   In this module you can see how you could add some further dependencies to the shop software that could be used by
   other GX Modules. For this example we replaced the Smarty template engine with Twig.
4. **TwigModule:**  
   This examples shows the usage of the new available Twig engine and shows an admin page based on a Twig template.
5. **ShopStatusManager:**  
   This module is the most complex example and shows a configuration page for managing the shop status, top bar and
   popup in the Gambio Shop.
6. **Glossary:**  
   The last module just contains a menu JSON file for the Gambio Admin so that it's easier to find the sample pages in 
   the Gambio Admin.


[Gambio Samples zip file]: ./_samples/GambioSamples.zip