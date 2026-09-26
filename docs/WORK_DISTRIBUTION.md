# توزيع العمل بين أعضاء الفريق (Work Distribution)
## منصة كورة بلص — SHIDRA TEAM (Team 01)

| الحقل | القيمة |
|---|---|
| اسم المشروع | KooraPlus Pitch Booking |
| الفريق | SHIDRA TEAM (Team 01) |
| الإصدار | 1.0 |
| آخر تحديث | 2026-09-26 |

---

## 🟢 مرحلة التخطيط والتوثيق (Planning Phase)

| # | الخطوة | الشميس (Coordinator) | محمد (Maintainer) | العقاب (Reviewer) | الملف الناتج |
|:---:|---|:---:|:---:|:---:|---|
| 1 | فكرة المنصة | ✅ | — | — | `PROJECT_BRIEF.md` |
| 2 | المستخدمون + المشكلة + الهدف | ✅ | — | — | `PROJECT_BRIEF.md` |
| 3 | المتطلبات الوظيفية وغير الوظيفية | ✅ | — | — | `SRS.md` |
| 4 | Scope (In / Out of Scope) | ✅ | — | — | `SRS.md` |
| 5 | User Flow / Business Flow | ✅ | — | — | `USER_FLOW.md` |
| 6 | Modules / Features | ✅ | — | — | `SRS.md` |
| 7 | التقنية والبيئة (Tech Stack) | — | ✅ | — | `ARCHITECTURE.md` |
| 8 | Architecture (MVC, Layers, Components) | — | ✅ | — | `ARCHITECTURE.md` |
| 9 | Database Design (ERD + Tables) | — | ✅ | — | `DATABASE_DESIGN.md` |
| 10 | API Design (Endpoints + Responses) | — | ✅ | — | `API_DESIGN.md` |
| 11 | الهوية + Design System (Colors, Typography) | ✅ | — | — | `DESIGN_SYSTEM.md` |
| 12 | UI Structure (Pages Map + Navigation) | ✅ | — | — | `UI_STRUCTURE.md` |
| 13 | Prototype / UI Wireframes | — | ✅ | — | `UI_STRUCTURE.md` |
| 14 | Testing Strategy | — | — | ✅ | `TESTING_STRATEGY.md` |
| 15 | Definition of Done | ✅ | — | — | `DEFINITION_OF_DONE.md` |
| 16 | AI Guidelines & Log | — | — | ✅ | `AI_Log.md` |
| 17 | GitHub Setup (Repo + Branch Protection) | — | ✅ | — | GitHub Settings |
| 18 | Issues (5 Issues + User Stories + Kanban) | — | ✅ | — | GitHub Issues |
| 19 | Team Assignment | ✅ | — | — | `WORK_DISTRIBUTION.md` |

---

## 🔵 مرحلة التطوير (Development Phase)

### توزيع الـ Features

| المتطلب | الوصف | المطوّر | الفرع |
|:---:|---|---|---|
| **FR-01** | تسجيل الدخول وإنشاء الحسابات | **الشميس** | `feature/auth` |
| **FR-02** | تصفح الملاعب وعرض التفاصيل | **الشميس** | `feature/pitches-listing` |
| **FR-03** | عرض جدول الساعات المتاحة | **محمد** | `feature/time-slots` |
| **FR-04** | حجز فترة زمنية وتأكيدها | **محمد** | `feature/booking` |
| **FR-05** | لوحة تحكم صاحب الملعب | **العقاب** | `feature/owner-dashboard` |
| **FR-06** | إلغاء الحجز قبل ساعتين | **العقاب** | `feature/cancellation` |

---

### خطوات التطوير لكل Feature (20-32)

| # | الخطوة | الشميس | محمد | العقاب |
|:---:|---|:---:|:---:|:---:|
| 20 | Branch | FR-01, FR-02 | FR-03, FR-04 | FR-05, FR-06 |
| 21 | Coding | FR-01, FR-02 | FR-03, FR-04 | FR-05, FR-06 |
| 22 | Local Testing | FR-01, FR-02 | FR-03, FR-04 | FR-05, FR-06 |
| 23 | Commit | FR-01, FR-02 | FR-03, FR-04 | FR-05, FR-06 |
| 24 | Push | FR-01, FR-02 | FR-03, FR-04 | FR-05, FR-06 |
| 25 | Pull Request | FR-01, FR-02 | FR-03, FR-04 | FR-05, FR-06 |
| 26 | Code Review | العقاب يراجع | الشميس يراجع | محمد يراجع |
| 27 | Fix Review Comments | FR-01, FR-02 | FR-03, FR-04 | FR-05, FR-06 |
| 28 | Merge | — | ✅ محمد (Maintainer) | — |
| 29 | Integration Testing | — | — | ✅ العقاب |
| 30 | System / Acceptance Testing | — | — | ✅ العقاب |
| 31 | Documentation Update | ✅ الشميس | — | — |
| 32 | Done | الفريق كاملاً | الفريق كاملاً | الفريق كاملاً |

---

## 📋 توزيع مراجعة الـ Pull Requests

| كاتب الـ PR | المراجع المعتمد |
|---|---|
| **الشميس** (`OsamaShomis`) | محمد الإدريسي (`Mo-ra778`) |
| **محمد** (`Mo-ra778`) | أسامة الشميس (`OsamaShomis`) |
| **العقاب** (`osalokab`) | محمد الإدريسي (`Mo-ra778`) |

> **القاعدة الذهبية:** لا يراجع أحد عمله بنفسه، ولا يدمج أحد PR-ه بنفسه ✋

---

## ⚠️ قواعد منع التعارض بين أعضاء الفريق

1. **فصل الفروع:** كل عضو يعمل على فرع مستقل خاص بمهمته فقط — لا أحد يعدّل في فرع غيره.
2. **تحديث مستمر:** قبل إنشاء أي Branch جديد، يسحب العضو آخر تحديث من `main` (`git pull origin main`).
3. **ممنوع التعديل المباشر على `main`:** جميع التغييرات تمر عبر Pull Request.
4. **الدمج من صلاحية محمد فقط:** بصفته Repository Maintainer.
5. **لا تعديل في ملفات الآخرين** إلا بعد مراجعة وموافقة صاحب الملف.
