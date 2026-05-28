# Clean Architecture layers

Presentation и Infrastructure принимают удар внешних изменений. Они похожи на переднюю и заднюю часть кузова автомобиля, которые сминаются ради защиты салона.

Application хранит use cases. Это салон: здесь не должны ломаться сценарии только потому, что изменилась форма, route, queue adapter или storage.

Domain хранит бизнесовый смысл. Это люди внутри салона: инварианты, значения, предметные ошибки и правила номенклатуры.

```text
src/
  Application/
  Domain/
  Infrastructure/
  Presentation/
```
