# Skill: Technical Documentation (`ai/skills/documentation/SKILL.md`)

## Purpose
Author, maintain, and synchronize clear, accurate, and structured project documentation that serves as the single source of truth for humans and AI agents alike.

## When to Use
- When introducing a new feature, modifying architectural components, clarifying requirements, or standardizing project workflows.

## Required Inputs
- Target documentation files in [`docs/`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs) or [`ai/`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai).
- Verified code implementation or approved human directives.
- Responsibility mapping from [`docs/WORK_DISTRIBUTION.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/WORK_DISTRIBUTION.md).

## Steps
1. **Locate Target Doc:** Identify the appropriate file in `docs/` (e.g., `Architecture.md`, `API.md`, `SRS.md`).
2. **Review Existing Content:** Read current contents to avoid duplicates or contradictory information.
3. **Draft Updates:** Structure the content using standard GitHub-Flavored Markdown, tables, callouts, and Mermaid diagrams.
4. **Enforce Zero-Hallucination:** If a technical detail is not yet decided by the team, mark it explicitly as `[TO BE DEFINED]` rather than inventing details.
5. **Cross-Reference Links:** Add working, clickable markdown links to related files and symbols.
6. **Validate Completeness:** Verify the document answers what, why, who, and how.

## Rules
- Never fabricate fake endpoints or imaginary schemas.
- Preserve document ownership: Coordinator owns Requirements/Design System; Maintainer owns Architecture/DB/API; Reviewer owns Testing/DoD.

## Validation
- Markdown parses cleanly without broken links or invalid syntax.
- All diagrams and tables render properly.

## Expected Output
- Complete or updated Markdown document.
- Diff summary of modified sections.

## Human Approval Requirements
- Required when modifying project scope, core functional requirements, or architectural baselines.
