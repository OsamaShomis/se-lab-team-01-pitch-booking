# Git Workflow & Version Control Rules (`ai/rules/git.md`)

> **Branching Protocols, Commit Hygiene & Collaborative Merge Governance**

---

## 1. Branching Strategy

- **Protected Main Branch:** Never commit directly to `main`. All additions and modifications must arrive via Pull Requests.
- **Branch Naming Standard:**
  - `feature/<short-description>`: New functional features (e.g., `feature/booking-slots`).
  - `docs/<short-description>`: Documentation, SRS, or architecture updates (e.g., `docs/universal-ai-system`).
  - `fix/<short-description>`: Bug repairs and corrections (e.g., `fix/slot-collision`).
  - `test/<short-description>`: Test additions or test suite maintenance.

---

## 2. Commit Message Standards (Conventional Commits)

Format every commit message clearly:
`<type>(<optional-scope>): <imperative description>`

Allowed types:
- `feat:` A new feature or user-facing functionality.
- `fix:` A bug repair.
- `docs:` Documentation additions or updates.
- `test:` Adding or adjusting automated tests.
- `refactor:` Code change that neither fixes a bug nor adds a feature.
- `chore:` Maintenance tasks, dependency updates, or configuration.

Examples:
- `docs: add universal ai agent system and adapters`
- `feat(booking): implement slot locking transaction`
- `fix(auth): prevent timing attack on password verification`

---

## 3. Pull Request & Review Protocol

- Every PR must clearly reference its related Issue (e.g., `Closes #4` or `Relates to #2`).
- PRs must outline:
  1. What changed.
  2. Why the change was made.
  3. How it was tested.
  4. Any required documentation updates.
- **No Self-Review:** Code must be reviewed and approved by another team member before merging.
- **Maintainer Authority:** Merging into `main` is reserved exclusively for the Repository Maintainer (`Mo-ra778`).
