# Architecture Notes

## Starting Point

This course starts from the final Laravel/Filament CRUD project of the previous PHP course. The project already has products, categories, suppliers, units, product audits, API endpoints, policies, queue examples, uploads, Filament resources, factories, seeders, and feature tests. We do not create a new Laravel skeleton because the purpose of this course is to evolve an existing business system.

The imported CRUD is treated as a working technical base. New decisions must continue that base instead of replacing it with an unrelated architecture exercise.

## Training Copy

All commands and file paths are considered relative to the project root. The student works in a training copy or platform workspace, not in an abstract example directory. This matters because architectural changes are only useful when they preserve the behavior that already exists.

## Sequential History

The course changes should form a readable history. Each step builds on the previous state: first workflow checks, then business language, then documents about rules, then schema, then Laravel code, then DDD-lite boundaries and tests.

This history is part of the learning material. A future developer should be able to read the repository and see why the project moved from ordinary CRUD toward a richer catalog model.

## Safety Point

`make check` is the first safety point. It verifies that the current Laravel/Filament application can still be inspected and tested before deeper changes begin. When a later change breaks the project, the team should be able to distinguish an environment problem from a business-modeling problem.

## Future Focus

The first business focus is the product catalog. The company sells different kinds of equipment, and different categories need different attributes. The course will keep suppliers, warehouse, purchasing, and reporting as theoretical context for now, while the code practice stays around products, categories, attributes, attribute values, and product publication.

## CRUD And DDD-lite In The Catalog

`attribute_groups` remain ordinary CRUD for now. A group only organizes attributes for display and sorting, so adding a domain layer around it would add ceremony without protecting a meaningful rule.

`attributes` are still mostly CRUD, but the `type` field already carries a business constraint. The project should not treat the attribute definition and the product's filled value as the same thing.

`category_attributes` are more important than a technical pivot table. The relation decides which attributes belong to a category, which are required, which are filterable, and how they are ordered. This relation participates in publication rules.

`attribute_values` are infrastructure data for concrete product cards. They need typed storage and integration tests because wrong columns would break filtering and comparison.

`products` require DDD-lite in the publication scenario. Creating or editing a draft product can still look like CRUD, but publishing a product protects catalog quality and must check required category attributes deeper than a controller, request, or Filament form.

The decision is not "DDD is always better". The decision is narrower: keep simple CRUD where the business meaning is simple, and introduce DDD-lite where a rule can be bypassed through multiple entry points.

## Transaction Boundary For Publication

Product publication changes more than one technical detail. The use case loads the product, checks required category attributes, changes publication state, saves the result, and records an audit event. These steps should succeed or fail as one scenario.

The transaction belongs to the application boundary, not to the domain object. The domain object decides whether publication is allowed. Laravel's `DB::transaction` belongs to infrastructure. `PublishProductService` connects those concerns through a small `TransactionManager` contract so the rule stays testable and the database mechanism stays outside the domain model.
