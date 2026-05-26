# Concurrency Notes

Race conditions are not exclusive to Octane.
They become harder to ignore when the application receives concurrent requests and keeps workers warm.

```bash
make race-demo
make locking-demo
```

The unsafe demonstration uses read -> calculate -> write.
Two workers can read the same value and both write the same next value.
That is a lost update.

The protected demonstration uses a lock around the critical section.
The tradeoff is important: correctness improves, but the critical section serializes part of the work.
In a real Laravel flow the equivalent decision could be atomic database increment, transaction with row lock, optimistic locking, queue serialization or a domain-specific idempotency rule.
