# Skill: Fix Bug (`ai/skills/fix-bug/SKILL.md`)

## Purpose
Systematically isolate, reproduce, repair, and verify software bugs to eliminate root causes while preventing regressions.

## When to Use
- When addressing a bug report, unexpected failure, or failed test.

## Required Inputs
- Bug description, reproduction steps, error logs, and environment details.
- Active codebase files related to the faulty behavior.

## Steps
1. **Understand Failure:** Read the error trace or reproduction steps thoroughly.
2. **Reproduce Failure:** Write a failing automated test or minimal script reproducing the issue.
3. **Isolate Root Cause:** Trace the faulty execution path to its origin; do not merely mask symptoms.
4. **Apply Minimal Fix:** Implement the smallest clean fix that directly rectifies the root defect.
5. **Verify Resolution:** Run the reproducing test and confirm it now passes.
6. **Regression Check:** Run the entire relevant test suite to guarantee no adjacent behavior broke.

## Rules
- Do not apply "band-aid" fixes (e.g., suppressing exceptions, silencing errors, or hardcoding return values).
- Every bug fix should be accompanied by a test asserting prevention of that specific failure mode.

## Validation
- The failing reproduction test now passes cleanly.
- Full test suite passes without regressions.
- Root cause is documented and understood.

## Expected Output
- Bug fix commit diff.
- Regression test covering the failure scenario.
- Diagnostic report summarizing root cause and applied fix.

## Human Approval Requirements
- Required if the bug fix requires modifying data models, altering database schema, or breaking existing API contracts.
