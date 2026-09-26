# Coding Standards & Hygiene (`ai/rules/coding.md`)

> **Defensive Coding, Conventions, Quality & Maintainability**

---

## 1. Clean & Explicit Code

- Write self-documenting code with meaningful, descriptive variable and function names.
- Avoid cryptic abbreviations or magic numbers; use named constants or enums.
- Maintain consistent indentation, casing, and file organization adhering to language standards (e.g., PSR-12 for PHP, modern standard JS/TS).

---

## 2. Defensive Programming & Error Handling

- **Never Trust Input:** Always validate all user input at boundaries (FormRequests, DTOs, or schema validators).
- **Graceful Failure:** Handle exceptions cleanly. Return clear, user-friendly error messages while logging detailed diagnostics internally.
- **Fail Safe:** If an unexpected error occurs during an operation (e.g., database connection dropped or timeout), ensure state rolls back and no corrupted partial records remain.

---

## 3. Security Fundamentals

- **No Plaintext Passwords:** Always hash passwords with strong algorithms (Bcrypt/Argon2).
- **SQL Injection Prevention:** Never concatenate raw user input into SQL queries. Always use parameterized queries or ORM bindings.
- **Cross-Site Scripting (XSS):** Ensure all dynamic output in views is properly escaped.
- **CSRF & Token Validation:** Protect all state-changing endpoints with CSRF tokens or bearer token authentication.
- **Zero Secrets in Code:** Never hardcode credentials, API tokens, or secrets. Rely strictly on `.env` configuration.

---

## 4. Performance & Efficiency

- Avoid N+1 database queries; always eager-load relationships when querying lists.
- Optimize database queries with appropriate indexing on frequently searched/filtered fields (e.g., pitch ID, date, status).
