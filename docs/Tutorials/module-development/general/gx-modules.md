# GXModules

We're referencing the system for integrating new modules into the shop software as GXModules. For adding new modules to
the shop, you interact with this system mainly by using the `GXModules` directory in the root directory of the shop
software. Automatic mechanics and processes are using this particular directory to look up certain classes/components,
data or configurations.


## File structure for modules

We assume that your module has a vendor (you) and a name. Based on this information, you need to place your
module files inside the following directory:

```
- GXModules/
    - <Vendor>/
        - <Module>/
            - ...
        - ...
```

This way, the files of a specific developer can be found bundled in one place, but the files of the individual
modules are still separated from the other modules.

**Example 1:** Assuming you are looking for the files for our (Gambio) modules, you will find them in the directory
`GXModules/Gambio/`.

**Example 2:** Assuming you are looking for the files for the *Gambio Hub* module, you will find them in the directory
`GXModules/Gambio/Hub/`.

A further advantage of using GXModules is the [Autoloading]. If you place the class `SomeClass` with the namespace
`GXModules\Vendor\MyModule` using the path `GXModules/Vendor/MyModule/SomeClass.php`, PHP will automatically include
this class when it's needed.


### Recommendation: Separation of files for shop, admin, and API

Generally, files for the shop and admin should be separated. Such a separation would look like this:

```
- GXModules/
    - <Vendor>/
        - <Module>/
            - Admin/
            - Api/
            - Shop/
```

This kind of division has the advantage that for you and others, the content and logical separation of files is
recognizable for the shop or admin.

**Note 1:** Beside these subfolders you can also often find a `index.html`. This however, is only used for security
purposes and not for the functionality of the module.

**Note 2:** In addition to these subfolders there may also be a folder `Build`. This subfolder is created by an
automated development process and contains converted SCSS and JS files. For your modules, you can create a similar
directory of generated files but you don't necessarily have to.

