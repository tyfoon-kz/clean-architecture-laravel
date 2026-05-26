# Business Brief: Flexible Product Catalog Attributes

## Business Context

The current project already contains a working product catalog: `Product`, `Category`, `Supplier`, `Unit`, `ProductAudit`, API endpoints, Filament resources, policies, queue examples, and tests. This is enough for a basic CRUD catalog, but the business problem is starting to change.

The company sells different kinds of equipment. A refrigerator, a kettle, a vacuum cleaner, and a coffee machine are all products, but they are not described by the same set of characteristics. A refrigerator needs volume, energy class, chamber count, and shelf material. A kettle needs power, capacity, body material, and auto shut-off. A vacuum cleaner needs cleaning type, suction power, container type, and noise level.

## Participants

Catalog administrators configure product data and fill product cards. Buyers and customers use the catalog to compare products. Managers expect the catalog to support new categories without a development release for every new field. Developers maintain the database schema, API, admin panel, tests, and business rules.

## Expected Value

Flexible attributes let the business add category-specific product characteristics without endlessly adding columns to the `products` table. This reduces release pressure, keeps product cards more accurate, and makes future filters easier to build.

The goal is not to build a universal marketplace engine in one step. The first goal is to evolve the existing catalog so it can describe different product categories with one understandable model.

## Data Quality Risks

Poor data quality becomes expensive when products are published with missing required attributes, values are stored in the wrong type, or filters are based on incomplete information. If the system allows a refrigerator without volume or a kettle without power, the catalog may look technically valid while being useless for the business.

## Why Not More Product Columns

Adding a new column to `products` for every new characteristic looks simple at first. It becomes painful when most columns apply only to one category, every new assortment change requires a migration, and forms/API responses keep growing with fields that do not belong to most products.

The better direction is to keep the inherited `Product` model and add a flexible attribute model around it: attribute groups, attributes, category-attribute settings, and product attribute values.

## Scope for V1

The code practice in this course stays around products, categories, attributes, attribute values, and publication rules. Suppliers, warehouse, purchasing, and reporting remain useful theoretical context, but they are not expanded in code in this version.
