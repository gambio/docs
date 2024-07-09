# Veraltete Inhalte

**Hinweis:** Diese Seite enthält veraltete Informationen und wird bald überarbeitet.


Wegen generelle Refaktoring die folgende Dateien und Verzeichnisse sind als Deprecated markiert und werden 
in kommenten Anwendungversionen entweder **Verschoben oder Entfernt**.

Außerdem, Quellcode der in **Compatibility** Verzeichnisse liegt, ist da wegen den Umstellung zu neue 
Struktur und wird auf jeden fall in Zukunft entfernt.ed at some point in the future. 

EyeCandy und jeweilige Dateien werden von Projekt entfernt aber das wird nicht kurzfristig passieren, 
damit es mehr Zeit für Migration von 3rd-Party Module gibt. Verwenden diese Dateien nur für Fixes und 
nicht für neue Features. Seit GX3 Honeygrid ist das Standard Template der Anwendungs.


## <a name="Deprecated - Removal "></a>Deprecated - Removal 

Dateien und Verzeichnisse in die Liste sind veraltet und werden bald mit neue Quellcode erstezt. 

- admin/
  - javascript/engine/
    - extensions/
      - disable_ckedit.js
      - validator.js (verschoben nach JSE/Extensions)
    - widgets/
      - datepicker.js (verschoben nach JSE/Widgets)
      - datetimepicker.js (verschoben nach JSE/widgets)
  - *.php > Alle PDF Dateien in "admin" Verzeichnis werden ersetzt mit PHP Controllers von HttpService.
- GXMainComponents/Deprecated/*
- StyleEdit/*
- system/
  - extender/
    - JSAccountExtenderComponent.inc.php
    - JSAccountHistoryExtenderComponent.inc.php
    - JSAddressBookProcessExtenderComponent.inc.php
    - JSCallbackServiceExtenderComponent.inc.php
    - JSCartExtenderComponent.inc.php
    - JSCatExtenderComponent.inc.php
    - JSCheckoutExtenderComponent.inc.php
    - JSGVSendExtenderComponent.inc.php
    - JSGlobalExtenderComponent.inc.php
    - JSIndexExtenderComponent.inc.php
    - JSManufacturersExtenderComponent.inc.php
    - JSPriceOfferExtenderComponent.inc.php
    - JSProductInfoExtenderComponent.inc.php
    - JSWishlistExtenderComponent.inc.php
    - JSWithdrawalExtenderComponent.inc.php
- templates/
  - EyeCandy/*
  - MobileCandy/*
  - Honeygrid/
    - module
      - gm_customer_upload.html
      - gv_faq.html
      - content_topmenu.html
- GXUserComponents/
  - _extender_samples/
    - SampleJSAccountExtenderComponent/*
    - SampleJSAccountHistoryExtenderComponent/*
    - SampleJSCallbackServiceExtenderComponent/*
    - SampleJSCartExtenderComponent/*
    - SampleJSCatExtenderComponent/*
    - SampleJSCheckoutExtenderComponent/*
    - SampleJSGlobalExtenderComponent/*
    - SampleJSIndexExtenderComponent/*
    - SampleJSManufacturersExtenderComponent/*
    - SampleJSPriceOfferExtenderComponent/*
    - SampleJSProductInfoExtenderComponent/*
    - SampleJSWishlistExtenderComponent/*


## <a name="Neue Admin Dateistruktur"></a>Neue Admin Dateistruktur

- html
  - assets
    - fonts
    - images
    - javascript
    - styles
  - compatibility (Files in this directory will be gradually removed.)
  - content
- includes
- javascript
  - engine
  - legacy
  - modules
  - vendor
- styles
  - admin
  - compatibility
  - modules
  - vendor
  - *.scss > Haupt SCSS Komponente wie "admin.scss" und "compatibility.scss"


## <a name="Honeygrid Dateistruktur"></a>Honeygrid Dateistruktur

- Honeygrid
  - admin
  - assets
    - fonts
    - images
    - javascript
    - styles
  - boxes
  - javascript
    - engine
  - module
    - categorie_listing
    - filter_selection
    - gm_product_options
    - product_info
    - product_listing
    - product_options
    - properties
  - smarty
  - snippets
    - box
    - header
    - navigation
    - order
    - product_info
    - product_listing
    - ribbon
  - social_sharing
    - services
  - source
    - boxes
    - classes
  - styles
    - bootstrap
    - config
    - custom
    - font-awesome
    - fontello
    - modules
    - Einfache CSS Dateien **nur** bezüglich SCSS Module und Fixes
  - usermod
    - css
    - javascript
  - Andere Dateien für Templateeinstellungen inkl. verwendbare Templatestyles- und Skripts.


## <a name="StyleEdit 3"></a>StyleEdit 3

Es steht eine neue StyleEdit Version zur Verfügung.  

- StyleEdit3
  - assets
    - fonts
    - images
    - javascript
    - styles
  - classes
    - Collections
    - Entities
    - Factories
    - Repositories
  - html
  - javascript
    - api
    - controllers
    - entities
    - libs
    - widgets
  - lang
  - styles
  - templates
    - Honeygrid
      - boilerplates
      - lang
  - vendor