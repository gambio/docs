const model = {
    "id": 1,
    
    "details": {
        "name": "Example Product Abc",
        "description": "This is my cool example product abc. ...",
        "shortDescription": "Check out this cool example product!",
        "model": "example-product-abc",
        "codes": [
            {
                "name": "upc",
                "value": "",
            },
            {
                "name": "mpn",
                "value": "EXAMPLE-123",
            },
        ],
    },
    
    "settings": {
        "type": "default",
        "weight": 0.0000,
        "isFsk18": true,
        "shippingLinkIsActive": true,
        "vpe": {
            "formatted": "2,07 kg",
            "unit": "kg",
            "value": 2.0661,
        },
        "visibility": {
            "showStock": false,
            "showVpeUnit": false,
            "showOnStartPage": false,
            "showWeight": true,
            "showSitemap": false,
            "showReleaseDate": false,
            "showFreeShipping": false,
        },
        "pricing": {
            "isNormal": true,
            "isPriceAvailableOnRequest": false,
            "isNotAvailableForPurchase": false,
        }
    },
    
    "stock": {
        "quantity": 1.3,
        "interval": 0.25,
        "orderMinQuantity": 1.5,
        "unit": "kg",
        "availability": "In Stock"
    },
    
    "meta": {
        "title": "Example product abc",
        "description": "This is awesome new stuff",
        "keywords": "awesome, example, abc",
        "link": "http:\/\/gambio.shop\/product_info.php?info=p5_t-shirt-gambio.html",
        "sitemap": {
            "priority": 0.1,
            "frequency": "weekly"
        }
    },
    
    "shipping": {
        "cost": 4.0000,
        "name": "ca. 3-4 Tage",
        "image": "images\/icons\/status\/green.png",
        "range": {
            "low": {
                "days": "4",
                "name": "ca. 3-4 Tage",
                "image": "images\/icons\/status\/green.png"
            },
            "high": {
                "days": "4",
                "name": "ca. 3-4 Tage",
                "image": "images\/icons\/status\/green.png"
            }
        }
    },
    
    "price": {
        "finalPrice": 81.00,
        "formatted": "Ihr Preis 81.00 EUR",
        // special and discount are both optional and only one of them can be available, never both
        
        "discount": {
            "percentage": 10.0,
            "formatted": "Sie sparen 10%"
        },
        "normal": {
            "value": 90.00,
            "formatted": "Unser Normalpreis 90,00 EUR"
        },
        "special": {
            "value": 90.00,
            "formatted": "UVP 90.00 EUR"
        }
    },
    
    "taxes": {
        "total": 19.0,
        "formatted": "incl 19% Mwst.",
        "title": "tax a",
        "description": "foo bar tax a",
        
        "rates": [
            {
                "description": "16% Mwst.",
                "rate": 19.0,
                "priority": 1
            },
            {
                "description": "3% Mwst.",
                "rate": 2.5,
                "priority": 1
            },
            {
                "description": "3% Mwst.",
                "rate": 5.5,
                "priority": 2
            }
        ]
    },
    
    "manufacturer": {
        "name": "Nike",
        "url": "https://nike.com",
        "image": "https://nike.com/logo.png"
    },
    
    "images": {
        "main": {
            "url": "https://localhost/my-shop/images/foo.png",
            "alt": "foo image",
        },
        "additional": [
            {
                "url": "https://localhost/my-shop/images/bar.png",
                "alt": "bar image",
            },
            {
                "url": "https://localhost/my-shop/images/baz.png",
                "alt": "baz image",
            }
        ]
    },
    
    "dates": {
        "createdAt": "2018-11-13T20:20:39+00:00",
        "modifiedAt": "2018-11-13T20:20:39+00:00",
        "availableAt": "2018-11-13T20:20:39+00:00",
        "expiresAt": "2018-11-13T20:20:39+00:00"
    },
    
    "additionalData": {
        "another_third_party_null": null,
        "another_third_party_bool": false,
        "another_third_party_int": 123,
        "another_third_party_float": 1.23,
        "another_third_party_string": "string value",
        "another_third_party_object": {
            "foo": 42
        },
        "additionalDataNamespace": [
            {
                "quantity": 0.5,
                "price": 10.00
            },
            {
                "quantity": 2.5,
                "price": 40.00
            }
        ],
    },
}