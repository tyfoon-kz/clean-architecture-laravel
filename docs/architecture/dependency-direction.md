# Dependency direction

Первое правило курса: внутренний код не должен зависеть от внешних деталей.

```text
Presentation -> Application -> Domain
Infrastructure -> Application, Domain
Domain -> nothing from Laravel
```

Это не запрет использовать Laravel. Это запрет помещать Laravel в центр бизнесового смысла. Если правило номенклатуры нельзя проверить без HTTP request, Filament form или Eloquent model, значит зависимость прошла слишком глубоко.
