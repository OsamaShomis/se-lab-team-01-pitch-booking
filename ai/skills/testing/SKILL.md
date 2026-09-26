# Skill: Testing & Verification (`ai/skills/testing/SKILL.md`)

## Purpose
Design, write, execute, and report automated and manual test scenarios to guarantee correctness, reliability, edge-case resilience, and business rule enforcement.

## When to Use
- Alongside feature implementation, bug fixing, refactoring, or pre-PR verification.

## Required Inputs
- Requirements, Acceptance Criteria, and Business Rules from [`docs/SRS.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/SRS.md).
- Quality standards from [`docs/Testing.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Testing.md) and [`ai/rules/testing.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/testing.md).

## Steps
1. **Identify Test Cases:** Enumerate positive cases (happy path), negative cases (invalid input, unauthorized access), and edge cases (boundary conditions).
2. **Setup Test Fixtures:** Prepare seed data, factories, and mocks as necessary. Ensure isolation.
3. **Draft Automated Tests:** Write test methods using the Arrange-Act-Assert (AAA) pattern.
4. **Execute Tests:** Run the test suite via the CLI runner.
5. **Analyze Results:** If any test fails, debug and rectify the code under test until all tests pass cleanly.
6. **Report Honestly:** Document exact test run outputs. If automated execution was unavailable, state this clearly without false claims.

## Rules
- Strictly adhere to the Truth in Testing directive ([`ai/rules/testing.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/rules/testing.md)).
- Test race conditions explicitly for concurrent slot booking (`BR-02`).
- Test cancellation thresholds at exactly 120 minutes vs 119 minutes (`BR-03`).

## Validation
- 100% of newly written tests pass.
- Edge cases and validation boundaries are demonstrably covered.

## Expected Output
- Automated test classes/files.
- Test execution output or truthful verification summary.

## Human Approval Requirements
- Required before disabling or deleting existing tests.
