# Naming Decisions

## Current Names

| Business term | Class | Table/File | Decision |
| --- | --- | --- | --- |
| Product | `App\Models\Product` | `products` | Keep the inherited name. It is already used by API, Filament, policies, factories, and tests. |
| Category | `App\Models\Category` | `categories` | Keep the inherited name. It classifies products. |
| Supplier | `App\Models\Supplier` | `suppliers` | Keep the inherited name. It stays outside the v1 DDD-lite practice scope. |
| Unit | `App\Models\Unit` | `units` | Keep the inherited name. |
| ProductAudit | `App\Models\ProductAudit` | `product_audits` | Keep the inherited name for change history. |

## Future Attribute Names

| Business term | Class | Table | Example test or scenario name |
| --- | --- | --- | --- |
| AttributeGroup | `App\Models\AttributeGroup` | `attribute_groups` | `admin_can_create_attribute_group` |
| Attribute | `App\Models\Attribute` | `attributes` | `category_can_require_attribute` |
| AttributeValue | `App\Models\AttributeValue` | `attribute_values` | `product_stores_typed_attribute_value` |
| CategoryAttribute | `App\Models\CategoryAttribute` | `category_attributes` | `product_cannot_publish_without_required_category_attributes` |

## Open Questions

- Whether product publication should use a string `status`, a PHP enum cast, or a domain object at the application boundary.
- Whether the first implementation should keep Eloquent models as persistence models only, or introduce a small plain PHP domain object for publication.
- Whether category attributes should be edited through a separate Filament resource or through relation management on the category screen.

These questions should be answered when the code reaches the corresponding lesson. They should not be hidden behind confident names too early.
