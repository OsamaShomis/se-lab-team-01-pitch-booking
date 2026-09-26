# System Architecture — معمارية النظام

## منصة كورة بلص (KooraPlus Pitch Booking Platform)

| الحقل                              | القيمة                                                                    |
| --------------------------------------- | ------------------------------------------------------------------------------- |
| **اسم المشروع**         | KooraPlus Pitch Booking Platform                                                |
| **الفريق**                  | SHIDRA TEAM (Team 01)                                                           |
| **المسؤول**                | محمد الإدريسي (`Mo-ra778` — Repository Maintainer & Developer)   |
| **الحالة**                  | معتمد ✅                                                                   |
| **الإصدار**                | 1.1                                                                             |
| **آخر تحديث**             | 2026-09-26                                                                      |
| **الخطوة المرتبطة** | الخطوات 7 + 8 في[`docs/WORK_DISTRIBUTION.md`](./WORK_DISTRIBUTION.md) |

> **⚠️ قرار معماري (v1.1):** تم تغيير قاعدة البيانات من MySQL إلى **SQLite** بقرار من Repository Maintainer (`Mo-ra778`) لتبسيط بيئة التطوير. يُطبَّق على بيئتَي التطوير والإنتاج نظراً لكون المشروع أكاديمياً. يتطلب موافقة Team Coordinator (`OsamaShomis`) عبر مراجعة الـ Pull Request.

---

## 1. 🛠️ التقنية والبيئة (Tech Stack) — الخطوة 7

### أ. Backend

| التقنية            | الإصدار المؤكد | الدور                                                            |
| ------------------------- | --------------------------- | --------------------------------------------------------------------- |
| **PHP**             | `8.5.9` ✅                | لغة البرمجة الأساسية                                |
| **Laravel**         | `11.x` (سيُثبَّت) | إطار العمل الخلفي (MVC Framework)                      |
| **Laravel Sanctum** | مدمج مع Laravel 11    | مصادقة المستخدمين عبر API Tokens                   |
| **SQLite**          | `3.x` (مدمج مع PHP) | قاعدة البيانات — ملف واحد خفيف               |
| **Eloquent ORM**    | مدمج                    | التعامل مع قاعدة البيانات عبر نماذج PHP |

### ب. Frontend

| التقنية                 | الإصدار المؤكد | الدور                                                        |
| ------------------------------ | --------------------------- | ----------------------------------------------------------------- |
| **Laravel Blade**        | مدمج                    | محرك القوالب (Template Engine) لصفحات الويب |
| **HTML5**                | —                          | هيكل صفحات الويب                                    |
| **CSS3**                 | —                          | تنسيق وتصميم الواجهات                          |
| **JavaScript (Vanilla)** | ES6+                        | التفاعلية وتحديثات الواجهة                |
| **Cairo / Tajawal**      | Google Fonts                | الخطوط العربية المعتمدة                      |

### ج. بيئة التطوير (Development Environment)

| الأداة              | الإصدار المؤكد | الدور                                            |
| ------------------------- | --------------------------- | ----------------------------------------------------- |
| **Composer**        | `2.7.8` ✅                | إدارة حزم PHP                                 |
| **Node.js**         | `v24.18.1` ✅             | بيئة تشغيل JavaScript                        |
| **npm**             | `11.16.0` ✅              | إدارة حزم JavaScript / CSS                    |
| **XAMPP**           | موجود ✅               | بيئة التطوير المحلية (Apache + PHP) |
| **Laravel Artisan** | مدمج                    | أوامر CLI لإدارة المشروع            |
| **Git + GitHub**    | —                          | إدارة الإصدارات والتعاون        |
| **Postman**         | —                          | اختبار وتوثيق الـ API                  |

### د. لماذا SQLite؟

| المعيار                              | SQLite                                                     | MariaDB/MySQL                                          |
| ------------------------------------------- | ---------------------------------------------------------- | ------------------------------------------------------ |
| **الإعداد**                    | ✅ ملف واحد`.sqlite`، بدون تثبيت        | ❌ يحتاج تثبيت وإعداد سيرفر       |
| **التطوير المحلي**       | ✅ كل عضو يشتغل بدون مشاكل              | ⚠️ اختلاف إعدادات بين الأجهزة |
| **Laravel**                           | ✅ مدعوم رسمياً ومُعدّ افتراضياً | ✅ مدعوم                                          |
| **المشروع الأكاديمي** | ✅ مناسب تماماً                                 | ✅ أقوى لكن أعقد                            |
| **Race Condition**                    | ⚠️ محدود (مقبول أكاديمياً)            | ✅`SELECT FOR UPDATE` كامل                       |

