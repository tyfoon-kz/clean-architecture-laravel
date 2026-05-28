# Laravel bootstrap boundary

bootstrap, config, routes, database, public и Laravel providers остаются внешней частью приложения. Они собирают runtime и подключают adapters.

CleanArchitectureServiceProvider является composition root для учебной архитектуры. Он может знать application contracts и infrastructure implementations, потому что binding находится на внешней границе.
