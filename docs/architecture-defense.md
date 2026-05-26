# Architecture Defense

## Business Context

The company sells several categories of equipment. Refrigerators, kettles, and vacuum cleaners are all products, but they do not share one fixed list of characteristics. Extending the inherited `products` table forever would make the schema sparse, fragile, and expensive to change.

The project starts from an existing Laravel/Filament CRUD system: `ProductApiController`, `ProductResource`, `ProductPolicy`, `ProductSaved`, `RecalculateProductSearchIndex`, mail/notification examples, uploads, and feature tests. The new architecture must extend that system without pretending it started from a blank folder.

## Glossary

`Product` is a catalog item. `Category` defines what kind of product it is. `Attribute` defines what can be filled. `AttributeValue` stores what was filled for a concrete product. `CategoryAttribute` says which attributes belong to a category and whether they are required or filterable. `AttributeGroup` organizes attributes for the administrator, but it is not a category.

## Attribute Model

The flexible model uses `attribute_groups`, `attributes`, `category_attributes`, and `attribute_values`. Typed value columns prevent all values from becoming one ambiguous string. Category attributes keep requiredness on the relation between category and attribute, because the same attribute can be required in one category and optional in another.

## Main Use Case

The main DDD-lite use case is product publication. Publishing a product is not just changing `status` to `published`. The use case loads the product, loads required category attributes, asks the domain object to protect the invariant, saves the published state, and records audit.

## Publication Rule

A product cannot be published if at least one required category attribute is missing. This rule lives deeper than `ProductApiController`, Filament Resource, or FormRequest validation. The reason is practical: the same action can later come from API, admin panel, import, console command, or queue.

## Laravel Adapters

`ProductPublicationController` translates HTTP into `PublishProductCommand`. Filament action translates an admin click into the same command. `ProductPolicy` still controls who may perform the action, but it does not decide whether the product itself is ready. Eloquent repository and Laravel transaction manager stay in infrastructure because they are framework/database details.

## Tests

Domain tests check the publication rule with plain PHP. Application-level tests check that the use case depends on a repository contract and transaction boundary. Feature tests check the HTTP adapter and response. Repository integration tests check that Eloquent restores required attributes and typed values correctly.

## Simplifications

This is DDD-lite, not full academic DDD. The course does not move every table into aggregates, does not create interfaces for every class, and does not isolate all Eloquent usage from the whole project. Simple CRUD remains where the business rule is simple. The stricter boundary appears where bypassing the rule would damage catalog quality.

## Risks And Next Steps

The next risks are deletion of used attributes, richer typed validation, imports, and search/filter behavior. These can be added later through the same principle: first describe the business process, then decide whether ordinary CRUD is enough or a named use case is needed.
