# Architecture Rules (`ai/rules/architecture.md`)

> **Architectural Patterns, Separation of Concerns & Boundary Integrity**

---

## 1. Respect Established Architectural Patterns

- Maintain clear separation of concerns across layers:
  - **Controllers / Routing:** Handle HTTP requests, input validation, and delegate business logic. Keep controllers thin.
  - **Services / Domain Logic:** Encapsulate core domain operations, business validations, and complex transactions.
  - **Models / Persistence:** Handle data definitions, relationships, and queries. Avoid stuffing controllers with raw SQL queries.
  - **Views / API Resources:** Format outgoing data and manage display structures.

---

## 2. No Unapproved Architectural Pivots

- Do not switch architectural paradigms (e.g., converting MVC to Event-Sourced or Microservices) without formal human approval.
- Do not introduce new architectural abstractions (e.g., Repository Pattern, CQRS, Service Bus) unless already present or specified in [`docs/Architecture.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Architecture.md).

---

## 3. Dependency Management

- Never add a new third-party library or composer/npm package without assessing:
  1. Can this be accomplished cleanly with built-in platform capabilities?
  2. What is the bundle/maintenance overhead?
  3. Does the team agree with adding this dependency?
- Always require human approval before adding major dependencies.

---

## 4. Concurrency & Transactions

- Operations that mutate shared, limited resources (specifically booking time slots in KooraPlus) **must** run inside ACID database transactions with appropriate locking to prevent race conditions (`BR-02`).
- Never leave transactional write operations without automatic rollback on failure.
