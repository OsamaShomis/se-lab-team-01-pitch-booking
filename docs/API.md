# API Specification (`docs/API.md`)

| Field | Value |
|---|---|
| Project | KooraPlus Pitch Booking Platform |
| Status | `[TO BE DEFINED]` |
| Owner | Mohammed Al-Idrisi (`Mo-ra778` — Maintainer & Developer) |
| Related | [`docs/WORK_DISTRIBUTION.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/WORK_DISTRIBUTION.md) (Step 10) |

---

## 1. Overview
RESTful API contracts, request payloads, response bodies, and HTTP status codes for KooraPlus endpoints.

## 2. Planned Endpoints
- `POST /api/auth/register`: User registration
- `POST /api/auth/login`: User authentication
- `GET /api/pitches`: List all available sports pitches
- `GET /api/pitches/{id}/slots?date=YYYY-MM-DD`: Retrieve slot availability grid
- `POST /api/bookings`: Create and lock a reservation
- `DELETE /api/bookings/{id}`: Cancel reservation (subject to 2-hour window rule `BR-03`)

## 3. Detailed Schemas
`[TO BE DEFINED]`

*(Content to be authored and approved by team maintainer).*
