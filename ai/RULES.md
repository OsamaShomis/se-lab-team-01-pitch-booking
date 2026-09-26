# Universal AI Rules Hub (`ai/RULES.md`)

> **Governing Behavioral & Technical Rules for All AI Assistants**

This document establishes the mandatory behavioral and coding standards for all AI agents working in this repository. All AI assistants must adhere to these rules without exception.

---

## 1. Master Rule Priority Hierarchy

When deciding on any action, code change, or suggestion, follow this strict precedence hierarchy:

```
1. Explicit Human Instruction (User prompt)
      ↓
2. Approved Project Requirements (docs/SRS.md, etc.)
      ↓
3. Project Architecture & Technical Specs (docs/Architecture.md)
      ↓
4. Design System Guidelines (docs/Design-System.md)
      ↓
5. Universal AI Rules (ai/RULES.md & ai/rules/*.md)
      ↓
6. Universal AI Skills (ai/SKILLS.md & ai/skills/*/SKILL.md)
      ↓
7. Tool Adapter Instructions (adapters/*)
      ↓
8. AI Assumptions / Defaults (Lowest Priority)
```

> [!WARNING]
> If a lower-priority instruction contradicts a higher-priority one, the AI **must halt** and ask the human user for clarification. Do not make silent assumptions.

---

## 2. Fundamental AI Behavioral Principles

### What the AI Agent MUST Do:
- **Respect Context:** Read relevant files in `docs/` and `ai/` before planning or modifying code.
- **Prefer Existing Patterns:** Adhere to existing architectural conventions, naming schemes, and directory layouts.
- **Make Minimal Changes:** Implement only the changes strictly needed to satisfy the request. Avoid drive-by refactoring.
- **Preserve Documentation Integrity:** Maintain existing comments, type declarations, and documentation in modified files.
- **Validate Everything:** Verify changes through syntax checks, unit/feature tests, or explicit validation steps.
- **Flag Uncertainty:** Clearly mark unknowns with `[TO BE DEFINED]` or `[TODO]`.
- **Seek Human Approval:** Comply with the triggers documented in [`ai/HUMAN-APPROVAL.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/HUMAN-APPROVAL.md).

### What the AI Agent MUST NOT Do:
- **Never Invent Requirements:** Do not invent features, business logic, or constraints not documented by the team.
- **Never Invent APIs / Database Schemas:** Do not generate unverified external dependencies, tables, or endpoints.
- **Never Rewrite Code Arbitrarily:** Do not rewrite functioning modules simply to match subjective stylistic preferences.
- **Never Bypass Quality & Review Gates:** Do not push directly to protected branches (e.g., `main`) or bypass code review protocols.
- **Never Expose Secrets:** Do not commit passwords, API keys, tokens, or personal data.

---

## 3. Specialized Rule Modules

For deep technical directives, consult the respective specialized rule files:

| Rule Category | Description | File Path |
|---|---|---|
| **General** | Core reasoning, anti-hallucination, scope enforcement | [`ai/rules/general.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/general.md) |
| **Architecture** | Layered separation, service design, boundary management | [`ai/rules/architecture.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/architecture.md) |
| **Coding** | Code hygiene, defensive coding, typing, error handling | [`ai/rules/coding.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/coding.md) |
| **UI Design** | Component fidelity, design system, accessibility, UX | [`ai/rules/ui-design.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/ui-design.md) |
| **Testing** | Verification requirements, edge cases, truthfulness | [`ai/rules/testing.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/testing.md) |
| **Git** | Branch naming, commit hygiene, Pull Request rules | [`ai/rules/git.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/git.md) |
| **Documentation** | Keeping documentation synchronized and accurate | [`ai/rules/documentation.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/documentation.md) |

---

## 4. Change Management Workflow

Whenever a proposed change affects core abstractions, database tables, or business rules:
1. **Analyze Impact:** Identify all affected documentation and dependent components.
2. **Assess Risk:** Check whether human sign-off is mandated under [`ai/HUMAN-APPROVAL.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/HUMAN-APPROVAL.md).
3. **Execute Minimal Edit:** Make the focused update without collateral changes.
4. **Synchronize Docs:** Update corresponding documentation immediately.
5. **Log Entry:** Record the work in [`AI_Log.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/AI_Log.md).
