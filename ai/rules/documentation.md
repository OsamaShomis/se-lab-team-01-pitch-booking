# Documentation Governance Rules (`ai/rules/documentation.md`)

> **Synchronization, Truthfulness, Format Standards & Traceability**

---

## 1. Documentation as Source of Truth

- Project documentation located in [`docs/`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs) defines the authoritative reality of the system.
- Code must reflect documentation. If code changes alter user-facing behavior, API parameters, or database schemas, the relevant documentation files **must be updated in the same pull request**.

---

## 2. Zero-Fake-Content Policy

- Never fabricate documentation sections, fake endpoints, or fictitious technical specifications.
- If a document is under planning or awaiting team assignment, create a clean placeholder with `[TO BE DEFINED]` and reference the team member responsible according to [`docs/WORK_DISTRIBUTION.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/WORK_DISTRIBUTION.md).

---

## 3. Formatting & Linking Standards

- Use clean GitHub-Flavored Markdown.
- Provide clear headings (`#`, `##`, `###`) and structured tables for structured data.
- Use clickable, relative or `file:///` markdown links for referenced files and documents to enable instant navigation.
- Use GitHub callouts (`> [!NOTE]`, `> [!IMPORTANT]`, `> [!WARNING]`) appropriately to emphasize critical details without cluttering text.
