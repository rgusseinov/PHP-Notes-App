---
description: Review uncommitted changes against CLAUDE.md's code rules (read-only, no commits)
---

Review the repository's current uncommitted changes for compliance with this project's `CLAUDE.md` code
rules. This is a read-only report — do not stage, commit, or otherwise modify anything.

1. Run `git status` to see all modified and untracked files, and `git diff` to see the actual changes to
   tracked files. For untracked files relevant to the change, read them directly since `git diff` won't
   show their contents.
2. For every changed or added PHP file, check it against these rules from `CLAUDE.md`:
   - Starts with `declare(strict_types=1);`
   - Any SQL uses PDO prepared statements — no variables interpolated directly into SQL strings
   - All dynamic output is escaped with `htmlspecialchars`
   - Every form that changes data (create/edit/delete) includes and verifies a CSRF token
3. Report findings as a concise list, referencing `file:line` for each issue found. Flag anything risky or
   inconsistent with these conventions — do not limit yourself to only the four rules above if you notice
   another clear problem, but keep the primary focus on them. If everything checked out, say so explicitly
   rather than staying silent.
4. Do not run `git add`, `git commit`, or any other command that stages, commits, or changes git history or
   the working tree. This command only reports; it never fixes or commits anything.
