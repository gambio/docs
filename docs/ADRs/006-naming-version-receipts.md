# Naming of version receipts

**Created:** 2020-09-04 by Moritz Bunjes

**Status:** accepted

**Decision makers:** Moritz, Daniel W., Tobias S., Alexandros, Timo, Mirko


## Context

The shop system itself as well as extensions for it put a version receipt as a PHP file in the "src/version_info" 
folder. For this file no naming convention has been defined so far, so that there are many different variants for 
naming. Other software and tools use these receipts to determine what state a shop is in. In order for such software 
to better understand these files, fixed naming rules should be defined.

## Decision

The name should consist of two to three parts:
1. The package name
2. The package version
3. An optional specification

The format is the following:  
`<package-name>_<package-version>[_<optional-specification>].php`

Each part can use these characters:  
`a-z`, `0-9`, `-`, `.`

The filename can be verified by this [regular expression]:  
`^(?<package_name>[a-z0-9-.]+)_(?<package_version>[a-z0-9-.]+)(?:(_(?<optional_specification>[a-z0-9-.]+))?).php?`

__Example:__  
`gambio-hub_1.18.0_gx3.9.1.x-3.12.3.0.php`

## Consequences

In the future we will have a uniform format that we can rely on, so that we can work technically easier and faster. 
The disadvantage is that there is a break with old, previously undefined conventions, so that the format changes for 
some shop packages. In addition, systems that read out version receipts, such as the Gambio Hub, have to be adapted 
accordingly, but at the same time must still be able to cope with old receipts.

[regular expression]: https://regex101.com/r/Xz0hMP/3/