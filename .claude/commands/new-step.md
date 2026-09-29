---
description: Propose a plan for one incremental step, consistent with CLAUDE.md, then wait for approval
argument-hint: <description>
---

Enter plan mode for this: call the `EnterPlanMode` tool before doing anything else, so no code can be
written until the plan is approved.

Once in plan mode:

1. Read `CLAUDE.md` to ground the plan in this project's actual conventions (PHP 8.4, no frameworks, PDO
   prepared statements, `htmlspecialchars` on all output, CSRF tokens on data-changing forms, PSR-12,
   `declare(strict_types=1);`, branch naming, commit message format, ask before schema changes, etc.).
2. Propose a short, focused plan for implementing the following as a **single incremental step** — the
   same granularity as the step-by-step CRUD build already done in this project (one file, or one clear
   slice of behavior; not a multi-phase rewrite):

   $ARGUMENTS

   Name the specific file(s) to touch and the concrete change to make in each, not a vague description.
3. Add a "Manual test steps" section: a numbered list of concrete actions to perform in the browser at
   `http://localhost/` afterward to verify the change works (e.g. specific form inputs to try, specific
   buttons/links to click, what to expect to see).
4. Do not write or edit any application code during this — only the plan file.
5. Finish by calling `ExitPlanMode` to request approval. Do not proceed with implementation until approved.
