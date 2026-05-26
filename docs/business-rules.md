# Business Rules

## Input Checks

1. Product name is required in create and update requests. This is close to `StoreProductRequest`, `UpdateProductRequest`, and Filament form validation. It protects the interface from incomplete input and can be checked by feature tests.
2. Product price must be a non-negative number. This is an input and data-shape check. It protects the catalog from impossible commercial data and can be checked through API validation tests.

## Business Rules

3. A product cannot be published without required category attributes. This protects the quality of the catalog and must live deeper than a form, because publication can come from API, Filament, import, console command, or application service. A domain test should prove that incomplete products cannot be published.
4. An attribute value must match the attribute type. If an attribute is `integer`, its value should use the integer value column. This protects filters and comparisons. An integration test can check typed value storage.
5. A category decides which attributes are required for products in that category. Requiredness belongs to the category-attribute relation, not to the attribute definition alone. A test can create one attribute that is required for refrigerators but optional elsewhere.

## Scenario Rules

6. Product publication is a scenario, not a raw field update. It should check required attributes, change product status, and save the result in one application flow. A feature test can call an external adapter and verify that the adapter does not bypass the use case.
7. Deleting an attribute that already has product values is risky. The first implementation can restrict or postpone that behavior. A future test can prove that used attributes are not silently removed from existing product cards.

These rules are written before the code so the implementation has something concrete to protect.
