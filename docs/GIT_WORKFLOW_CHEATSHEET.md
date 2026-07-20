# Git Workflow Cheat Sheet

## التهيئة

```bash
git --version
git config --global user.name "Student Name"
git config --global user.email "student@example.com"
```

## النسخ والتحديث

```bash
git clone https://github.com/USERNAME/REPOSITORY.git
cd REPOSITORY
git switch main
git pull origin main
```

## إنشاء فرع

```bash
git switch -c docs/issue-2-update-srs
```

## فحص التغييرات

```bash
git status
git diff
```

## الحفظ والرفع

```bash
git add docs/SRS.md
git commit -m "Add initial mini SRS"
git push -u origin docs/issue-2-update-srs
```

## بعد الدمج

```bash
git switch main
git pull origin main
git branch -d docs/issue-2-update-srs
```

## المسار المختصر

`Issue → Branch → Change → Commit → Push → Pull Request → Review → Merge → Close`
