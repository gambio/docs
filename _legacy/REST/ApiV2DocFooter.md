### Resource Representation
Every resource of the API represents a single logical entity of the shop. They are as simple as possible 
and are not messed with other entities of the system. In this appendix you can see some JSON examples of 
the available API resources. In addition the resource representations the API might include a "_links" 
property which contains pre-configured links to external resources so that you do not have to craft them 
yourself. 

> Important: It is possible that some operations require different variations of a resource. If this is 
the case, the variation will be explained into the operation section of this reference.


**Address:**
```json
{
  "id": 83,
  "customerId": 78,
  "gender": "m",
  "company": "Test Company",
  "firstname": "John",
  "lastname": "Doe",
  "street": "Test Street",
  "houseNumber": "123",
  "additionalAddressInfo": "1. Etage",
  "suburb": "Test Suburb",
  "postcode": "12345",
  "city": "Test City",
  "countryId": 81,
  "zoneId": 84,
  "class": "Test Class",
  "b2bStatus": false
}
```


**Category List Item:**
```json
{
  "id": 1,
  "parentId": 0,
  "isActive": true,
  "name": "Testkategorie",
  "headingTitle": "Testkategorie",
  "description": "Testkategorie Beschreibung",
  "urlKeywords": "",
  "icon": "category-icon.png",
  "image": "category-image.png",
  "imageAltText": "Bild Alt-Text"
}
```


**Category:**
```json
{
  "id": 1,
  "parentId": 0,
  "isActive": true,
  "sortOrder": 0,
  "dateAdded": "2016-01-15 17.16:41:00",
  "lastModified": "2016-01-25 17.33:52",
  "name": {
    "en": "test category",
    "de": "Testkategorie"
  },
  "headingTitle": {
    "en": "test category",
    "de": "Testkategorie"
  },
  "description": {
    "en": "<p>test category description</p>",
    "de": "<p>Testkategorie Beschreibung</p>"
  },
  "metaTitle": {
    "en": "",
    "de": ""
  },
  "metaDescription": {
    "en": "",
    "de": ""
  },
  "metaKeywords": {
    "en": "",
    "de": ""
  },
  "urlKeywords": {
    "en": "test-category",
    "de": "Testkategorie"
  },
  "icon": "item_ltr.gif",
  "image": "",
  "imageAltText": {
    "en": "",
    "de": ""
  },
  "settings": {
    "categoryListingTemplate": "categorie_listing.html",
    "productListingTemplate": "product_listing_v1.html",
    "sortColumn": "p.products_price",
    "sortDirection": "ASC",
    "onSitemap": true,
    "sitemapPriority": "0.5",
    "sitemapChangeFrequency": "daily",
    "showAttributes": false,
    "showGraduatedPrice": false,
    "showQuantity": true,
    "showQuantityInfo": false,
    "showSubCategories": true,
    "showSubCategoryImages": true,
    "showSubCategoryNames": true,
    "showSubCategoryProducts": false,
    "isViewModeTiled": false,
    "showCategoryFilter": false, 
    "filterSelectionMode": 0, 
    "filterValueDeactivation": 0,
    "groupPermissions": [
      {
        "id": "0",
        "isPermitted": false
      },
      {
        "id": "1",
        "isPermitted": false
      },
      {
        "id": "2",
        "isPermitted": false
      },
      {
        "id": "3",
        "isPermitted": false
      }
    ]
  },
  "addonValues": null
}
```


**Country:**
```json
{
  "id": 81,
  "name": "Deutschland",
  "iso2": "de",
  "iso3": "deu",
  "addressFormatId": 3,
  "status": true
}
```

**Customer Group:**
```json
{
  "names": {
    "EN": "Kids",
    "DE": "Kinder"
  },
  "settings": {
    "public": false,
    "otDiscountFlag": false,
    "graduatedPrices": false,
    "showPrice": true,
    "showPriceTax": false,
    "addTaxOt": false,
    "discountAttributes": false,
    "fsk18": false,
    "fsk18Display": false,
    "writeReviews": false,
    "readReviews": false
  },
  "configurations": {
    "minOrder": 2.5,
    "maxOrder": 20,
    "discount": 0.5,
    "otDiscount": 0,
    "unallowedPaymentModules": [
      "paypal",
      "cod",
      "moneyorder"
    ],
    "unallowedShippingModules": [
      "selfpickup"
    ]
  }
}
```

