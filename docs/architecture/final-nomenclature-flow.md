# Final nomenclature flow

Финальный учебный flow показывает проверяемую цепочку:

```text
Presentation adapter
  -> actor-specific Application command
  -> Application handler
  -> Domain value objects and rules
  -> Application port
  -> Infrastructure adapter
```

Laravel остается runtime и composition root. Бизнесовый смысл не обязан знать, пришел input из Filament, HTTP или console import.
