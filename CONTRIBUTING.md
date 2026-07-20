# Contributing Guide

## دورة العمل

1. اختر Issue من عمود `Ready`.
2. عيّن نفسك Assignee.
3. انقلها إلى `In Progress`.
4. حدّث الفرع الرئيسي:
   ```bash
   git switch main
   git pull origin main
   ```
5. أنشئ فرعاً:
   ```bash
   git switch -c feature/issue-3-short-description
   ```
6. نفّذ تغييراً صغيراً ومركزاً.
7. افحص:
   ```bash
   git status
   git diff
   ```
8. أنشئ Commit:
   ```bash
   git add path/to/file
   git commit -m "Add task creation acceptance criteria"
   ```
9. ارفع الفرع:
   ```bash
   git push -u origin feature/issue-3-short-description
   ```
10. افتح Pull Request واربطها بالـIssue.
11. انقل المهمة إلى `In Review`.
12. يراجعها عضو آخر.
13. بعد الموافقة تُدمج في `main` وتُنقل إلى `Done`.

## تسمية الفروع

`type/issue-number-short-description`

أمثلة:

- `feature/issue-3-create-task`
- `fix/issue-7-task-validation`
- `docs/issue-2-update-srs`
- `test/issue-10-task-tests`

## رسائل Commit

جيدة:

- `Add initial mini SRS`
- `Fix empty task title validation`
- `Document login edge cases`

سيئة:

- `update`
- `changes`
- `final`

## قواعد المراجعة

- لا تراجع Pull Request الخاصة بك.
- اكتب ملاحظة محددة وقابلة للتنفيذ.
- لا توافق قبل قراءة التغييرات.
- لا يتم الدمج مع وجود ملاحظات غير معالجة.
