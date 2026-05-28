# Nomenclature flow dependency map

Сценарий: администратор создает номенклатуру.

```text
Filament form
  -> Presentation adapter
  -> Application command handler
  -> Domain rules
  -> Application repository contract
  -> Infrastructure Eloquent repository
  -> database
```

Важное место в этой цепочке - переход от Presentation к Application. Filament собирает input и вызывает use case. Он не должен решать, какие характеристики допустимы и как защищается SKU.
