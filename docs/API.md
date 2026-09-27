# API Specification — مواصفات واجهات برمجة التطبيقات

## منصة كورة بلص (KooraPlus Pitch Booking Platform)

| الحقل | القيمة |
|---|---|
| **اسم المشروع** | KooraPlus Pitch Booking Platform |
| **الفريق** | SHIDRA TEAM (Team 01) |
| **المسؤول** | محمد الإدريسي (`Mo-ra778` — Repository Maintainer & Developer) |
| **البروتوكول والمعمارية** | **RESTful API** (JSON over HTTP) |
| **المصادقة والأمان** | **Laravel Sanctum** (Bearer Token) — حسب `NFR-02` |
| **قاعدة البيانات الأساسية** | **SQLite 3** (`database/database.sqlite`) |
| **الحالة** | معتمد ومكتمل ✅ |
| **الإصدار** | 1.0 |
| **آخر تحديث** | 2026-09-26 |
| **الخطوة المرتبطة** | الخطوة رقم 10 في [`docs/WORK_DISTRIBUTION.md`](./WORK_DISTRIBUTION.md) |

---

## 1. 🎯 نظرة عامة والمعايير القياسية (API Architecture & Standards)

توثق هذه المواصفة واجهات برمجة التطبيقات (APIs) لمنصة **KooraPlus** لربط واجهات الـ Frontend المتفاعلة (Blade / JavaScript) بالخلفية البرمجية (Laravel Backend) وقاعدة بيانات SQLite.

### أ. الرابط الأساسي (Base URL)
- في بيئة التطوير المحلية (Local Development عبر سيرفر Laravel Artisan المدمج):
  ```text
  http://localhost:8000/api
  ```

### ب. ترويسات الطلب القياسية (Request Headers)
يجب إرسال الترويسات التالية مع جميع طلبات الـ API:
```http
Accept: application/json
Content-Type: application/json
```
وللمسارات المحمية التي تتطلب تسجيل دخول، يتم إرسال التوكن:
```http
Authorization: Bearer <personal_access_token>
```

---

### ج. هيكل الاستجابة الموحد (Unified JSON Envelope)
تعتمد جميع الـ APIs نسق استجابة موحداً لتسهيل معالجتها في واجهات المستخدم:

#### 1. استجابة النجاح (Success Response):
```json
{
  "success": true,
  "message": "تمت العملية بنجاح",
  "data": { ... }
}
```

#### 2. استجابة الفشل أو الخطأ (Error Response):
```json
{
  "success": false,
  "message": "رسالة توضيحية لسبب الخطأ",
  "errors": {
    "field_name": [
      "تفاصيل خطأ التحقق"
    ]
  }
}
```

---

### د. أكواد حالات الـ HTTP المعتمدة (HTTP Status Codes)

| الكود | الحالة | الاستخدام في النظام |
|:---:|---|---|
| **`200 OK`** | نجاح | نجاح جلب البيانات أو التعديل بنجاح. |
| **`201 Created`** | تم الإنشاء | نجاح تسجيل حساب جديد أو إنشاء حجز مؤكد. |
| **`400 Bad Request`** | طلب غير صالح | مخالفة لقواعد العمل (مثل: محاولة إلغاء الحجز قبل أقل من ساعتين `BR-03`). |
| **`401 Unauthorized`** | غير مصرح | التوكن مفقود أو غير صالح أو منتهي الصلاحية. |
| **`403 Forbidden`** | محظور | المستخدم لا يملك الصلاحية (مثل: لاعب يحاول تعديل لوحة تحكم صاحب الملعب). |
| **`404 Not Found`** | غير موجود | الملعب أو الفترة الزمنية أو الحجز المطلوب غير موجود. |
| **`409 Conflict`** | تضارب | تضارب في الحجز المتزامن (Race Condition - حجز فترة محجوزة للتو `BR-02`). |
| **`422 Unprocessable`** | فشل التحقق | الحقول غير مكتملة أو غير مطابقة لقواعد التحقق (Validation Errors). |
| **`500 Server Error`** | خطأ في الخادم | خطأ داخلي غير متوقع في الخادم. |

---

## 2. 📋 جدول ملخص جميع الـ Endpoints

