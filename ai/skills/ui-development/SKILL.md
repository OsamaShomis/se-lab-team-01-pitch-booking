# Skill: UI Development (`ai/skills/ui-development/SKILL.md`)

## Purpose
Construct, refine, and polish user interface screens and components with high visual fidelity, seamless responsiveness, state completeness, and strict adherence to the design system.

## When to Use
- When building frontend views, forms, navigation components, or styling interfaces.

## Required Inputs
- Requirements from [`docs/SRS.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/SRS.md) and user flows from [`docs/USER_FLOW.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/USER_FLOW.md).
- Visual tokens and styles from [`docs/Design-System.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Design-System.md).
- UI structure specifications from [`docs/UI-Structure.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/UI-Structure.md).

## Steps
1. **Design System Alignment:** Inspect defined tokens (colors, typography, spacing, border radii).
2. **Component Architecture:** Break the UI into reusable, semantic building blocks (e.g., slot card, pitch header, modal).
3. **State Coverage:** Implement the four required UI states: Loading, Success/Content, Empty, and Error.
4. **Responsive Optimization:** Verify and tune layouts across mobile viewport (375px+), tablet, and desktop.
5. **Accessibility Verification:** Verify high contrast, clear focus states, and semantic HTML markup.

## Rules
- Do not use arbitrary colors or magic pixel values; stick to design tokens.
- Keep interactive elements accessible (minimum 44x44px touch targets).
- Ensure smooth micro-interactions without distracting clutter.

## Validation
- Time slots clearly display green (available) vs. red (booked) status.
- Layout renders responsively on mobile and desktop without horizontal scroll.
- All form inputs provide immediate client-side and server-side validation feedback.

## Expected Output
- Reusable UI component files and templates.
- Accompanying stylesheets or design token references.
- Screenshots or rendered artifact walkthrough if supported.

## Human Approval Requirements
- Required before introducing brand-new UI component libraries or making major alterations to brand styling.
