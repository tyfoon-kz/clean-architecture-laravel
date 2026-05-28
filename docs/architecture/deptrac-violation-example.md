# Deptrac violation example

Нарушение:

```php
namespace App\Domain\Catalog\Nomenclature;

use Illuminate\Database\Eloquent\Model;
```

Почему это плохо: Domain начинает зависеть от Laravel storage detail. Такой код нельзя честно проверить как plain PHP domain.

Исправление: Eloquent остается в Infrastructure, а Domain получает обычный value object, entity или domain service без Laravel imports.
