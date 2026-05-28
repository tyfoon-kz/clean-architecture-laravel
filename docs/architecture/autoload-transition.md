# Autoload transition to src

На переходном шаге namespace App\ временно смотрит и в app/, и в src/. Это нужно, чтобы добавлять новые классы Clean Architecture маленькими проверяемыми шагами и не ломать существующий Laravel code за один коммит.

Финальная цель переноса - оставить application structure в src/. После переноса реальных classes из app/ в src/ mapping должен стать простым:

```json
{
  "App\\": "src/"
}
```

После любого изменения autoload.psr-4 нужно запускать:

```bash
composer dump-autoload
```
