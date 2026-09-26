# Human Approval Gates & Boundaries (`ai/HUMAN-APPROVAL.md`)

> **Strict Operational Boundaries Governing Autonomous AI Actions**

To maintain repository integrity, team safety, and project alignment, the AI agent is explicitly **forbidden** from making unilateral decisions in several critical categories. In these scenarios, the AI **must halt execution**, present the rationale and proposed options to the human engineer, and await explicit human sign-off.

---

## 1. Mandatory Approval Triggers

The AI agent must seek explicit human confirmation before taking any action falling into these categories:

### A. Requirements & Scope
- [ ] Modifying project scope or altering in-scope / out-of-scope definitions in [`docs/SRS.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/SRS.md).
- [ ] Changing or relaxing business rules (`BR-01`, `BR-02`, `BR-03`).
- [ ] Removing or deprecating existing functional features or user stories.

### B. Architecture & Technology
- [ ] Changing the core technology stack (e.g., swapping Laravel, MySQL, or core runtime).
- [ ] Introducing major new external dependencies or heavy libraries.
- [ ] Restructuring architectural layers, directory hierarchies, or domain boundaries.

### C. Database & Data Integrity
- [ ] Executing destructive database migrations (`DROP TABLE`, `DROP COLUMN`, table truncations).
- [ ] Modifying core entity relationships or primary key conventions.
- [ ] Altering transaction boundaries on concurrency-critical operations (such as booking slot locking).

### D. API & Contract Stability
- [ ] Introducing breaking changes to existing REST endpoints, status codes, or payload schemas.
- [ ] Modifying public API contracts consumed by other team members or external clients.

### E. Design System & User Experience
- [ ] Altering brand identity tokens (primary palette, typography, brand assets).
- [ ] Replacing component libraries or radically modifying core navigation structures.

### F. Security & Credentials
- [ ] Altering authentication mechanisms, token lifecycles, or authorization policies.
- [ ] Disabling security middleware, CSRF protection, rate limiters, or input validation.
- [ ] Handling or exposing environment secrets, API keys, or credentials.

### G. Git Operations & Repository Hygiene
- [ ] Destructive Git operations: `git push --force`, `git reset --hard`, deleting remote branches.
- [ ] Pushing directly to the protected `main` branch.
- [ ] Bypassing team code review and merging Pull Requests without maintainer sign-off.

---

## 2. Standard Protocol for Seeking Human Approval

When an AI agent encounters a situation requiring human approval:

1. **Pause Action:** Do not execute the code, command, or file edit.
2. **Present Clear Context:**
   - **Trigger:** Why human approval is required.
   - **Proposed Change:** What will be changed, added, or deleted.
   - **Impact Assessment:** Side-effects on the codebase, tests, or documentation.
   - **Alternatives:** At least one alternative approach or the option to maintain status quo.
3. **Format:** Output the proposal in clear, numbered Markdown with a direct question:
   ```markdown
   > [!IMPORTANT]
   > **HUMAN APPROVAL REQUIRED**
   > - **Category:** [e.g., Database Schema Change]
   > - **Proposal:** [Summary of proposed change]
   > - **Reasoning:** [Why this change is needed]
   > - **Risk/Impact:** [Potential breaking points]
   >
   > Do you approve proceeding with this approach? (Yes / No / Modify)
   ```
4. **Await User Decision:** Resume only after receiving positive confirmation.
