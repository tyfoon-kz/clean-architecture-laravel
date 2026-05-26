# Catalog Attributes Schema

## Attribute Groups

`attribute_groups` organize attributes for humans. A group can be "Technical specifications", "Dimensions", or "Energy". The group helps the admin panel display related attributes together, but it does not classify products.

Main fields:

- `id`
- `name`
- `code`
- `sort_order`
- timestamps

## Attributes

`attributes` define reusable product characteristics. An attribute answers what can be filled: power, capacity, body material, energy class, noise level.

Main fields:

- `id`
- `attribute_group_id`
- `name`
- `code`
- `type`
- `sort_order`
- timestamps

Allowed `type` values:

- `string`
- `integer`
- `decimal`
- `boolean`
- `text`

`Attribute` is not the same as `AttributeValue`. The attribute "Power" is the definition. The value "1800 W" belongs to a concrete product.

## Attribute Values

`attribute_values` store attribute values for concrete products. The table connects an existing `products` record with an `attributes` record and stores the filled value.

Main fields:

- `id`
- `product_id`
- `attribute_id`
- `value_string`
- `value_integer`
- `value_decimal`
- `value_boolean`
- `value_text`
- timestamps

Only one value column should be used according to the attribute type. For example, "Power" with type `integer` uses `value_integer`, while "Body material" with type `string` uses `value_string`. This prevents the project from mixing human text, numeric values, booleans, and long descriptions in one ambiguous column.

## Typed Value Examples

- Power: `integer`, stored in `value_integer`.
- Capacity: `decimal`, stored in `value_decimal`.
- Body material: `string`, stored in `value_string`.
- Auto shut-off: `boolean`, stored in `value_boolean`.
- Product note: `text`, stored in `value_text`.

## Category Attributes

`category_attributes` connects existing `categories` with reusable `attributes`. It is not only a technical pivot table. It records a business decision: a category defines which attributes are available for its products, which of them are required, which can be used in filters, and in which order they should be shown.

Main fields:

- `id`
- `category_id`
- `attribute_id`
- `is_required`
- `is_filterable`
- `sort_order`
- timestamps

Requiredness belongs to this relation. The same attribute can be required for one category and optional for another category.

## Category Examples

Refrigerators:

| Attribute | Required | Filterable | Order |
| --- | --- | --- | --- |
| Volume | yes | yes | 10 |
| Energy class | yes | yes | 20 |
| Chamber count | no | yes | 30 |

Kettles:

| Attribute | Required | Filterable | Order |
| --- | --- | --- | --- |
| Power | yes | yes | 10 |
| Capacity | yes | yes | 20 |
| Auto shut-off | no | yes | 30 |

This relation appears after `attributes` because the project first needs reusable attribute definitions. Category settings then decide how those definitions behave for each category.

## Examples

Refrigerator:

- category: refrigerators
- attributes: volume, energy class, chamber count
- product values: 320 liters, A++, 2 chambers

Kettle:

- category: kettles
- attributes: power, capacity, body material
- product values: 1800 W, 1.7 liters, steel

Vacuum cleaner:

- category: vacuum cleaners
- attributes: cleaning type, suction power, container type
- product values: dry cleaning, 450 W, container

All three examples use the same model: products stay in `products`, characteristic definitions stay in `attributes`, and concrete values stay in `attribute_values`. The schema does not require new columns in `products` and does not require separate product classes for every equipment type.
