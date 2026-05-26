# Classic PHP/FPM Request Lifecycle

In the classic PHP mental model, every HTTP request enters a fresh application lifecycle.
The web server accepts the HTTP request, forwards PHP work to the PHP runtime, Laravel loads configuration, service providers, routes and middleware, then the request is handled and the response is returned.

This model is predictable and forgiving.
If a developer accidentally keeps mutable data in a PHP object, the mistake is often hidden because the process lifetime is short.
The cost is repeated bootstrap: the framework pays part of the startup work again and again.

This course uses that baseline to explain why Octane exists.
FPM is not "bad"; it is a stable model with a different lifecycle and different tradeoffs.