---

## 2. 🏗️ معمارية النظام (System Architecture) — الخطوة 8

### أ. النمط المعماري (Architectural Pattern)

المشروع يتبع نمط **Layered MVC** المدمج في Laravel مع فصل واضح للمسؤوليات:

```
┌─────────────────────────────────────────────┐
│              CLIENT (Browser)               │
│         HTML + CSS + JavaScript             │
└──────────────────┬──────────────────────────┘
                   │  HTTP Request
                   ▼
┌─────────────────────────────────────────────┐
│           PRESENTATION LAYER                │
│       Laravel Blade Views (.blade.php)      │
│     (Pages: Login, Pitches, Booking...)     │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│            CONTROLLER LAYER                 │
│   AuthController │ PitchController          │
│   SlotController │ BookingController        │
│   OwnerDashboardController                  │
│  (Request Validation + Response Routing)    │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│             SERVICE LAYER                   │
│   BookingService │ SlotAvailabilityService  │
│  (Business Logic + Transaction Management)  │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│           DATA ACCESS LAYER                 │
│     Eloquent Models (ORM) + SQLite          │
│  User │ Pitch │ TimeSlot │ Booking          │
│  (ملف: database/database.sqlite)            │
└─────────────────────────────────────────────┘
```

---

### ب. مخطط المكونات عالي المستوى (High-Level Component Diagram)

```
┌───────────────────────────────────────────────────────┐
│                   KooraPlus System                    │
│                                                       │
│  ┌─────────────────┐      ┌─────────────────────┐    │
│  │  Player Module  │      │  Owner Module        │    │
│  │─────────────────│      │─────────────────────│    │
│  │ • Register/Login│      │ • Register/Login     │    │
│  │ • Browse Pitches│      │ • Owner Dashboard    │    │
│  │ • View Slots    │      │ • Update Status      │    │
│  │ • Book Slot     │      │ • View Daily Schedule│    │
│  │ • Cancel Booking│      │                      │    │
│  └────────┬────────┘      └──────────┬──────────┘    │
│           │                          │                │
│           └──────────┬───────────────┘                │
│                      ▼                                │
│         ┌────────────────────────┐                    │
│         │    Core Services       │                    │
│         │────────────────────────│                    │
│         │ • AuthService          │                    │
│         │ • BookingService       │                    │
│         │ • SlotService          │                    │
│         │ • CancellationService  │                    │
│         └────────────┬───────────┘                    │
│                      ▼                                │
│         ┌────────────────────────┐                    │
│         │   SQLite Database      │                    │
│         │ database/database.sqlite│                   │
│         │────────────────────────│                    │
│         │ users                  │                    │
│         │ pitches                │                    │
│         │ time_slots             │                    │
│         │ bookings               │                    │
│         └────────────────────────┘                    │
└───────────────────────────────────────────────────────┘
```

---

### ج. تدفق عملية الحجز (Booking Flow)

```
اللاعب يختار ملعب
        │
        ▼
يختار تاريخ من Date Picker
        │
        ▼
SlotController يجلب الساعات من SQLite
        │
        ▼
Blade View يعرض الجدول:
   🟢 متاح  │  🔴 محجوز  │  ⚫ ماضي
        │
        ▼
اللاعب ينقر على ساعة متاحة
        │
        ▼
BookingService يفتح DB Transaction
        │
        ├──► يتحقق أن الساعة لا تزال متاحة
        │
        ├──[ متاحة ]──► ينشئ الحجز + يحدث الحالة إلى "محجوز"
        │                       │
        │               يرسل رسالة نجاح ✅
        │
        └──[ محجوزة ]──► يرفض + رسالة: "تم حجز هذه الفترة للتو"
```

---

## 3. 🔒 إدارة التزامن (Concurrency & Transaction Management)

### آلية الحماية مع SQLite

