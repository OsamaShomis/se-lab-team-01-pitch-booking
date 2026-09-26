# Team Ownership & Collision Prevention Rules (`ai/rules/team-boundaries.md`)

> **Mandatory AI Governance: Enforcing Individual Member Boundaries to Prevent Code Collisions**

This rule is **binding on all AI assistants** (Claude, Gemini, Cursor, Copilot, Codex, etc.). It guarantees that when an engineer uses an AI assistant, the AI will **never silently modify, overwrite, or implement features or files assigned to another team member** without explicit delegation.

The authoritative source of assignments is [`docs/WORK_DISTRIBUTION.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/WORK_DISTRIBUTION.md).

---

## 1. Prime AI Boundary Directive

- **Identify the Active Developer:** The AI agent must determine or confirm which team member is giving the prompt:
  - **Osama Shomis (`OsamaShomis`)** — Team Coordinator & Requirements Owner
  - **Mohammed Al-Idrisi (`Mo-ra778`)** — Repository Maintainer & Developer
  - **Osama Al-Oqab (`osalokab`)** — Developer & Quality Reviewer
- **Boundary Check Before Action:** Before generating code, editing files, or proposing diffs, the AI agent **must verify** that the requested task falls strictly within the active developer's authorized scope.
- **Halt on Collision Risk:** If an instruction attempts to modify files, features, or branches assigned to a different team member, the AI **must halt immediately** and present the safety warning below.

---

## 2. Team Member Ownership Matrix

### A. Osama Shomis (`OsamaShomis` — Coordinator)
- **Authorized Documentation Scope:**
  - `docs/PROJECT_BRIEF.md`, `docs/TEAM_ROLES.md`, `docs/SRS.md`, `docs/USER_FLOW.md`
  - `docs/Design-System.md`, `docs/UI-Structure.md`, `docs/DEFINITION_OF_DONE.md`
  - `docs/WORK_DISTRIBUTION.md`
- **Authorized Application Features:**
  - **FR-01:** Account registration & authentication (`feature/auth`)
  - **FR-02:** Pitch catalog browsing & pitch details (`feature/pitches-listing`)
- **Prohibited for AI (Unless Explicitly Delegated):**
  - Modifying `Architecture.md`, `Database.md`, `API.md` (Mohammed's domain).
  - Modifying backend slot locking logic (`FR-04`) or slots grid (`FR-03`).
  - Modifying owner dashboard (`FR-05`) or cancellation logic (`FR-06`).
  - Merging Pull Requests directly into `main` (Maintainer only).

---

### B. Mohammed Al-Idrisi (`Mo-ra778` — Maintainer)
- **Authorized Documentation Scope:**
  - `docs/Technical-Specification.md`, `docs/Architecture.md`
  - `docs/Database.md`, `docs/API.md`
  - Step 13 Prototype / Wireframes specifications
- **Authorized Application Features:**
  - **FR-03:** Real-time available time-slots grid (`feature/time-slots`)
  - **FR-04:** Reservation booking & database transaction locking (`feature/booking`)
- **Exclusive Repository Authority:**
  - Sole authorized team member to merge approved Pull Requests into `main`.
- **Prohibited for AI (Unless Explicitly Delegated):**
  - Overwriting or unilaterally altering UI Design System tokens or colors (`Design-System.md`).
  - Modifying authentication logic (`FR-01`) or pitch catalog (`FR-02`).
  - Modifying owner dashboard (`FR-05`) or cancellation logic (`FR-06`).
  - Self-approving PRs.

---

### C. Osama Al-Oqab (`osalokab` — Reviewer)
- **Authorized Documentation Scope:**
  - `docs/Testing.md`, `docs/EDGE_CASES_WORKSHEET.md`
  - Quality assurance and Integration/Acceptance test specifications
- **Authorized Application Features:**
  - **FR-05:** Pitch owner dashboard & daily schedule view (`feature/owner-dashboard`)
  - **FR-06:** Reservation cancellation (with 2-hour window rule `BR-03`) (`feature/cancellation`)
- **Prohibited for AI (Unless Explicitly Delegated):**
  - Overwriting booking concurrency locking (`FR-04`) or catalog logic (`FR-02`).
  - Modifying Design System tokens or UI structure without consultation.
  - Merging PRs into `main` (Maintainer only).
  - Self-reviewing own PRs.

---

## 3. Mandatory AI Refusal & Warning Protocol

If a team member inadvertently prompts the AI to modify or build a component belonging to another member, the AI **must not execute the edit**. Instead, it must immediately output:

```markdown
> [!WARNING]
> **TEAM OWNERSHIP BOUNDARY TRIGGER (تنبيه حوكمة الفريق لمنع التضارب)**
> - **Target Component:** [e.g., `FR-04: Booking Concurrency` or `docs/Architecture.md`]
> - **Assigned Owner:** **[Owner Name / GitHub Handle]** (according to `docs/WORK_DISTRIBUTION.md`)
> - **Action Halted:** To prevent accidental code overwrites and git merge conflicts, the AI cannot modify this component without confirmation.
>
> **How to Proceed:**
> 1. If you are the assigned owner, please confirm your active identity.
> 2. If you are collaborating by official team agreement, state: *"I am delegated by [Owner Name] to edit this file."*
> 3. Otherwise, please switch to your assigned feature branch.
```

---

## 4. Git Branch Isolation Protocol for AI Agents

- **Zero Cross-Branch Pollution:** When working on a task, the AI agent must verify it is on the designated branch:
  - Shomis: `feature/auth` or `feature/pitches-listing`
  - Mohammed: `feature/time-slots` or `feature/booking`
  - Al-Oqab: `feature/owner-dashboard` or `feature/cancellation`
- The AI agent must never recommend or execute a commit of another member's feature files into an unrelated branch.
