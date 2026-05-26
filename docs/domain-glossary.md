# Domain Glossary

| Term | Code name | Business meaning | Used in | Not this |
| --- | --- | --- | --- | --- |
| Product | `Product`, `products` | A catalog item that can be shown, edited, audited, and eventually published. | Existing model, API, Filament resource, tests. | Not a product category and not a supplier. |
| Category | `Category`, `categories` | A business grouping of products, such as refrigerators or kettles. | Existing model and product classification. | Not an attribute group. |
| Supplier | `Supplier`, `suppliers` | A company or person that supplies products. | Existing product relation. | Not part of the flexible-attributes practice in v1. |
| Unit | `Unit`, `units` | A measurement unit used by products. | Existing product relation. | Not the same as an attribute type. |
| ProductAudit | `ProductAudit`, `product_audits` | A record of important product changes. | Existing create/update flow. | Not the source of product rules. |
| AttributeGroup | `AttributeGroup`, `attribute_groups` | A group that organizes attributes for admin readability, for example technical specs or dimensions. | Future schema, admin panel. | Not a product category. |
| Attribute | `Attribute`, `attributes` | A reusable definition of a product characteristic, such as power or energy class. | Future schema, category settings. | Not the value filled for one product. |
| AttributeValue | `AttributeValue`, `attribute_values` | The value of one attribute for one concrete product. | Future product card data. | Not the attribute definition itself. |
| CategoryAttribute | `CategoryAttribute`, `category_attributes` | A rule that says which attributes are available for a category, whether they are required, filterable, and ordered. | Future category configuration and publication rule. | Not just a technical pivot table. |

## Important Distinctions

`Category` answers what kind of product this is. `AttributeGroup` only helps organize product characteristics. A refrigerator category can have an attribute group called technical specifications, but that group is not itself a refrigerator category.

`Attribute` answers what can be filled. `AttributeValue` answers what was actually filled for a concrete product. The attribute "Power" can exist once, while many kettles have different power values.
