# Skill: Code Review (`ai/skills/code-review/SKILL.md`)

## Purpose
Perform a thorough, objective, and structured evaluation of a Git diff or Pull Request against project requirements, architecture, coding hygiene, security, and test coverage before merging.

## When to Use
- When reviewing a teammate's PR or self-reviewing code prior to opening a PR.

## Required Inputs
- Git diff or Pull Request link.
- Target requirements in [`docs/SRS.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/SRS.md).
- Team rules in [`docs/WORK_DISTRIBUTION.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/WORK_DISTRIBUTION.md).

## Steps
1. **Scope Check:** Does the PR match its linked Issue and stay strictly within its defined scope?
2. **Architecture Compliance:** Does the code maintain layer separation and avoid leaky abstractions?
3. **Coding Standards:** Check for naming consistency, clean error handling, and avoidance of code duplication.
4. **Security Audit:** Scan for raw SQL queries, unescaped inputs, exposed secrets, or missing authorization checks.
5. **Testing Verification:** Are there adequate automated tests? Do edge cases have assertions?
6. **Documentation Sync:** Are relevant docs updated if endpoints, models, or configurations changed?
7. **Formulate Review Feedback:** Provide actionable, respectful feedback with clear line-item suggestions.

## Rules
- Enforce the team rule: "No one approves their own PR, and no one merges their own PR without peer review."
- Be constructive; distinguish between blockers (bugs, security risks) and non-blocking suggestions.

## Validation
- Review addresses logic correctness, security, performance, and style.
- Deficiencies are categorized with explicit suggestions for improvement.

## Expected Output
- Structured Code Review Report:
  - PR Overview & Assessment
  - Findings & Recommendations (Categorized by Blocker vs. Nitpick)
  - Approval Recommendation (Approve / Request Changes)

## Human Approval Requirements
- Required before any PR is merged to `main` (Maintainer `Mo-ra778` approval).