**Customer:**
```json
{
  "id": 926,
  "number": "234982739",
  "gender": "m",
  "firstname": "John",
  "lastname": "Doe",
  "dateOfBirth": "1985-02-13",
  "vatNumber": "0923429837942",
  "vatNumberStatus": true,
  "telephone": "2343948798345",
  "fax": "2093049283",
  "email": "customer@email.de",
  "password": "827ccb0eea8a706c4c34a16891f84e7b",
  "statusId": 1,
  "type": "registree",
  "addressId": 1029,
  "addonValues": null
}
```


**Email:**
```json
{
  "id": 168,
  "subject": "Test Subject",
  "sender": {
    "emailAddress": "sender@email.de",
    "contactName": "John Doe"
  },
  "recipient": {
    "emailAddress": "recipient@email.de",
    "contactName": "Jane Doe"
  },
  "replyTo": {
    "emailAddress": "reply_to@email.de",
    "contactName": "John Doe (Reply To)"
  },
  "contentHtml": "<strong>html content</content>",
  "contentPlain": "plain content",
  "isPending": false,
  "creationDate": "2015-06-04 14:36:00",
  "sendDate": "2015-06-04 14:36:00",
  "bcc": [
    {
      "emailAddress": "bcc@email.de",
      "contactName": "Chris Doe"
    }
  ],
  "cc": [
    {
      "emailAddress": "cc@email.de",
      "contactName": "Chloe Doe"
    }
  ],
  "attachments": [
    {
      "path": "/var/www/html/shop/uploads/attachments/1434614398/myfile.txt",
      "name": "Nicename For MyFile.txt"
    }
  ]
}
```
	
	
**Order List Item:**
```json 
{
  "id": 400210,
  "statusId": 1,
  "statusName": "Open",
  "totalSum": "100.00 EUR",
  "purchaseDate": "2015-01-01 00:00:00",
  "comment": "", 
  "withdrawalIds": [],
  "mailStatus": false,
  "customerId": 1,
  "customerName": "John Doe",
  "customerEmail": "john@doe.com",
  "customerStatusId": 1,
  "customerStatusName": "Admin",
  "customerMemos": [
    {
      "title": "Memo Title",
      "text": "Memo Text",
      "date": "2016-05-03 00:00:00",
      "posterId": 1
    }
  ],
  "deliveryAddress": {
    "street": "Test Street",
    "houseNumber": "123",
    "additionalAddressInfo": "1. Etage",
    "postcode": "12345",
    "city": "Test City",
    "state": "Test State",
    "country": "Germany",
    "countryIsoCode": "DE"
  },
  "billingAddress": {
    "street": "Test Street",
    "houseNumber": "123",
    "additionalAddressInfo": "1. Etage",
    "postcode": "12345",
    "city": "Test City",
    "state": "Test State",
    "country": "Germany",
    "countryIsoCode": "DE"
  },
  "paymentType": {
    "title": "Payment Title",
    "module": "Payment Module"
  },
  "shippingType": {
    "title": "Shipping Title",
    "module": "Shipping Module"
  },
  "trackingLinks": [
    "http://someurl?lang=de&idc=123456789&rfn=&extendedSearch=true",
    "http://someurl?lang=de&idc=987654321&rfn=&extendedSearch=true",
    "http://someurl?lang=de&idc=159753852&rfn=&extendedSearch=true"
  ]
}
```


