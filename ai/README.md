# AI Governance Core Directory (`ai/`)

Welcome to the **Universal AI Core** of the **KooraPlus** repository.

This directory serves as the **Single Source of Truth** for how artificial intelligence agents interact with, contribute to, and maintain this software repository.

---

## 1. Directory Structure

```
ai/
├── README.md             # This overview file
├── CONTEXT.md            # Authoritative project snapshot & domain context
├── RULES.md              # Central hub and index of all AI behavioral & coding rules
├── SKILLS.md             # Standard operating skills & execution workflows
├── HUMAN-APPROVAL.md     # Definite boundary criteria requiring explicit human sign-off
│
├── rules/                # Specialized domain rules
│   ├── general.md        # Core reasoning, anti-hallucination, scope enforcement
│   ├── architecture.md   # Architectural patterns, separation of concerns
│   ├── coding.md         # Code hygiene, style, defensive programming
│   ├── ui-design.md      # UI/UX guidelines, design tokens, accessibility
│   ├── testing.md        # Quality assurance, test coverage, edge cases
│   ├── git.md            # Git branching, commit conventions, PR protocol
│   └── documentation.md  # Documentation maintenance, truthfulness, formatting
│
└── skills/               # Reusable modular agent skill procedures
    ├── analyze-task/     # Task decomposition & risk analysis
    ├── implement-feature/# Focused feature implementation
    ├── fix-bug/          # Root-cause analysis & regression prevention
    ├── ui-development/   # User interface construction & polish
    ├── testing/          # Test creation, execution & verification
    ├── code-review/      # Rigorous peer review checklist
    ├── documentation/    # Accurate technical documentation drafting
    └── git-workflow/     # End-to-end branch, PR, and merge lifecycle
```

---

## 2. Core Architectural Philosophy

```
Project Documentation (docs/)
          ↓
  Universal AI Rules (ai/rules/)
          ↓
  Universal AI Skills (ai/skills/)
          ↓
   Tool Adapter (adapters/)
          ↓
    AI Assistant / Agent
```

- **Tool Agnostic:** The core rules and procedures are written in plain, human- and machine-readable Markdown. They do not depend on the quirks or vendor specifics of any single AI provider.
- **Documentation Driven:** The AI is strictly guided by the project documents in [`docs/`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs).
- **Zero Hallucination:** If a requirement, database table, or API schema is not documented in the project, it does not exist. Use `[TO BE DEFINED]` instead of making assumptions.
- **Human in the Loop:** The human engineer remains the ultimate decision maker. High-impact operations halt for human sign-off as defined in [`ai/HUMAN-APPROVAL.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/ai/HUMAN-APPROVAL.md).

---

## 3. Quick Links

- [Universal Entry Point](../AGENTS.md)
- [Project Context](./CONTEXT.md)
- [Universal Rules](./RULES.md)
- [Universal Skills](./SKILLS.md)
- [Human Approval Protocol](./HUMAN-APPROVAL.md)
