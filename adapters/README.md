# AI Tool Adapters (`adapters/`)

> **Compatibility Layer Connecting Specific AI Assistants to the Universal AI Core**

This directory contains lightweight, tool-specific adapter configurations that connect various AI coding assistants and autonomous agents to our **Universal AI Core**.

---

## 1. Architectural Role of Adapters

```
┌──────────────────────────────────────────────┐
│        Universal AI Core (AGENTS.md)         │
│          ai/CONTEXT.md | ai/RULES.md         │
└──────────────────────┬───────────────────────┘
                       │
       ┌───────────────┼───────────────┐
       ▼               ▼               ▼
┌──────────────┐┌──────────────┐┌──────────────┐
│claude/       ││gemini/       ││copilot/      │ ... [Other Tools]
│CLAUDE.md     ││GEMINI.md     ││copilot-instr │
└──────┬───────┘└──────┬───────┘└──────┬───────┘
       ▼               ▼               ▼
  Claude Code    Gemini Agent   GitHub Copilot
```

- **Non-Duplication:** Adapters **must not** duplicate rules, workflows, or project context. They exist purely as thin pointers directing the AI to the single source of truth.
- **Tool-Specific Conventions:** Each subdirectory addresses the precise instruction file or configuration mechanism expected by that tool.
- **Verification Rule:** If a tool's current native instruction discovery mechanism changes, mark it as `[VERIFY TOOL DOCUMENTATION]`.

---

## 2. Directory Matrix

| Assistant / Agent | Directory | Native Mechanism | Purpose |
|---|---|---|---|
| **Claude** | [`adapters/claude/`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/adapters/claude) | `CLAUDE.md` | Directs Anthropic Claude / Claude Code CLI to Universal Core |
| **Gemini** | [`adapters/gemini/`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/adapters/gemini) | `GEMINI.md` | Directs Google Gemini / Antigravity to Universal Core |
| **GitHub Copilot** | [`adapters/copilot/`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/adapters/copilot) | `copilot-instructions.md` | Directs GitHub Copilot chat & editor commands |
| **Cursor** | [`adapters/cursor/`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/adapters/cursor) | `.cursorrules` | Directs Cursor IDE agentic composer & autocomplete |
| **OpenAI Codex** | [`adapters/codex/`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/adapters/codex) | `instructions.md` | Workspace instructions for Codex / OpenAI tooling |

---

## 3. How to Deploy an Adapter

Depending on the tool in use, copy or link the corresponding adapter file to the repository location expected by that tool:
- **Claude:** Symlink or copy [`adapters/claude/CLAUDE.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/adapters/claude/CLAUDE.md) to root `CLAUDE.md`.
- **Copilot:** Symlink or copy [`adapters/copilot/copilot-instructions.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/adapters/copilot/copilot-instructions.md) to `.github/copilot-instructions.md`.
- **Cursor:** Symlink or copy [`adapters/cursor/.cursorrules`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/adapters/cursor/.cursorrules) to root `.cursorrules`.
- **Gemini:** Symlink or copy [`adapters/gemini/GEMINI.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/adapters/gemini/GEMINI.md) to root `GEMINI.md`.
