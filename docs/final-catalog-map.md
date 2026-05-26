# Final Catalog Map

## Business Map

The final course state keeps the inherited Laravel CRUD and adds a focused DDD-lite line around catalog attributes and product publication.

Core concepts:

- `Product`: the catalog item that can be created, edited, audited, and published.
- `Category`: the business grouping that defines which attributes apply.
- `AttributeGroup`: an admin organization tool for attributes.
- `Attribute`: a reusable definition of a product characteristic.
- `CategoryAttribute`: the category's rule for required, filterable, and ordered attributes.
- `AttributeValue`: the concrete value of an attribute for one product.

## Code Map

- Eloquent persistence lives in `app/Models`.
- Filament CRUD for attribute setup lives in `app/Filament/Resources`.
- Publication domain rule lives in `app/Catalog/Domain/Products`.
- Publication use case lives in `app/Catalog/Application/Products`.
- Eloquent storage adapter lives in `app/Catalog/Infrastructure/Eloquent`.
- Laravel transaction adapter lives in `app/Catalog/Infrastructure/Laravel`.
- HTTP adapter lives in `ProductPublicationController`.
- Filament adapter lives in `ProductsTable` as a publish action.

## Test Map

- Domain tests protect publication without HTTP, Filament, or database.
- Application tests check the repository contract boundary.
- Feature tests check the HTTP adapter.
- Repository integration tests check Eloquent mapping for required attributes and typed values.

## Conscious CRUD

`AttributeGroup` and most attribute setup screens remain CRUD because they mainly manage reference data. Product publication uses DDD-lite because it protects a business state transition that can be triggered from more than one external input.
