# Catalog Scenarios

## Refrigerator

Category: `Refrigerators`.

Configured attributes:

- `volume_liters`, required, filterable, decimal.
- `energy_class`, required, filterable, string.

Example product: `Frost 3000 Refrigerator`.

Filled values:

- `volume_liters`: `320`.
- `energy_class`: `A++`.

## Kettle

Category: `Kettles`.

Configured attributes:

- `power_watts`, required, filterable, integer.
- `volume_liters`, required, filterable, decimal.
- `auto_shut_off`, optional, filterable, boolean.

Example product: `Steel 1700 Kettle`.

Filled values:

- `power_watts`: `1800`.
- `volume_liters`: `1.7`.

## Vacuum Cleaner

Category: `Vacuum cleaners`.

Configured attributes:

- `cleaning_type`, required, filterable, string.
- `suction_power_watts`, required, filterable, integer.

Example product: `Dry 450 Vacuum Cleaner`.

Filled values:

- `cleaning_type`: `dry`.
- `suction_power_watts`: `450`.

## What The Scenarios Prove

All three scenarios use the same database model. No new columns were added to `products` for refrigerator-only, kettle-only, or vacuum-cleaner-only characteristics. No separate `RefrigeratorProduct`, `KettleProduct`, or `VacuumCleanerProduct` class was needed.

## Weak Spots For The Next Module

- CRUD can save a product without all required attributes.
- CRUD can store a value in the wrong typed column unless the application checks the attribute type.
- Product publication is still not protected as a business scenario.
- Deleting an attribute that already has product values can damage existing product cards if the rule is not made explicit.
