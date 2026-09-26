# Skill: Implement Feature (`ai/skills/implement-feature/SKILL.md`)

## Purpose
Guide the clean, incremental, and compliant implementation of a new functional requirement or feature according to documented specifications without introducing architectural debt.

## When to Use
- When assigned an approved user story, requirement (e.g., `FR-01` to `FR-06`), or task from the project backlog.

## Required Inputs
- Approved requirement description from [`docs/SRS.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/SRS.md).
- Architectural specifications from [`docs/Architecture.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Architecture.md).
- Dedicated Git branch (e.g., `feature/<feature-name>`).

## Steps
1. **Branch Verification:** Ensure working on the appropriate feature branch.
2. **Data Layer Preparation:** If data models are needed, define migrations and models adhering strictly to documented schemas.
3. **Core Domain Logic:** Implement service logic, adhering to business rules (e.g., locking mechanisms, validation).
4. **Interface / Endpoint Delivery:** Create controller actions, request validators, and view components.
5. **Local Verification:** Run static checks and unit/feature tests.
6. **Documentation Sync:** Update relevant API docs or user flows if changes introduce new endpoints or parameters.

## Rules
- Adhere strictly to [`ai/rules/coding.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/coding.md) and [`ai/rules/architecture.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/architecture.md).
- Never modify unrelated components or perform drive-by refactoring.
- Keep dependencies minimal.

## Validation
- All acceptance criteria specified in the requirement are fulfilled.
- Automated tests pass locally.
- No regressions in existing features.

## Expected Output
- Cleanly implemented feature code across models, controllers, services, and views.
- Associated automated tests.
- Brief diff summary highlighting affected files.

## Human Approval Requirements
- Required before creating database migrations that alter existing tables.
- Required if implementing the feature necessitates adding a third-party dependency.
