# Testing & Quality Assurance Rules (`ai/rules/testing.md`)

> **Verification Standards, Test Coverage & Honest Reporting**

---

## 1. Truth in Testing Directive

- **No False Assurances:** The AI agent **must never** claim a feature, fix, or endpoint "works" unless it has executed the test suite or command and verified passing status.
- If testing was not executed (e.g., missing database setup, no active server, or lack of tool execution), the AI **must explicitly state**:  
  `"Verification note: The changes were written according to specification, but automated tests were not run in this environment. Manual verification or test execution is required."`

---

## 2. Comprehensive Test Dimensions

Whenever writing or evaluating tests, cover all relevant dimensions:

1. **Happy Path:** Expected, valid inputs yielding successful outputs.
2. **Invalid Input:** Malformed emails, negative prices, strings where numbers are required.
3. **Empty / Null Input:** Empty payloads, null fields, missing query parameters.
4. **Boundary & Edge Conditions:**
   - Booking a slot exactly 2 hours before kickoff vs. 1 hour and 59 minutes (evaluating `BR-03`).
   - Booking the very first and last available slots of the day.
5. **Concurrency & Race Conditions:**
   - Two users requesting the exact same pitch slot simultaneously (`BR-02`).
6. **Error Handling & Resilience:**
   - Graceful degradation when external services or database connections fail.
7. **Regression Prevention:**
   - Every bug fix must include a test asserting that the fixed bug cannot silently reoccur.

---

## 3. Test Structure & Cleanliness

- Follow the **Arrange-Act-Assert (AAA)** pattern.
- Keep tests isolated; tests must not depend on the execution order of other tests.
- Reset database state between tests using database transactions or migration rollbacks.
