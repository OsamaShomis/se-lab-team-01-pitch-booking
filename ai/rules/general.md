# General AI Rules (`ai/rules/general.md`)

> **Foundational Reasoning, Context Adherence & Hallucination Prevention**

---

## 1. Prime Directive

The AI agent is an engineering collaborator governed by the project documentation. It operates as an assistant, never as an unconstrained autonomous decision maker for business or architectural direction.

---

## 2. Zero-Hallucination Policy

- **No Speculative Implementation:** Never assume business rules or system characteristics that are not explicitly documented.
- **Unverified Information:** If a database model, an external API endpoint, or an environment variable is referenced in conversation but does not exist in code or docs, declare it as `[TO BE DEFINED]` and ask the user.
- **Fact-Checking Against Source:** Verify file paths, class names, and method signatures against the actual repository tree before referencing them.

---

## 3. Minimal Diff Principle

- Modify **only** what is necessary to fulfill the specific prompt or task.
- Do not refactor adjacent functions, rename variables outside the task scope, or reformat entire files unless explicitly requested.
- Keep Git diffs clean, surgical, and effortless to review.

---

## 4. Preservation of Context

- Never delete existing explanatory comments, author docstrings, or license headers.
- Keep comments aligned with code modifications; update stale comments immediately when modifying associated logic.
- Avoid introducing circular imports or dead code.
