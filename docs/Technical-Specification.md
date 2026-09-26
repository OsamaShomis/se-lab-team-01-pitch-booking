# المواصفات الفنية للتشغيل — كورة بلص (`KooraPlus`)
## Technical Specification & Runtime Environment

| الحقل | القيمة |
|---|---|
| **اسم المشروع** | منصة كورة بلص لحجز الملاعب الرياضية (KooraPlus Pitch Booking Platform) |
| **الفريق** | SHIDRA TEAM (Team 01) |
| **المسؤول المعتمد** | محمد الإدريسي (`Mo-ra778` — Repository Maintainer & Developer) |
| **الحالة** | معتمد رسمياً ومكتمل ✅ (Approved) |
| **الإصدار** | 1.1 |
| **تاريخ الاعتماد** | 2026-09-26 |
| **الخطوة المرتبطة** | الخطوة 7 في [`docs/WORK_DISTRIBUTION.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/WORK_DISTRIBUTION.md) والقسم 1 في [`docs/Architecture.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Architecture.md) |

---

## 1. نظرة عامة ومعمارية التشغيل (Overview)

تحدد هذه الوثيقة **المواصفات التقنية والبيئية الرسمية** اللازمة لتشغيل منصة **كورة بلص** محلياً ولدى أستاذ المادة والزملاء في الفريق. تم إعداد هذه المواصفات لتتطابق 100% مع القرارات المعمارية المعتمدة في وثيقة المعمارية [`docs/Architecture.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Architecture.md) وقواعد البيانات [`docs/Database.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Database.md).

---

## 2. مصفوفة حزمة التقنيات المعتمدة (Technology Stack Matrix)

### أ. مواصفات الخادم والخلفية (Backend Specifications)

| المكون | التقنية المعتمدة | الإصدار المؤكد | الدور الفني في النظام |
|---|---|:---:|---|
| **لغة البرمجة** | **PHP** | `8.5.9` | لغة الخادم الأساسية ومحرك معالجة العمليات |
| **إطار العمل** | **Laravel** | `11.x` | إطار العمل المعتمد (MVC Architecture) |
| **مدير الحزم** | **Composer** | `2.7.8` | إدارة وتثبيت مكتبات واعتماديات الـ PHP |
| **نظام المصادقة** | **Laravel Sanctum** | مدمج (v11) | إدارة رموز التحقق (Bearer Tokens) وفق `NFR-02` |
| **محرك قاعدة البيانات** | **SQLite** | `3.x` | قاعدة بيانات محلية مدمجة وخفيفة (`database.sqlite`) لضمان سهولة التشغيل |
| **طبقة الـ ORM** | **Eloquent ORM** | مدمج | التعامل مع الكيانات والعلاقات عبر كود PHP نقي |

---

### ب. مواصفات الواجهة والعميل (Frontend & Client Specifications)

| المكون | التقنية المعتمدة | الدور الفني في النظام |
|---|---|---|
| **محرك القوالب** | **Laravel Blade** | بناء وتصيير صفحات الواجهة التفاعلية من جهة الخادم (SSR) |
| **الهيكل والتنسيق** | **HTML5 & CSS3** | هيكل صفحات الويب وتطبيق نظام التصميم المتجاوب |
| **البرمجة التفاعلية** | **Vanilla JavaScript (ES6+)** | التفاعل اللحظي مع اختيار الساعات وطلبات الـ AJAX / Fetch API |
| **مدير حزم الواجهة** | **Node.js (`v24.18.1`) & npm (`11.16.0`)** | إدارة وتجميع ملفات الأصول البرمجية للواجهة |
| **الخطوط المعتمدة** | **Cairo & Tajawal (Google Fonts)** | خطوط الواجهة العربية المعتمدة في [`docs/Design-System.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Design-System.md) |
| **الألوان المعتمدة** | **Pitch Natural Olive Palette** | التوكنز العشبية (`#354C2B`, `#4E653D`, `#859864`, `#A4B17B`, `#C3CA92`) |

---

## 3. عقد متغيرات بيئة التشغيل (`.env` Configuration Contract)

يعمل المشروع وفق الإعدادات البيئية القياسية التالية لبيئة التطوير المحلية دون الحاجة لتثبيت أي خادم خارجي:

```ini
APP_NAME=KooraPlus
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_TIMEZONE=Asia/Aden
APP_URL=http://localhost:8000
APP_LOCALE=ar
APP_FALLBACK_LOCALE=en

# إعداد قاعدة البيانات المدمجة (SQLite)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# إعدادات الجلسات والمصادقة
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

---

## 4. متطلبات الأداء والأمان (Non-Functional Requirements Alignment)

تلتزم المواصفات الفنية بالمتطلبات المعتمدة في [`docs/SRS.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/SRS.md):

1. **الأداء واستجابة الخادم (`NFR-01`):**
   - زمن استجابة استعلامات جدول الساعات يجب ألا يتجاوز **1.5 ثانية**.
   - استخدام الفهارس (Indexes) على حقول `pitch_id`, `date`, و `status` لتسريع جلب الساعات.
2. **الأمان والتشفير (`NFR-02`):**
   - تشفير كلمات مرور المستخدمين عبر خوارزمية **Bcrypt** بدورة تشفير آمنة.
   - حماية كافة النماذج باستخدام رموز التحقق **CSRF Tokens**.
   - حماية استعلامات قاعدة البيانات من حقن SQL عبر Eloquent Parameter Binding.
3. **التجاوب وسهولة الاستخدام (`NFR-03`):**
   - تصميم متجاوب (Responsive) يدعم الشاشات من 375px (موبايل) حتى الشاشات المكتبية العريضة.
4. **سلامة وتكامل البيانات (`NFR-04`):**
   - استخدام **Database Transactions** لقفل حجز الساعة ومنع الحجز المزدوج في حالات الطلب المتزامن (`BR-02`).

---

## 5. خطوات الإعداد والتشغيل المحلي (Quick Setup Guide)

لأي عضو في الفريق أو المشرف الأكاديمي، يتم تشغيل النظام في 4 خطوات بسيطة:

```bash
# 1. استنساخ المستودع
git clone https://github.com/OsamaShomis/se-lab-team-01-pitch-booking.git

# 2. تثبيت اعتماديات الـ PHP
composer install

# 3. إعداد ملف البيئة ومفتاح التطبيق
cp .env.example .env
php artisan key:generate

# 4. تشغيل الهجرة وتغذية البيانات وبدء السيرفر المحلي
php artisan migrate --seed
php artisan serve
```

---

## 6. المراجع المعمارية المتصلة

- **المعمارية الشاملة:** تفاصيل الطبقات وتدفق الطلبات في [`docs/Architecture.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Architecture.md).
- **قواعد البيانات:** الجداول ومخطط العلاقات في [`docs/Database.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Database.md).
- **واجهات البرمجة:** عقود الـ Endpoints في [`docs/API.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/API.md).
- **نظام التصميم:** الألوان والواجهات في [`docs/Design-System.md`](file:///e:/level_4/Software%20Engineering/Practical/Lab%201/docs/Design-System.md).
