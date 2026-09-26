# System Architecture — معمارية النظام
## منصة كورة بلص (KooraPlus Pitch Booking Platform)

| الحقل | القيمة |
|---|---|
| **اسم المشروع** | KooraPlus Pitch Booking Platform |
| **الفريق** | SHIDRA TEAM (Team 01) |
| **المسؤول** | محمد الإدريسي (`Mo-ra778` — Repository Maintainer & Developer) |
| **الحالة** | معتمد ✅ |
| **الإصدار** | 1.0 |
| **آخر تحديث** | 2026-09-26 |
| **الخطوة المرتبطة** | الخطوات 7 + 8 في [`docs/WORK_DISTRIBUTION.md`](./WORK_DISTRIBUTION.md) |

---

## 1. 🛠️ التقنية والبيئة (Tech Stack) — الخطوة 7

### أ. Backend

| التقنية | الإصدار | الدور |
|---|---|---|
| **PHP** | 8.2+ | لغة البرمجة الأساسية |
| **Laravel** | 11.x | إطار العمل الخلفي (MVC Framework) |
| **Laravel Sanctum** | مدمج مع Laravel 11 | مصادقة المستخدمين عبر API Tokens |
| **MySQL** | 8.0+ | قاعدة البيانات العلائقية مع دعم ACID Transactions |
| **Eloquent ORM** | مدمج | التعامل مع قاعدة البيانات عبر نماذج PHP |

### ب. Frontend

| التقنية | الإصدار | الدور |
|---|---|---|
| **Laravel Blade** | مدمج | محرك القوالب (Template Engine) لصفحات الويب |
| **HTML5** | — | هيكل صفحات الويب |
| **CSS3** | — | تنسيق وتصميم الواجهات |
| **JavaScript (Vanilla)** | ES6+ | التفاعلية وتحديثات الواجهة |
| **Cairo / Tajawal** | Google Fonts | الخطوط العربية المعتمدة |

### ج. بيئة التطوير (Development Environment)

| الأداة | الدور |
|---|---|
| **Composer** | إدارة حزم PHP |
| **npm** | إدارة حزم JavaScript / CSS |
| **Laravel Artisan** | أوامر CLI لإدارة المشروع |
| **Git + GitHub** | إدارة الإصدارات والتعاون |
| **XAMPP / Laragon** | بيئة التطوير المحلية (Local Server) |
| **Postman** | اختبار وتوثيق الـ API |

### د. الاستضافة والنشر (Deployment) — مرحلة مستقبلية

| البيئة | الأداة |
|---|---|
| **Staging / Production** | `[TO BE DEFINED - سيُحدد لاحقاً]` |

---

## 2. 🏗️ معمارية النظام (System Architecture) — الخطوة 8

### أ. النمط المعماري (Architectural Pattern)

المشروع يتبع نمط **Layered MVC** (Model - View - Controller) المدمج في Laravel، مع فصل واضح للمسؤوليات بين الطبقات:

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
│  ← يحمي من Race Conditions عبر DB Locks →  │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│           DATA ACCESS LAYER                 │
│     Eloquent Models (ORM) + MySQL           │
│  User │ Pitch │ TimeSlot │ Booking          │
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
│         │   MySQL Database       │                    │
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
SlotController يجلب الساعات من DB
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
        ├──► يقفل الصف (SELECT ... FOR UPDATE)
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

## 3. 🔒 إدارة التزامن ومنع التعارض (Concurrency & Transaction Management)

### المشكلة: Race Condition
إذا ضغط لاعبان على نفس الساعة في نفس اللحظة، قد يحجزها الاثنان في نفس الوقت.

### الحل: Database Transactions + Pessimistic Locking

```php
// BookingService.php
DB::transaction(function () use ($slotId, $userId) {
    // قفل الصف لمنع أي قراءة أو تعديل من جلسة أخرى
    $slot = TimeSlot::where('id', $slotId)
                    ->lockForUpdate()
                    ->first();

    // التحقق من الحالة بعد القفل
    if ($slot->status !== 'available') {
        throw new SlotAlreadyBookedException(
            'عذراً، تم حجز هذه الفترة للتو من قبل مستخدم آخر'
        );
    }

    // إنشاء الحجز وتحديث الحالة داخل نفس الـ Transaction
    Booking::create([...]);
    $slot->update(['status' => 'booked']);
});
```

### القواعد المطبقة
| القاعدة | التطبيق |
|---|---|
| **BR-01** | منع حجز الساعات الماضية عبر Validation في Controller |
| **BR-02** | تحديث حالة الساعة فوراً داخل نفس الـ Transaction |
| **BR-03** | فحص الفارق الزمني (ساعتين) في CancellationService |
| **NFR-04** | استخدام `lockForUpdate()` لضمان تكامل البيانات |

---

## 4. 🗂️ هيكل مجلدات المشروع (Laravel Folder Structure)

```
kooraplus/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          ← FR-01
│   │   │   ├── PitchController.php         ← FR-02
│   │   │   ├── SlotController.php          ← FR-03
│   │   │   ├── BookingController.php       ← FR-04
│   │   │   └── OwnerDashboardController.php← FR-05
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php          ← صلاحيات المستخدمين
│   │   └── Requests/
│   │       └── BookingRequest.php          ← Validation Rules
│   ├── Models/
│   │   ├── User.php
│   │   ├── Pitch.php
│   │   ├── TimeSlot.php
│   │   └── Booking.php
│   └── Services/
│       ├── BookingService.php              ← منطق الحجز + Transaction
│       ├── SlotAvailabilityService.php     ← جلب وتصفية الساعات
│       └── CancellationService.php         ← قواعد الإلغاء
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               ← القالب الرئيسي
│       ├── auth/
│       │   ├── login.blade.php             ← FR-01
│       │   └── register.blade.php          ← FR-01
│       ├── pitches/
│       │   ├── index.blade.php             ← FR-02
│       │   └── show.blade.php              ← FR-02 + FR-03
│       ├── bookings/
│       │   └── confirm.blade.php           ← FR-04
│       └── owner/
│           └── dashboard.blade.php         ← FR-05
├── routes/
│   ├── web.php                             ← مسارات صفحات Blade
│   └── api.php                             ← مسارات الـ API
├── database/
│   └── migrations/                         ← جداول قاعدة البيانات
└── docs/                                   ← وثائق المشروع
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
- **RoleMiddleware** يحمي مسارات لوحة تحكم المالك من الدخول غير المصرح.
- **NFR-02**: كلمات المرور مشفرة بـ Bcrypt تلقائياً عبر Laravel.

---

## 6. ✅ قائمة التحقق (Architecture Checklist)

- [x] تم تحديد Tech Stack الكامل (PHP 8.2, Laravel 11, MySQL 8, Sanctum)
- [x] تم رسم مخطط الطبقات (Layered MVC)
- [x] تم توثيق آلية منع Race Condition
- [x] تم توثيق هيكل المجلدات
- [x] تم توثيق نظام الصلاحيات
- [ ] تم مراجعة الملف من Team Coordinator (الشميس)

---

*تم إعداد هذا الملف بواسطة: محمد الإدريسي (`Mo-ra778`) — Repository Maintainer & Developer*  
*الخطوات المغطاة: 7 (Tech Stack) + 8 (Architecture) من [`docs/WORK_DISTRIBUTION.md`](./WORK_DISTRIBUTION.md)*
