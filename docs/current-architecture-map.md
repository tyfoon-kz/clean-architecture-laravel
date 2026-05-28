# Current architecture map

Текущий проект еще в основном Laravel-centered. HTTP controllers, Filament resources, Eloquent models, jobs, policies и providers живут в стандартном namespace App\ и физически находятся в app/.

Важные входы:

- HTTP routes вызывают controllers.
- Filament resources дают admin UI.
- Console и queue code работают через Laravel runtime.
- Eloquent models описывают хранение.
- Domain-like catalog classes уже существуют, но пока лежат рядом с Laravel code.

Проблема не в Laravel. Проблема в том, что бизнесовый сценарий создания, публикации или импорта номенклатуры легко распадается между controller, Filament action, model observer и repository. Следующие уроки постепенно отделяют business process от способа входа и хранения.
