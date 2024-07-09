Navigation: Getting started/Search Examples
sortOrder: 130

# Search Example

The following example will show you how to make search request to the API. For example, by making a `POST` request to
`https://example.org/api.php/v2/orders/search` you are able add a search condition, that will be used while reading data
from the database.

More details about, which endpoint does support searching, is documented in the documentation of the endpoints itself.

**Example request through cURL:**
```
curl -XPOST https://example.org/api.php/v2/orders/search -d '{"search": {"match": {"orders.orders_id": "400210"}}}'
```

**Response:**
```json
[
  {
    "id": 400210,
    "statusId": 1,
    "statusName": "Offen",
    "totalSum": "53,58 EUR",
    "purchaseDate": "2015-11-06 12:22:39",
    "comment": "",
    ...
  }
]
```

## Defining search conditions

It is very easy to define even complex search conditions. There are several search operations, that can be used:

- **match:** Searching for an exact term.
- **not:** Searching for values that are different from the given value.
- **like:** Searching for a term allowing wildcards.
- **range:** Searching for values that are in a given range.
- **in:** Searching for values that are in a given list of elements.
- **greater:** Searching for values that are higher or equal a given value.
- **lower:** Searching for values that are lower or equal a given value.
- **must:** Allows building complexer conditions with AND-condition.
- **should:** Allows building complexer conditions with OR-condition.

It is important to know, that all this operations do need to be inside the `search` attribute of the json object you send
with your request. Inside this `search` attribute you can add as many operations you want.

### Further examples

The following examples show you, how you can use the operations and what kind of SQL where condition is used while reading
data from the database.

#### Match
```json
{
	"search": {
		"match": {"customers.customers_id": "1"}
	}
}
```

**Results in:** WHERE &#96;customers&#96;.&#96;customers_id&#96; = "1"

#### Not
```json
{
	"search": {
		"not": {"customers.customers_id": "1"}
	}
}
```

**Results in:** WHERE &#96;customers&#96;.&#96;customers_id&#96; != "1"

#### Like
```json
{
	"search": {
		"like": {"customers.customers_firstname": "Max%"}
	}
}
```

**Results in:** WHERE &#96;customers&#96;.&#96;customers_firstname&#96; LIKE "Max%"`

#### Range
```json
{
	"search": {
		"range": {"customers.customers_id": 
			{
				"start": 1,
				"end": 10
			}
		}
	}
}
```

**Results in:** WHERE &#96;customers&#96;.&#96;customers_id&#96; BETWEEN "1" AND "10"`

#### In
```json
{
	"search": {
		"in": {"customers.customers_firstname": ["Max", "Moritz", "Maria"]}
	}
}
```

**Results in:** WHERE &#96;customers&#96;.&#96;customers_firstname&#96; IN ("Max", "Moritz", "Maria")`

#### Greater
```json
{
	"search": {
		"greater": {"customers.customers_dob": "2000-01-01 00:00:00"}
	}
}
```

**Results in:** WHERE &#96;customers&#96;.&#96;customers_dob&#96; > "2000-01-01 00:00:00"`

```json
{
	"search": {
		"geq": {"customers.customers_id": "100"}
	}
}
```

**Results in:** WHERE &#96;customers&#96;.&#96;customers_id&#96; >= "100"`

#### Lower
```json
{
	"search": {
		"lower": {"customers.customers_dob": "2000-01-01 00:00:00"}
	}
}
```

**Results in:** WHERE &#96;customers&#96;.&#96;customers_dob&#96; < "2000-01-01 00:00:00"`

```json
{
	"search": {
		"leq": {"customers.customers_id": "100"}
	}
}
```

**Results in:** WHERE &#96;customers&#96;.&#96;customers_id&#96; <= "100"`

#### Must
```json
{
	"search": {
		"must": [
			{"match": {"customers.customers_firstname": "John"}},
			{"match": {"customers.customers_lastname": "Doe"}}
		]
	}
}
```

