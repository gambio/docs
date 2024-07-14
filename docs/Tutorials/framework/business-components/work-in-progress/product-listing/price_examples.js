const example = {
    // Todo: Adjust example later to match all cases from "listing item `price.value.formatted` variations" from price notices
    simple: {
        "price": {
            "value": 9.95,
            "formatted": "9.95 EUR"
        },
    },
    special: {
        "price": {
            "value": 49.99,
            "formatted": "Nur 49.99 EUR",
            "special": {
                "value": 59.99,
                "formatted": "UVP 59.99 EUR"
            }
        },
    },
    variants: {
        "price": {
            "value": 19.99,
            "formatted": "Ab 19.99 EUR"
        },
    },
    variantsSpecial: {
        "price": {
            "value": 19.99,
            "formatted": "Ab nur 19.99 EUR",
            "special": {
                "value": 29.99,
                "formatted": "UVP 29.99 EUR"
            }
        },
    },
    personalOffer: {
        "price": {
            "value": 9.95,
            "formatted": "Ihr Preis 9.95 EUR",
            "normal": {
                "value": 29.99,
                "formatted": "Unser Normalpreis 19,99 EUR"
            }
        },
    },
    personalOfferWithDiscount: {
        // in this case, the normal is just the base price
        "price": {
            "value": 81.00,
            "formatted": "Ihr Preis 81.00 EUR",
            "discount": {
                "percentage": 10.0,
                "formatted": "Sie sparen 10%"
            },
            "normal": {
                "value": 90.00,
                "formatted": "Unser Normalpreis 90,00 EUR"
            },
        }
    },
    discount: {
        "price": {
            "value": 30.49,
            "formatted": "Ihr Preis ab 30,49 EUR",
            "discount": {
                "percentage": 4.69,
                "formatted": "Sie sparen 4,69%"
            },
            "normal": {
                "value": 31.99,
                "formatted": "Unser Normalpreis 31,99 EUR"
            },
        },
    }
};