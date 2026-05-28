# Nomenclature creation use cases

## Filament admin

Business actor вручную создает номенклатуру из admin UI. Важны понятная ошибка, audit trail и быстрое исправление данных.

## API client

Внешняя система отправляет данные. Важны стабильный contract, idempotency и machine-readable error.

## Document import

Оператор загружает файл. Важны batch validation, отчет по строкам и возможность повторного запуска.

Все три входа могут создавать похожую номенклатуру, но это не один и тот же use case.
