# Autoloading and Namespaces

The PHP Standard Recommendation #4 (PSR-4 for short) describes a methodology that allows the application to find
classes without having to include them manually. We use [Composer]{target=_blank} to provide this kind of feature.

Using the PSR-4, the namespace of a PHP class determines the location of the file. Namespaces can be assigned to a
folder and requested classes within these namespaces are included using this folder.

The shops autoloader automatically assigns the `GXModules` directory to the *GXModules* root namespace. If
we now give the namespace path the name as the directory structure, the shop system will automatically find the
containing classes.


__Examples:__

| Namespace | Path to the class/file |
| --- | --- |
| GXModules\\...                              | src/GXModules/... |
| GXModules\Vendor\Library\SomeClass          | src/GXModules/Vendor/Library/SomeClass.php |
| GXModules\Vendor\Library\Services\MyService | src/GXModules/Vendor/Library/Services/MyService.php |



[Composer]: https://getcomposer.org/