**Order:**
```json
{
  "id": 400210,
  "statusId": 1,
  "purchaseDate": "2015-11-06 12:22:39",
  "currencyCode": "EUR",
  "languageCode": "DE",
  "totalWeight": 0.0,
  "comment": "",
  "paymentType": {
    "title": "cod",
    "module": "cod"
  },
  "shippingType": {
    "title": "Pauschale Versandkosten (Standar",
    "module": "flat_flat"
  },
  "customer": {
    "id": 1,
    "number": "",
    "email": "admin@example.org",
    "phone": "0421 - 22 34 678",
    "vatId": "",
    "status": {
      "id": 0,
      "name": "Admin",
      "image": "admin_status.gif",
      "discount": 0,
      "isGuest": false
    }
  },
  "addresses": {
    "customer": {
      "gender": "m",
      "firstname": "John",
      "lastname": "Doe",
      "company": "JD Company",
      "street": "Rotterstr",
      "houseNumber": "33",
      "additionalAddressInfo": "1. Etage",
      "suburb": "",
      "postcode": "28219",
      "city": "Bremen",
      "countryId": 81,
      "zoneId": 0,
      "b2bStatus": false
    },
    "billing": {
      "gender": "m",
      "firstname": "John",
      "lastname": "Doe",
      "company": "JD Company",
      "street": "Rotterstr",
      "houseNumber": "33",
      "additionalAddressInfo": "1. Etage",
      "suburb": "",
      "postcode": "28219",
      "city": "Bremen",
      "countryId": 81,
      "zoneId": 0,
      "b2bStatus": false
    },
    "delivery": {
      "gender": "m",
      "firstname": "John",
      "lastname": "Doe",
      "company": "JD Company",
      "street": "Rotterstr",
      "houseNumber": "33",
      "additionalAddressInfo": "1. Etage",
      "suburb": "",
      "postcode": "28219",
      "city": "Bremen",
      "countryId": 81,
      "zoneId": 0,
      "b2bStatus": false
    }
  },
  "items": [
    {
      "id": 1,
      "model": "12345-s-black",
      "name": "Ein Artikel",
      "quantity": 1,
      "price": 11,
      "finalPrice": 11,
      "tax": 19,
      "isTaxAllowed": true,
      "discount": 0,
      "shippingTimeInformation": "",
      "checkoutInformation": "Checkout information goes here ...",
      "attributes": [
        {
          "id": 1,
          "name": "Farbe",
          "value": "rot",
          "price": 0,
          "priceType": "+",
          "optionId": 1,
          "optionValueId": 1,
          "combisId": null
        },
        {
          "id": 1,
          "name": "Größe",
          "value": "S",
          "price": 0,
          "priceType": "calc",
          "optionId": null,
          "optionValueId": null,
          "combisId": 12
        },
        {
          "id": 2,
          "name": "Farbe",
          "value": "Schwarz",
          "price": 2,
          "priceType": "calc",
          "optionId": null,
          "optionValueId": null,
          "combisId": 12
        }
      ],
      "downloadInformation": [
        {
          "filename": "Dokument.pdf",
          "maxDaysAllowed": 5,
          "countAvailable": 14
        }
      ],
      "addonValues": {
        "productId": "2",
        "quantityUnitId": "1"
      },
      "quantityUnitName": "Liter"
    }
  ],
  "totals": [
    {
      "id": 1,
      "title": "Zwischensumme:",
      "value": 50,
      "valueText": "50,00 EUR",
      "class": "ot_subtotal",
      "sortOrder": 10
    }
  ],
  "statusHistory": [
    {
      "id": 1,
      "statusId": 1,
      "dateAdded": "2015-11-06 12:22:39",
      "comment": "",
      "customerNotified": true
    }
  ],
  "addonValues": {
    "customerIp": "",
    "downloadAbandonmentStatus": "0",
    "serviceAbandonmentStatus": "0",
    "ccType": "",
    "ccOwner": "",
    "ccNumber": "",
    "ccExpires": "",
    "ccStart": "",
    "ccIssue": "",
    "ccCvv": ""
  }
}
```
	
**Manufacturer:**
```json
{
  "name": "Breitling",
  "image": "manufacturers/breitling-logo.png",
  "urls": {
    "EN": "https://breitling.com",
    "DE": "https://breitling.de"
  }
}
```

**Product List Item:**
```json 
{
  "id": 1,
  "isActive": true,
  "sortOrder": 0,
  "dateAdded": "2015-01-01 00:00:00",
  "dateAvailable": "2015-01-01 00:00:00",
  "lastModified": "2015-01-01 00:00:00",
  "orderedCount": 0,
  "productModel": "ABC123",
  "ean": "Ean",
  "price": 59.00,
  "discountAllowed": 0.00,
  "taxClassId": 0,
  "quantity": 0.00,
  "name": "Testartikel",
  "image": "artikelbild.jpg",
  "imageAltText": "Artikelbild",
  "urlKeywords": "Testartikel",
  "weight": 0.00,
  "shippingCosts": 0.00,
  "shippingTimeId": 0,
  "productTypeId": 0,
  "manufacturerId": 0,
  "isFsk18": false,
  "isVpeActive": false,
  "vpeId": 0,
  "vpeValue": 0.00
}
```