| # | الطريقة | المسار (Endpoint) | المتطلب | المصادقة المطلوبة | الصلاحية (Role) | الوصف |
|:---:|:---:|---|:---:|:---:|:---:|---|
| **1** | `POST` | `/api/auth/register` | **FR-01** | عام (Public) | الكل | تسجيل حساب جديد (لاعب أو مالك) |
| **2** | `POST` | `/api/auth/login` | **FR-01** | عام (Public) | الكل | تسجيل الدخول وإصدار Token |
| **3** | `POST` | `/api/auth/logout` | **FR-01** | Sanctum Token | الكل | تسجيل الخروج وإلغاء الـ Token |
| **4** | `GET` | `/api/auth/me` | **FR-01** | Sanctum Token | الكل | جلب بيانات المستخدم المسجل حالياً |
| **5** | `GET` | `/api/pitches` | **FR-02** | عام (Public) | الكل | تصفح قائمة الملاعب مع الفلترة |
| **6** | `GET` | `/api/pitches/{id}` | **FR-02** | عام (Public) | الكل | استعراض تفاصيل ملعب محدد |
| **7** | `GET` | `/api/pitches/{id}/slots` | **FR-03** | عام (Public) | الكل | استعراض فترات الساعات لتاريخ معين |
| **8** | `POST` | `/api/bookings` | **FR-04** | Sanctum Token | `player` | حجز فترة زمنية وتأكيدها لحظياً |
| **9** | `GET` | `/api/bookings/my` | **FR-04** | Sanctum Token | `player` | استعراض سجل حجوزات اللاعب |
| **10** | `GET` | `/api/owner/pitches/{id}/schedule` | **FR-05** | Sanctum Token | `owner` | جدول مواعيد الحجوزات اليومي للملعب |
| **11** | `PATCH` | `/api/owner/bookings/{id}/status` | **FR-05** | Sanctum Token | `owner` | تحديث حالة الحجز (مؤكد/مكتمل/ملغي) |
| **12** | `POST` | `/api/owner/pitches` | **FR-05** | Sanctum Token | `owner` | تسجيل وإضافة ملعب جديد مع رفع الصورة والمواصفات |
| **13** | `POST` | `/api/bookings/{id}/cancel` | **FR-06** | Sanctum Token | `player` | إلغاء الحجز (مع مراعاة شرط الساعتين) |

---

## 3. 🔍 تفاصيل الـ Endpoints والعقود (Detailed API Contracts)

---

### أولاً: وحدة المصادقة والحسابات (Authentication Module — FR-01)

#### 1. تسجيل مستخدم جديد (`POST /api/auth/register`)
- **الوصف:** إنشاء حساب جديد في المنصة للاعب أو صاحب ملعب.
- **الترويسات:** `Content-Type: application/json`
- **جسم الطلب (Request Body):**
```json
{
  "name": "محمد الإدريسي",
  "email": "mohammed@example.com",
  "phone": "777123456",
  "password": "Password123",
  "password_confirmation": "Password123",
  "role": "player"
}
```
- **استجابة النجاح (`201 Created`):**
```json
{
  "success": true,
  "message": "تم إنشاء الحساب بنجاح",
  "data": {
    "user": {
      "id": 2,
      "name": "محمد الإدريسي",
      "email": "mohammed@example.com",
      "phone": "777123456",
      "role": "player",
      "created_at": "2026-09-26T20:30:00.000000Z"
    },
    "token": "1|qX8yZ...sanctum_token..."
  }
}
```
- **استجابة الخطأ (`422 Unprocessable Content`):**
```json
{
  "success": false,
  "message": "بيانات التسجيل المدخلة غير صحيحة",
  "errors": {
    "email": [
      "البريد الإلكتروني مستخدم بالفعل."
    ],
    "password": [
      "تأكيد كلمة المرور غير متطابق."
    ]
  }
}
```

---

#### 2. تسجيل الدخول (`POST /api/auth/login`)
- **الوصف:** مصادقة المستخدم وإصدار Token موثق للاستخدام في المسارات المحمية.
- **جسم الطلب (Request Body):**
```json
{
  "email": "mohammed@example.com",
  "password": "Password123"
}
```
- **استجابة النجاح (`200 OK`):**
```json
{
  "success": true,
  "message": "تم تسجيل الدخول بنجاح",
  "data": {
    "user": {
      "id": 2,
      "name": "محمد الإدريسي",
      "email": "mohammed@example.com",
      "phone": "777123456",
      "role": "player"
    },
    "token": "2|k9LmP...sanctum_token..."
  }
}
```
- **استجابة الخطأ (`401 Unauthorized`):**
```json
{
  "success": false,
  "message": "بيانات الاعتماد المدخلة غير صحيحة.",
  "errors": null
}
```

