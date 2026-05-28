# Clean Architecture defense

Главная идея курса: проект должен переживать изменения внешних деталей. Framework, UI, database, queue, import format and deployment runtime могут меняться. Business process и domain language должны оставаться понятными.

Компромиссы допустимы, но они должны быть названы. Если Presentation временно знает больше, чем хотелось бы, это записывается как debt. Если Infrastructure удобнее связать с Laravel напрямую, это нормально, пока Domain и Application не начинают зависеть от этой детали.

```bash
make architecture-check
make check
```
