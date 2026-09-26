# Authoritative Project Context (`ai/CONTEXT.md`)

> **Notice to AI Agents:** This document reflects the authoritative, verified state of the **KooraPlus** project derived from approved project documentation ([`docs/SRS.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/SRS.md), [`docs/PROJECT_BRIEF.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/PROJECT_BRIEF.md), [`docs/WORK_DISTRIBUTION.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/WORK_DISTRIBUTION.md)).  
> **DO NOT** invent requirements, architecture, or technology stacks beyond what is recorded here. Where details are unconfirmed, they are explicitly designated as `[TO BE DEFINED]`.

---

## 1. Identity & Purpose

- **System Name:** KooraPlus Pitch Booking Platform (`منصة كورة بلص لحجز الملاعب الرياضية`)
- **Organization / Team:** SHIDRA TEAM (Team 01)
  - **Osama Shomis (`OsamaShomis`):** Team Coordinator & Requirements Owner
  - **Mohammed Al-Idrisi (`Mo-ra778`):** Repository Maintainer & Developer
  - **Osama Al-Oqab (`osalokab`):** Developer & Quality Reviewer
- **Primary Problem Statement:** Football players struggle to find available booking hours and suffer from reservation conflicts due to reliance on manual phone calls and unorganized paper logs by pitch owners.
- **Proposed Solution:** A centralized web platform displaying real-time available time slots (green = free, red = booked), enabling instantaneous booking confirmation with automatic concurrency locking to eliminate double bookings.

---

## 2. Target Users

| User Persona | Primary Goal | Core Needs |
|---|---|---|
| **Player / Captain** (`اللاعب / كابتن الفريق`) | Discover pitches and book hours quickly | Real-time slots visibility, instant confirmation, cancellation ability |
| **Pitch Owner / Manager** (`صاحب / مسؤول الملعب`) | Organize daily bookings and maximize occupancy | Management dashboard, real-time schedule, check-in & cancellation controls |

---

## 3. Scope Boundaries

### In-Scope (MVP)
- **FR-01:** Account registration & secure authentication (Players & Venue Owners).
- **FR-02:** Pitch catalog browsing & pitch details (name, location, turf type, hourly rate).
- **FR-03:** Interactive time-slot grid by date and pitch (visual free/booked indicators).
- **FR-04:** Reservation booking & locking mechanism for authenticated players.
- **FR-05:** Pitch owner dashboard for daily booking schedule and status updates (Confirmed / Completed / Cancelled).
- **FR-06:** Player booking cancellation (at least 2 hours prior to start time).

### Out-of-Scope (Strictly Excluded for MVP)
- Online electronic payment gateways (all payments are cash on arrival at the pitch).
- Tournament, cup, and league organization.
- Sports equipment rental and sportswear store.
- Paid SMS notifications (in-app notifications only).

---

## 4. Business Rules (`BR`)

- **BR-01:** No booking in the past. Slots earlier than the current timestamp cannot be selected.
- **BR-02:** Concurrency locking. A booked slot becomes immediately unavailable to other users. Double bookings must be prevented at the database transaction level.
- **BR-03:** Cancellation threshold. Players cannot cancel a reservation if less than 2 hours remain before the reserved slot.

---

## 5. Technology Stack & Architecture (Documented Baseline)

- **Backend Framework:** Laravel (PHP)
- **Database Engine:** MySQL with ACID Transactions
- **API Architecture:** RESTful API with token-based authentication (Laravel Sanctum)
- **Frontend / UI:** [TO BE DEFINED - pending final Technical-Specification.md & Design-System.md]
- **Hosting / Deployment:** [TO BE DEFINED]
- **Design Tokens (Colors, Typography):** [TO BE DEFINED - pending docs/Design-System.md]

---

## 6. Development & Quality Standards

- **Git Protocol:** Strict branch workflow (`feature/*`, `docs/*`, `fix/*`). No direct commits to `main`.
- **Review Protocol:** Peer review on every Pull Request. Repository maintainer (`Mo-ra778`) performs merges.
- **Testing Standard:** Every feature must include automated or verified tests covering happy path, edge cases, and regression.