---

#### 3. تسجيل الخروج (`POST /api/auth/logout`)
- **الوصف:** إلغاء وحذف الـ Token الحالي للمستخدم.
- **المصادقة:** مطلوب `Bearer Token`.
- **استجابة النجاح (`200 OK`):**
```json
{
  "success": true,
  "message": "تم تسجيل الخروج بنجاح",
  "data": null
}
```

---

#### 4. جلب بيانات المستخدم المسجل (`GET /api/auth/me`)
- **المصادقة:** مطلوب `Bearer Token`.
- **استجابة النجاح (`200 OK`):**
```json
{
  "success": true,
  "message": "تم جلب بيانات المستخدم",
  "data": {
    "id": 2,
    "name": "محمد الإدريسي",
    "email": "mohammed@example.com",
    "phone": "777123456",
    "role": "player"
  }
}
```

---

### ثانياً: وحدة استعراض الملاعب (Pitches Module — FR-02)

#### 5. تصفح قائمة الملاعب (`GET /api/pitches`)
- **الوصف:** عرض قائمة الملاعب الرياضية النشطة مع دعم البحث والفلترة.
- **معاملات الاستعلام (Query Parameters):**
  - `location` (اختياري): فلترة حسب الحي أو المنطقة (مثل `location=حدة`).
  - `turf_type` (اختياري): نوع العشب (`artificial` أو `natural` أو `hybrid`).
  - `search` (اختياري): بحث بالاسم.
- **استجابة النجاح (`200 OK`):**
```json
{
  "success": true,
  "message": "تم جلب الملاعب بنجاح",
  "data": [
    {
      "id": 1,
      "name": "ملعب الأساطير الرياضي",
      "location": "صنعاء - حدة",
      "turf_type": "artificial",
      "hourly_rate": 6000.0,
      "contact_phone": "777111222",
      "image_url": "pitches/legend_pitch.jpg",
      "owner": {
        "id": 1,
        "name": "الكابتن علي"
      }
    }
  ]
}
```

---

#### 6. تفاصيل ملعب محدد (`GET /api/pitches/{id}`)
- **الوصف:** عرض البيانات الكاملة لملعب محدد بما فيها المرافق والوصف.
- **استجابة النجاح (`200 OK`):**
```json
{
  "success": true,
  "message": "تم جلب تفاصيل الملعب",
  "data": {
    "id": 1,
    "name": "ملعب الأساطير الرياضي",
    "location": "صنعاء - حدة - جولة الرويشان",
    "turf_type": "artificial",
    "hourly_rate": 6000.0,
    "contact_phone": "777111222",
    "image_url": "pitches/legend_pitch.jpg",
    "description": "عشب صناعي من الجيل الرابع، كشافات ليلية عالية الجودة، غرف تبديل، مياه شرب مجانية.",
    "is_active": true,
    "owner": {
      "id": 1,
      "name": "الكابتن علي",
      "phone": "777111222"
    }
  }
}
```
- **استجابة الخطأ (`404 Not Found`):**
```json
{
  "success": false,
  "message": "الملعب المطلوب غير موجود",
  "errors": null
}
```

---

### ثالثاً: وحدة الساعات والفترات المتاحة (Time Slots Module — FR-03)

#### 7. استعراض جدول الفترات اليومية (`GET /api/pitches/{id}/slots`)
- **الوصف:** جلب فترات اليوم المتاحة والمحجوزة لملعب معين بناءً على التاريخ المحدد.
- **الأداء (`NFR-01`):** مدعوم بفهرس مركب `idx_slots_lookup` للاستجابة بأقل من 1.5 ثانية.
- **معاملات الاستعلام (Query Parameters):**
  - `date` (**إجباري**): تاريخ اليوم بصيغة `YYYY-MM-DD`.
