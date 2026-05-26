# Container Lifecycle Audit

| Service | Binding | Keeps request data? | Decision |
| --- | --- | --- | --- |
| ProductRepository | transient binding | no | safe as repository abstraction |
| TransactionManager | transient binding | no | safe; delegates to database transaction boundary |
| RequestContext | scoped binding | yes, request id | safe because scoped instance is reset per request lifecycle |
| RequestStateLeakProbe | resolved when route runs | demo only | unsafe static path exists only for local/testing diagnostics |

The audit rule is simple: a singleton may keep configuration and stateless collaborators, but it must not keep current user, request, tenant, filters or mutable form data.