```php
// BookingService.php
DB::transaction(function () use ($slotId, $userId) {

    // جلب الساعة والتحقق من حالتها داخل Transaction
    $slot = TimeSlot::where('id', $slotId)->first();

    if ($slot->status !== 'available') {
        throw new \Exception(
            'عذراً، تم حجز هذه الفترة للتو من قبل مستخدم آخر'
        );
    }

    // إنشاء الحجز وتحديث الحالة داخل نفس الـ Transaction
    Booking::create([
        'user_id'      => $userId,
        'time_slot_id' => $slotId,
        'status'       => 'confirmed',
    ]);

    $slot->update(['status' => 'booked']);
});
```

> **ملاحظة:** SQLite يدعم Transactions لكن لا يدعم `SELECT ... FOR UPDATE`.
> في السياق الأكاديمي هذا مقبول. الـ Transaction تضمن تكامل البيانات في معظم الحالات.

### القواعد المطبقة

| القاعدة  | التطبيق                                                                 |
| --------------- | ------------------------------------------------------------------------------ |
| **BR-01** | منع حجز الساعات الماضية عبر Validation في Controller  |
| **BR-02** | تحديث حالة الساعة فوراً داخل نفس الـ Transaction |
| **BR-03** | فحص الفارق الزمني (ساعتين) في CancellationService       |

---

## 4. 🗂️ هيكل مجلدات المشروع (Laravel Folder Structure)

```
kooraplus/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php           ← FR-01
│   │   │   ├── PitchController.php          ← FR-02
│   │   │   ├── SlotController.php           ← FR-03
│   │   │   ├── BookingController.php        ← FR-04
│   │   │   └── OwnerDashboardController.php ← FR-05
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php           ← صلاحيات المستخدمين
│   │   └── Requests/
│   │       └── BookingRequest.php           ← Validation Rules
│   ├── Models/
│   │   ├── User.php
│   │   ├── Pitch.php
│   │   ├── TimeSlot.php
│   │   └── Booking.php
│   └── Services/
│       ├── BookingService.php               ← منطق الحجز + Transaction
│       ├── SlotAvailabilityService.php      ← جلب وتصفية الساعات
│       └── CancellationService.php          ← قواعد الإلغاء (BR-03)
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                ← القالب الرئيسي
│       ├── auth/
│       │   ├── login.blade.php              ← FR-01
│       │   └── register.blade.php           ← FR-01
│       ├── pitches/
│       │   ├── index.blade.php              ← FR-02
│       │   └── show.blade.php               ← FR-02 + FR-03
│       ├── bookings/
│       │   └── confirm.blade.php            ← FR-04
│       └── owner/
│           └── dashboard.blade.php          ← FR-05
├── routes/
│   ├── web.php                              ← مسارات صفحات Blade
│   └── api.php                             ← مسارات الـ API
├── database/
│   ├── migrations/                          ← جداول قاعدة البيانات
│   └── database.sqlite                      ← ملف SQLite (يُنشأ تلقائياً)
└── docs/                                    ← وثائق المشروع
```

---

## 5. 🔐 نظام المصادقة والصلاحيات (Auth & Roles)

```
المستخدمون (users)
     │
     ├── role = 'player'   ← يحجز، يتصفح، يلغي
     │
     └── role = 'owner'    ← لوحة التحكم، إدارة الحجوزات
```

- **Laravel Sanctum** يصدر Token عند تسجيل الدخول.
- **RoleMiddleware** يحمي مسارات لوحة تحكم المالك.
- **NFR-02:** كلمات المرور مشفرة بـ Bcrypt تلقائياً عبر Laravel.

---

## 6. ✅ قائمة التحقق (Architecture Checklist)

- [X] تم تحديد Tech Stack الكامل بإصدارات مؤكدة من الجهاز
- [X] تم اتخاذ قرار قاعدة البيانات: **SQLite** (معتمد من `Mo-ra778`)
- [X] تم رسم مخطط الطبقات (Layered MVC)
- [X] تم توثيق آلية الـ Transactions مع SQLite
- [X] تم توثيق هيكل المجلدات
- [X] تم توثيق نظام الصلاحيات
- [ ] بانتظار موافقة Team Coordinator (`OsamaShomis`) عبر PR

---

*تم إعداد هذا الملف بواسطة: محمد الإدريسي (`Mo-ra778`) — Repository Maintainer & Developer*
*الخطوات المغطاة: 7 (Tech Stack) + 8 (Architecture) من [`docs/WORK_DISTRIBUTION.md`](./WORK_DISTRIBUTION.md)*