- **مثال الطلب:** `GET /api/pitches/1/slots?date=2026-10-01`
- **استجابة النجاح (`200 OK`):**
```json
{
  "success": true,
  "message": "تم جلب فترات الساعات بنجاح",
  "data": {
    "pitch_id": 1,
    "pitch_name": "ملعب الأساطير الرياضي",
    "date": "2026-10-01",
    "slots": [
      {
        "id": 101,
        "start_time": "18:00",
        "end_time": "19:00",
        "price": 6000.0,
        "status": "booked",
        "is_past": false
      },
      {
        "id": 102,
        "start_time": "19:00",
        "end_time": "20:00",
        "price": 6000.0,
        "status": "available",
        "is_past": false
      },
      {
        "id": 103,
        "start_time": "20:00",
        "end_time": "21:00",
        "price": 6000.0,
        "status": "available",
        "is_past": false
      }
    ]
  }
}
```

---

### رابعاً: وحدة حجز الملاعب (Booking Module — FR-04)

#### 8. حجز فترة زمنية وتأكيدها (`POST /api/bookings`)
- **الوصف:** تثبيت حجز فترة زمنية متاحة للاعب المسجل، وتطبيق قواعد العمل `BR-01` و `BR-02` داخل `DB::transaction()`.
- **المصادقة:** مطلوب `Bearer Token` (صلاحية: `player`).
- **جسم الطلب (Request Body):**
```json
{
  "time_slot_id": 102,
  "notes": "تمرين فريق الصقور"
}
```
- **استجابة النجاح (`201 Created`):**
```json
{
  "success": true,
  "message": "تم تأكيد الحجز بنجاح",
  "data": {
    "id": 15,
    "booking_reference": "KP-2026-X781",
    "status": "confirmed",
    "total_price": 6000.0,
    "notes": "تمرين فريق الصقور",
    "pitch": {
      "id": 1,
      "name": "ملعب الأساطير الرياضي",
      "location": "صنعاء - حدة"
    },
    "time_slot": {
      "id": 102,
      "date": "2026-10-01",
      "start_time": "19:00",
      "end_time": "20:00"
    },
    "created_at": "2026-09-26T20:35:12.000000Z"
  }
}
```
- **استجابة خطأ تضارب الحجز المتزامن (`409 Conflict`) — تطبيق `BR-02`:**
```json
{
  "success": false,
  "message": "عذراً، تم حجز هذه الفترة للتو من قبل مستخدم آخر.",
  "errors": null
}
```
- **استجابة خطأ حجز فترة في الماضي (`400 Bad Request`) — تطبيق `BR-01`:**
```json
{
  "success": false,
  "message": "لا يمكن حجز فترة زمنية سابقة لتاريخ ووقت اللحظة الحالية.",
  "errors": null
}
```

---

#### 9. استعراض سجل حجوزات اللاعب (`GET /api/bookings/my`)
- **المصادقة:** مطلوب `Bearer Token` (صلاحية: `player`).
- **استجابة النجاح (`200 OK`):**
```json
{
  "success": true,
  "message": "تم جلب سجل الحجوزات",
  "data": [
    {
      "id": 15,
      "booking_reference": "KP-2026-X781",
      "status": "confirmed",
      "total_price": 6000.0,
      "pitch_name": "ملعب الأساطير الرياضي",
      "date": "2026-10-01",
      "time": "19:00 - 20:00",
      "can_cancel": true
    }
  ]
}
```

---

### خامساً: لوحة تحكم صاحب الملعب (Owner Dashboard — FR-05)

#### 10. جدول مواعيد اليوم للملعب (`GET /api/owner/pitches/{id}/schedule`)
- **الوصف:** استعراض الجدول اليومي لملعب محدد مع أسماء اللاعبين وبيانات التواصل لتنظيم الحضور.
- **المصادقة:** مطلوب `Bearer Token` (صلاحية: `owner` ويكون هو مالك الملعب).
- **معاملات الاستعلام:** `date=YYYY-MM-DD` (افتراضياً تاريخ اليوم).
- **استجابة النجاح (`200 OK`):**
```json
{
  "success": true,
  "message": "تم جلب جدول المواعيد اليومي",
  "data": {
    "pitch_name": "ملعب الأساطير الرياضي",
    "date": "2026-10-01",
    "schedule": [
      {
        "slot_id": 101,
        "time": "18:00 - 19:00",
        "status": "booked",
        "booking": {
          "id": 14,
          "booking_reference": "KP-2026-K110",
          "player_name": "أحمد الشامي",
          "player_phone": "777888999",
          "total_price": 6000.0,
          "booking_status": "confirmed"
        }
      },
      {
        "slot_id": 102,
        "time": "19:00 - 20:00",
        "status": "available",
        "booking": null
      }
    ]
  }
}
```

---

