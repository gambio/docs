# Listing item price struct and formatting

## Flow

if special is available, only the special attribute will be available (on all cases)

if product has personal offer and discount, the discount formatting is used (based on personal offer price)

if product has personal offer and **no** discount, an extra attribute for personal will be added

if it is just a simple price, the normal price struct without any extra fields is used

## Examples

### listing price price struct fields

#### without additional attributes

```json
{
    "price": {
        "finalPrice": 19.99,
        "formatted": "19.99 EUR"
    }
}
```

#### with special offer

```json
{
    "price": {
        "finalPrice": 19.99,
        "formatted": "19.99 EUR",
        "special": {
            "normalPrice": 25.99,
            "formatted": "UVP 25.99 EUR"
        }
    }
}
```

#### personal offer and discount

> Note: `price.discount.previousPrice` is based on the personal offer

> Consideration: use `price.personalOffer` instead of `price.discount.previousPrice`. Pro: struct exposes availability
> of personal offer | Contra: Less descriptive and the information that personal offer is available might not be useful

IMO, we should use `price.discount.previousPrice`, because listings with personal offer never show normal price (at
least in `xtcPrice::xtcGetPrice`). See  [`example.personalOffer`](./price_examples.js)

```json
{
    "price": {
        "finalPrice": 30.49,
        "formatted": "Ihr Preis ab 30,49 EUR",
        "discount": {
            "previousPrice": {
                "value": 31.99,
                "formatted": "Unser Normalpreis 31,99 EUR"
            },
            "saving": {
                "percentage": 4.69,
                "formatted": "Sie sparen 4,69%"
            }
        }
    }
}
```

#### discount

> Note: `price.discount.previousPrice` is based on the price

```json
{
    "price": {
        "finalPrice": 30.49,
        "formatted": "Ihr Preis ab 30,49 EUR",
        "discount": {
            "previousPrice": {
                "value": 31.99,
                "formatted": "Unser Normalpreis 31,99 EUR"
            },
            "saving": {
                "percentage": 4.69,
                "formatted": "Sie sparen 4,69%"
            }
        }
    }
}
```

#### personal offer

```json
{
    "price": {
        "finalPrice": 9.95,
        "formatted": "Ihr Preis 9.95 EUR",
        "personalOffer": {
            "normalPrice": 19.99,
            "formatted": "Unser Normalpreis 19,99 EUR"
        }
    }
}
```

### listing item `price.value.formatted` variations

#### standard

```json
{
    "price": {
        "finalPrice": 9.95,
        "formatted": "9.95 EUR"
    }
}
```

#### special

```json
{
    "price": {
        "finalPrice": 9.95,
        "formatted": "Nur 9.95 EUR"
    }
}
```

#### special with variant

```json
{
    "price": {
        "finalPrice": 9.95,
        "formatted": "Ab nur 9.95 EUR"
    }
}
```

#### personal offer, discount and both

```json
{
    "price": {
        "finalPrice": 9.95,
        "formatted": "Ihr Preis 9.95 EUR"
    }
}
```

#### personal offer, discount and both with variant

```json
{
    "price": {
        "finalPrice": 9.95,
        "formatted": "Ihr Preis ab 9.95 EUR"
    }
}
```
