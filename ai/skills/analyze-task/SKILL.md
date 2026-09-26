# Skill: Analyze Task (`ai/skills/analyze-task/SKILL.md`)

## Purpose
Systematically analyze an incoming task, prompt, or feature request before any code is modified or proposed, establishing technical scope, relevant project documentation, dependencies, risks, and an execution roadmap.

## When to Use
- At the start of any new user request, issue, or feature implementation.
- Before beginning work on refactoring or complex bug repairs.

## Required Inputs
- User prompt or GitHub Issue description.
- Relevant documentation files in [`docs/`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs) (e.g., [`docs/SRS.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/SRS.md), [`docs/USER_FLOW.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/USER_FLOW.md)).
- Project context in [`ai/CONTEXT.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/CONTEXT.md).

## Steps
1. **Clarify Intent:** Parse the request and classify it (Feature, Bug, Documentation, Refactor, or Query).
2. **Review Documentation:** Check `docs/` to find corresponding Functional Requirements (`FR-*`), Non-Functional Requirements (`NFR-*`), or Business Rules (`BR-*`).
3. **Inspect Existing State:** Read active codebase files to identify existing modules, classes, and patterns.
4. **Identify Dependencies & Risks:** Highlight side effects on database schemas, existing endpoints, UI components, or concurrency risks.
5. **Formulate Step Plan:** Create an incremental, numbered execution plan.
6. **Check Approval Triggers:** Review [`ai/HUMAN-APPROVAL.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/HUMAN-APPROVAL.md). Determine if human consent is required before proceeding.

## Rules
- Never jump directly to editing files without completing analysis.
- Mark all unverified assumptions as `[TO BE DEFINED]` or `[TODO]`.
- Keep the plan minimal, focused, and aligned with project conventions.

## Validation
- The plan identifies exact files to be created or modified.
- No requirements or business rules are invented.
- Potential risks are surfaced.

## Expected Output
- A structured Task Analysis brief containing:
  - Task Summary & Category
  - Referenced Documentation & Requirements
  - Impacted Files
  - Implementation Plan (Numbered Steps)
  - Approval Gate Status (Approved / Needs Human Decision)

## Human Approval Requirements
- Required if the task requests changes to scope, core requirements, architecture, or destructive operations.