#### 11. تحديث حالة الحجز من المالك (`PATCH /api/owner/bookings/{id}/status`)
- **الوصف:** تأكيد حضور اللاعب للمباراة، أو تعليم الحجز كمكتمل بعد انتهاء المباراة، أو إلغائه.
- **المصادقة:** مطلوب `Bearer Token` (صلاحية: `owner`).
- **جسم الطلب (Request Body):**
```json
{
  "status": "completed"
}
```
*(القيم المسموحة: `confirmed`, `completed`, `cancelled`)*.
- **استجابة النجاح (`200 OK`):**
```json
{
  "success": true,
  "message": "تم تحديث حالة الحجز إلى مكتمل بنجاح",
  "data": {
    "booking_id": 14,
    "status": "completed"
  }
}
```

---

#### 12. تسجيل وإضافة ملعب جديد (`POST /api/owner/pitches`)
- **الوصف:** تمكين صاحب المنشأة الرياضية من إضافة ملعب جديد ورفع صوره ومواصفاته وأسعاره ونشره في المنصة.
- **المصادقة:** مطلوب `Bearer Token` (صلاحية: `owner`).
- **نوع المحتوى:** `multipart/form-data`
- **معاملات الطلب (Form-Data Parameters):**
  - `name` (إلزامي): اسم الملعب (حتى 150 حرفاً).
  - `location` (إلزامي): المدينة والحي والعنوان.
  - `turf_type` (إلزامي): نوع العشب (`artificial` أو `natural` أو `hybrid`).
  - `hourly_rate` (إلزامي): سعر الساعة بالريال اليمني (رقم موجب).
  - `contact_phone` (إلزامي): رقم هاتف الحجز والتواصل.
  - `description` (اختياري): نبذة وتجهيزات الملعب.
  - `image` (اختياري): ملف صورة الملعب (`jpeg, png, jpg, webp`، حتى 3MB).
- **استجابة النجاح (`201 Created`):**
```json
{
  "success": true,
  "message": "تمت إضافة الملعب بنجاح وجاهز لاستقبال الحجوزات",
  "data": {
    "id": 7,
    "name": "ملعب النصر الأولمبي",
    "location": "صنعاء — السبعين",
    "turf_type": "artificial",
    "hourly_rate": 11000.0,
    "contact_phone": "777555444",
    "image_url": "storage/pitches/pitch_abc123.jpg",
    "description": "ملعب سباعي حديث مجهز بكشافات ليلية ومواقف سيارات واسعة.",
    "is_active": true
  }
}
```
- **استجابة أخطاء التحقق (`422 Unprocessable Content`):**
```json
{
  "success": false,
  "message": "فشل في التحقق من البيانات المدخلة",
  "errors": {
    "name": ["اسم الملعب مطلوب ولا يجب أن يتجاوز 150 حرفاً."],
    "hourly_rate": ["سعر الساعة يجب أن يكون قيمة عددية موجبة."],
    "image": ["الملف المرفوع يجب أن يكون صورة من نوع (jpeg, png, jpg, webp) وبحد أقصى 3 ميجابايت."]
  }
}
```

---

### سادساً: إلغاء الحجز (Cancellation Module — FR-06)

#### 13. إلغاء الحجز من اللاعب (`POST /api/bookings/{id}/cancel`)
- **الوصف:** تمكين اللاعب من إلغاء حجزه شريطة ألا يتبقى أقل من ساعتين على بداية المباراة (تطبيق قاعدة العمل `BR-03`).
- **المصادقة:** مطلوب `Bearer Token` (صلاحية: `player` صاحب الحجز).
- **استجابة النجاح (`200 OK`):**
```json
{
  "success": true,
  "message": "تم إلغاء الحجز بنجاح وأصبحت الفترة متاحة للحجز مرة أخرى",
  "data": {
    "booking_id": 15,
    "booking_reference": "KP-2026-X781",
    "status": "cancelled"
  }
}
```
- **استجابة خطأ الإلغاء المتأخر (`400 Bad Request`) — تطبيق `BR-03`:**
```json
{
  "success": false,
  "message": "لا يحق لك إلغاء الحجز، نظراً لتبقي أقل من ساعتين على موعد بداية المباراة بحسب سياسة المنصة.",
  "errors": null
}
```
- **استجابة خطأ محاولة إلغاء حجز شخص آخر (`403 Forbidden`):**
```json
{
  "success": false,
  "message": "غير مصرح لك بإلغاء هذا الحجز.",
  "errors": null
}
```