**Product:**
```json
{
  "id": 1,
  "isActive": false,
  "sortOrder": 0,
  "dateAdded": "2015-08-08 17.19:46",
  "dateAvailable": "2016-01-21 12:15:42",
  "lastModified": "2016-03-16 16:01:51",
  "orderedCount": 1,
  "productModel": "ABC123",
  "ean": "",
  "price": 16.7983,
  "discountAllowed": 0,
  "taxClassId": 1,
  "quantity": 998,
  "weight": 0,
  "shippingCosts": 0,
  "shippingTimeId": 1,
  "productTypeId": 1,
  "manufacturerId": 0,
  "isFsk18": false,
  "isVpeActive": false,
  "vpeID": 0,
  "vpeValue": 0,
  "name": {
    "en": "Test Product",
    "de": "Testartikel"
  },
  "description": {
    "en": "<p>Test product description.</p>",
    "de": "[TAB:Seite 1] Testartikel Beschreibung Seite 1 [TAB:Seite 2] Testartikel Beschreibung Seite 2 [TAB:Seite 3] Testartikel Beschreibung Seite 3"
  },
  "shortDescription": {
    "en": "<p>Test product short description.</p>",
    "de": "<p>Testartikel Kurzbeschreibung</p>"
  },
  "keywords": {
    "en": "",
    "de": ""
  },
  "metaTitle": {
    "en": "",
    "de": ""
  },
  "metaDescription": {
    "en": "",
    "de": ""
  },
  "metaKeywords": {
    "en": "",
    "de": ""
  },
  "url": {
    "en": "",
    "de": ""
  },
  "urlKeywords": {
    "en": "test-product",
    "de": "testartikel"
  },
  "checkoutInformation": {
    "en": "",
    "de": ""
  },
  "viewedCount": {
    "en": 0,
    "de": 32
  },
  "images": [
    {
      "filename": "artikelbild_1_1.jpg",
      "isPrimary": false,
      "isVisible": true,
      "imageAltText": {
        "en": "",
        "de": ""
      }
    },
    {
      "filename": "artikelbild_1_2.jpg",
      "isPrimary": false,
      "isVisible": true,
      "imageAltText": {
        "en": "",
        "de": ""
      }
    },
    {
      "filename": "artikelbild_1_3.jpg",
      "isPrimary": false,
      "isVisible": true,
      "imageAltText": {
        "en": "",
        "de": ""
      }
    }
  ],
  "settings": {
    "detailsTemplate": "standard.html",
    "optionsDetailsTemplate": "product_options_dropdown.html",
    "optionsListingTemplate": "product_options_dropdown.html",
    "showOnStartpage": false,
    "showQuantityInfo": true,
    "showWeight": false,
    "showPriceOffer": true,
    "showAddedDateTime": false,
    "priceStatus": 0,
    "minOrder": 1,
    "graduatedQuantity": 1,
    "onSitemap": true,
    "sitemapPriority": "0.5",
    "sitemapChangeFrequency": "daily",
    "propertiesDropdownMode": "dropdown_mode_1",
    "startpageSortOrder": 0,
    "showPropertiesPrice": true,
    "usePropertiesCombisQuantity": false,
    "usePropertiesCombisShippingTime": true,
    "usePropertiesCombisWeight": false
  },
  "addonValues": {
    "productsImageWidth": "0",
    "productsImageHeight": "0"
  }
}
```

**Quantity Unit:**
```json
{
  "id": 2,
  "names": {
    "EN": "piece",
    "DE": "Stück"
  }
}
```

**Tax Rates:**
```json
{
  "id": "1",
  "taxZoneId": "5",
  "taxClassId": "1",
  "taxRate": "19.0000",
  "description": "19% MwSt."
}
```

**VPE:**

```json
{
  "name": {
     "EN": "API Packing unit",
     "DE": "API Verpackungseinheit"
  }
}
```

**Zone:**
```json
{
  "id": 84,
  "name": "Bremen",
  "iso": "BRE"
}
```

### Change Log

**v2.5.0**
- Added new resources: customer groups, manufacturers, quantity units, VPE, tax rates, shop information. 

**v2.4.0**
- The order list items now contains GX Customizer information.

**v2.3.0**
- Added support for AddonValues in CustomerService
- Product list items contain more information.

**v2.2.0**
- The order list item resource contains more information.
- The order item resource contains the information about the products quantity unit.
- The total sum amount is now a string with the currency code. 
- Total weight property is added to the order resource.
- House number and additional address info added to the API resources.

**v2.1.0**
- Added new resources: Categories, Products, Orders.
- Refactored old resources which will now use the latest codebase (GX v2.7).
- Added extra error checks and error explanations.

**v2.0.0**
- Initial release including Customer, Email, Address, Country and Zone resources.

### Miscellaneous 
**Copyright**: Gambio GmbH &copy; 2018

**License**: [GPLv2](http://www.gnu.org/licenses/gpl-2.0.html)

**Version**: v2.5.0

**Website**: [gambio.de](http://gambio.de)