**Results in:** WHERE (&#96;customers&#96;.&#96;customers_firstname&#96; = "John") AND (&#96;customers&#96;.&#96;customers_lastname&#96; = "Doe"`)`

#### Should
```json
{
	"search": {
		"should": [
			{"match": {"customers.customers_firstname": "John"}},
			{"match": {"customers.customers_firstname": "Jane"}}
		]
	}
}
```

**Results in:** WHERE (&#96;customers&#96;.&#96;customers_firstname&#96; = "John") OR (&#96;customers&#96;.&#96;customers_firstname&#96; = "Jane")`


## Available Database Attributes and Tables
In the different search endpoint not all database attributes can be used.
The following list shows you, which database tables and attributes can be used.


### Categories Endpoint
- **categories**
	- categories_id
	- categories_image
	- parent_id
	- categories_status
	- categories_template
	- group_permission_0
	- group_permission_1
	- group_permission_2
	- group_permission_3
	- listing_template
	- sort_order
	- products_sorting
	- products_sorting2
	- date_added
	- last_modified
	- categories_icon
	- categories_icon_w
	- categories_icon_h
	- group_ids
	- gm_show_attributes
	- gm_show_graduated_prices
	- gm_show_qty
	- gm_priority
	- gm_changefreq
	- gm_sitemap_entry
	- gm_show_qty_info
	- show_sub_categories
	- show_sub_categories_images
	- show_sub_categories_names
	- show_sub_products
	- view_mode_tiled
	- feature_mode
	- feature_display_mode
	- show_category_filter
- **categories_description**
	- categories_id
	- language_id
	- categories_name
	- categories_heading_title
	- categories_description
	- categories_meta_title
	- categories_meta_description
	- categories_meta_keywords
	- gm_alt_text
	- gm_url_keywords


### Customers Endpoint
- **customers**
	- customers_id
	- customers_cid
	- customers_vat_id
	- customers_vat_id_status
	- customers_warning
	- customers_status
	- customers_gender
	- customers_firstname
	- customers_lastname
	- customers_dob
	- customers_email_address
	- customers_default_address_id
	- customers_telephone
	- customers_fax
	- customers_password
	- customers_newsletter
	- customers_newsletter_mode
	- member_flag
	- delete_user
	- account_type
	- password_request_key
	- payment_unallowed
	- shipping_unallowed
	- refferers_id
	- customers_date_added
	- customers_last_modified


### Manufacturers Endpoint
- **manufacturers**
	- manufacturers_id
	- manufacturers_name
	- manufacturers_image
	- date_added
	- last_modified


### Orders Endpoint
- **orders**
	- orders_id
	- customers_id
	- customers_cid
	- customers_vat_id
	- customers_status
	- customers_status_name
	- customers_status_image
	- customers_status_discount
	- customers_name
	- customers_firstname
	- customers_lastname
	- customers_gender
	- customers_company
	- customers_street_address
	- customers_house_number
	- customers_additional_info
	- customers_suburb
	- customers_city
	- customers_postcode
	- customers_state
	- customers_country
	- customers_telephone
	- customers_email_address
	- customers_address_format_id
	- delivery_name
	- delivery_firstname
	- delivery_lastname
	- delivery_gender
	- delivery_company
	- delivery_street_address
	- delivery_house_number
	- delivery_additional_info
	- delivery_suburb
	- delivery_city
	- delivery_postcode
	- delivery_state
	- delivery_country
	- delivery_country_iso_code_2
	- delivery_address_format_id
	- billing_name
	- billing_firstname
	- billing_lastname
	- billing_gender
	- billing_company
	- billing_street_address
	- billing_house_number
	- billing_additional_info
	- billing_suburb
	- billing_city
	- billing_postcode
	- billing_state
	- billing_country
	- billing_country_iso_code_2
	- billing_address_format_id
	- payment_method
	- cc_type
	- cc_owner
	- cc_number
	- cc_expires
	- cc_start
	- cc_issue
	- cc_cvv
	- comments
	- last_modified
	- date_purchased
	- orders_status
	- orders_date_finished
	- currency
	- currency_value
	- account_type
	- payment_class
	- shipping_method
	- shipping_class
	- order_total_weight
	- customers_ip
	- language
	- afterbuy_success
	- afterbuy_id
	- refferers_id
	- conversion_type
	- orders_ident_key
	- gm_orders_id
	- gm_packings_id
	- gm_orders_code
	- gm_packings_code
	- gm_order_send_date
	- gm_send_order_status
	- gm_cancel_date
	- abandonment_download
	- abandonment_service
	- orders_hash
	- intraship_shipmentnumber
	- exported
	- gambio_hub_module
	- gambio_hub_module_title
	- gambio_hub_transaction_code


### Parcel Services Endpoint
- **parcel_services**
	- parcel_services_id
	- name
	- default


### Products Endpoint
- **products**
	- products_id
	- products_ean
	- products_quantity
	- products_shippingtime
	- products_model
	- group_permission_0
	- group_permission_1
	- group_permission_2
	- group_permission_3
	- products_sort
	- products_image
	- products_price
	- products_discount_allowed
	- products_date_added
	- products_last_modified
	- products_date_available
	- products_weight
	- products_status
	- products_tax_class_id
	- product_template
	- options_template
	- manufacturers_id
	- products_ordered
	- products_fsk18
	- products_vpe
	- products_vpe_status
	- products_vpe_value
	- products_startpage
	- products_startpage_sort
	- group_ids
	- nc_ultra_shipping_costs
	- gm_show_date_added
	- gm_show_price_offer
	- gm_show_weight
	- gm_price_status
	- gm_min_order
	- gm_graduated_qty
	- gm_options_template
	- gm_priority
	- gm_changefreq
	- gm_show_qty_info
	- gm_sitemap_entry
	- products_image_w
	- products_image_h
	- gm_show_image
	- properties_dropdown_mode
	- properties_show_price
	- use_properties_combis_weight
	- use_properties_combis_quantity
	- use_properties_combis_shipping_time
	- product_type
- **products_description**
	- products_id
	- language_id
	- products_name
	- products_description
	- products_short_description
	- products_keywords
	- products_meta_title
	- products_meta_description
	- products_meta_keywords
	- products_url
	- products_viewed
	- gm_alt_text
	- gm_url_keywords
	- checkout_information
- **products_quantity_unit**
	- products_id
	- quantity_unit_id
- **products_to_categories**
	- products_id
	- categories_id