---

## 4. 🛡️ معالجة حالات الحافة والأخطاء المركزية (Edge Cases Handling)

| حالة الحافة | المتطلب / القاعدة | كود الـ HTTP | محتوى رسالة الاستجابة |
|---|:---:|:---:|---|
| **تضارب الحجز المتزامن (Race Condition)** | `BR-02`, `NFR-04` | `409 Conflict` | `"عذراً، تم حجز هذه الفترة للتو من قبل مستخدم آخر."` |
| **محاولة حجز فترة في الماضي** | `BR-01` | `400 Bad Request` | `"لا يمكن حجز فترة زمنية سابقة لتاريخ ووقت اللحظة الحالية."` |
| **محاولة إلغاء قبل أقل من ساعتين** | `BR-03` | `400 Bad Request` | `"لا يحق لك إلغاء الحجز، نظراً لتبقي أقل من ساعتين على موعد بداية المباراة."` |
| **إلغاء حجز ملغي مسبقاً أو مكتمل** | — | `400 Bad Request` | `"لا يمكن إلغاء حجز ملغي مسبقاً أو منتهي."` |
| **حقول إدخال ناقصة أو غير صالحة** | `NFR-02` | `422 Unprocessable` | قائمة تفصيلية بالأخطاء لكل حقل في مصفوفة `errors`. |
| **طلب محمي بدون Token أو Token منتهي** | `NFR-02` | `401 Unauthorized` | `"يرجى تسجيل الدخول أولاً للوصول إلى هذه الخدمة."` |
| **لاعب يحاول الوصول للوحة المالك** | — | `403 Forbidden` | `"ليس لديك الصلاحية الكافية للوصول إلى هذا المورد."` |

---

## 5. 🧪 خطة اختبار الـ API عبر Postman (Postman Test Collection)

تم تنظيم مسارات الـ API في مجلدات متوافقة مع مجموعة **Postman Collection** لتسهيل فحص وتقييم المشروع أكاديمياً:

1. **📁 01_Authentication:**
   - `Register Player` & `Register Owner`
   - `Login` (يتم حفظ الـ Token تلقائياً في متغير `{{token}}`)
   - `Get Current User Profile`
   - `Logout`
2. **📁 02_Pitches:**
   - `List All Pitches` (مع معاملات الفلترة)
   - `Get Pitch Details`
3. **📁 03_TimeSlots:**
   - `Get Slots By Date`
4. **📁 04_Bookings:**
   - `Create Booking (Happy Path)`
   - `Create Booking (Race Condition / Already Booked -> 409)`
   - `Create Booking (Past Slot -> 400)`
   - `My Bookings List`
5. **📁 05_Owner_Dashboard:**
   - `View Daily Schedule`
   - `Update Booking Status`
6. **📁 06_Cancellation:**
   - `Cancel Booking (Valid Window >= 2 Hours -> 200)`
   - `Cancel Booking (Invalid Window < 2 Hours -> 400)`

---

## 6. ✅ قائمة التحقق (API Specification Checklist)

- [x] تم توثيق معايير الـ API وهيكل الاستجابة الموحد (Unified Envelope).
- [x] تم تغطية جميع المتطلبات الوظيفية (FR-01 إلى FR-06) بالـ Endpoints المناسبة.
- [x] تم توثيق ترويسات ونظام المصادقة عبر **Laravel Sanctum Bearer Token** (NFR-02).
- [x] تم تغطية قواعد العمل بالكامل (`BR-01`, `BR-02`, `BR-03`).
- [x] تم تحديد أكواد حالات HTTP المناسبة لكل حالة بنجاح وفشل.
- [x] تم توثيق معالجة حالات الحافة وتضارب السباق (Race Condition 409).
- [x] تم إعداد هيكل مجموعة اختبار Postman لتسهيل الاختبار والتقييم.
- [ ] بانتظار مراجعة واعتماد Team Coordinator (`OsamaShomis`) عبر الـ Pull Request.

---

*تم إعداد هذا التوثيق بواسطة: محمد الإدريسي (`Mo-ra778` — Repository Maintainer & Developer)*  
*الخطوة المرتبطة: الخطوة رقم 10 من وثيقة توزيع المهام [`docs/WORK_DISTRIBUTION.md`](./WORK_DISTRIBUTION.md)*
