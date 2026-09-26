# UI Design & Styling Rules (`ai/rules/ui-design.md`)

> **Visual Fidelity, Design System Compliance, Responsiveness & Usability**

---

## 1. Respect the Design System

- All user interface elements must strictly adhere to the approved tokens in [`docs/Design-System.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Design-System.md).
- Avoid arbitrary, one-off colors or random inline styles. Use consistent spacing scales, typography hierarchies, and component variants.
- Visual status indicators must be semantic and clear:
  - **Available Time Slot:** Green tint / success indicator.
  - **Booked Time Slot:** Red / disabled indicator.
  - **Pending / Selected:** Accent / brand indicator.

---

## 2. Responsive & Mobile-First Design

- The application must provide a first-class mobile experience since football players primarily reserve pitches via smartphones (`NFR-03`).
- Ensure touch targets are at least 44x44px.
- Use flexible layouts, responsive grids, and avoid fixed horizontal widths that cause overflow.

---

## 3. Feedback & State Completeness

Every interactive UI component or screen must handle all four primary states:
1. **Loading State:** Skeleton loaders or subtle spinners during asynchronous fetches.
2. **Success / Content State:** Smooth presentation of loaded data.
3. **Empty State:** Helpful illustration or message when no pitches or slots match filters.
4. **Error State:** Clear, constructive error message with an option to retry.

---

## 4. Accessibility (a11y) & Usability

- Maintain proper color contrast ratios (WCAG AA compliant).
- Use semantic HTML tags (`<nav>`, `<main>`, `<header>`, `<button>`, `<fieldset>`).
- Ensure form inputs have associated, readable labels and clear validation feedback.
