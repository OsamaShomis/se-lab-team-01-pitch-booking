# OpenAI Codex / Tooling Adapter Guide

- **Target Tool:** OpenAI Codex, ChatGPT Workspace Assistants, Custom GPTs.
- **Instruction Mechanism:** `[VERIFY TOOL DOCUMENTATION]` — Depending on the specific tool runner environment (e.g., OpenAI Assistant API, Custom Instructions, or CLI tool), inject `instructions.md` as the system prompt or project instruction.
- **Status:** Adapter provided with generic system instruction mechanism.
- **Usage:** Provide `adapters/codex/instructions.md` as system instruction to the agent runner.
