@extends('layouts.app')

@section('title', 'تعديل ' . $pitch->name . ' — منصة كورة بلص')

@push('styles')
<style>
    .form-page-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        padding: 2.25rem;
        box-shadow: 0 6px 24px -6px rgba(53, 76, 43, 0.08);
    }

    .form-header {
        margin-bottom: 2rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--color-border-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .form-header h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 0.35rem;
    }

    .form-header p {
        color: var(--color-text-muted);
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 1.4rem;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--color-primary-dark);
        margin-bottom: 0.45rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid var(--color-border-light);
        border-radius: var(--radius-btn);
        font-family: inherit;
        font-size: 0.95rem;
        color: var(--color-text-dark);
        background: #ffffff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--color-primary-dark);
        box-shadow: 0 0 0 3px rgba(53, 76, 43, 0.12);
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    @media (max-width: 640px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .helper-text {
        font-size: 0.8rem;
        color: var(--color-text-muted);
        margin-top: 0.3rem;
    }

    .toggle-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background: var(--color-bg-main);
        border-radius: var(--radius-md);
        border: 1px solid var(--color-border-light);
    }

    .toggle-group input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: var(--color-primary-dark);
        cursor: pointer;
    }

    .danger-zone-box {
        margin-top: 2.5rem;
        padding: 1.5rem;
        border-radius: var(--radius-md);
        background: #FEF2F2;
        border: 1px solid #FCA5A5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
</style>
@endpush

@section('content')
<div class="form-page-container">

    <div style="margin-bottom: 1.25rem;">
        <a href="{{ route('owner.pitches.show', $pitch) }}" class="btn btn-outline-light" style="color: var(--color-primary-dark); border-color: var(--color-border); font-size: 0.88rem; padding: 0.4rem 0.9rem;">
            <svg class="svg-icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            العودة لصفحة إدارة الملعب
        </a>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div>
                <h1>
                    <svg class="svg-icon" style="width: 1.75rem; height: 1.75rem;" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                    تعديل إعدادات: {{ $pitch->name }}
                </h1>
                <p>تحديث اسم الملعب، الأسعار، وسيلة التواصل، ومواصفات الأرضية.</p>
            </div>
        </div>

        <form action="{{ route('owner.pitches.update', $pitch) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">اسم الملعب أو المنشأة *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $pitch->name) }}" required>
                @error('name')
                    <div style="color: #DC2626; font-size: 0.82rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="location">المدينة / الحي والموقع *</label>
                    <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $pitch->location) }}" required>
                    @error('location')
                        <div style="color: #DC2626; font-size: 0.82rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="turf_type">نوع الأرضية والعشب *</label>
                    <select id="turf_type" name="turf_type" class="form-control" required>
                        <option value="عشب صناعي" {{ old('turf_type', $pitch->turf_type) == 'عشب صناعي' ? 'selected' : '' }}>عشب صناعي (5G Artificial Turf)</option>
                        <option value="عشب طبيعي" {{ old('turf_type', $pitch->turf_type) == 'عشب طبيعي' ? 'selected' : '' }}>عشب طبيعي (Natural Grass)</option>
                        <option value="عشب هجين" {{ old('turf_type', $pitch->turf_type) == 'عشب هجين' ? 'selected' : '' }}>عشب هجين (Hybrid Turf)</option>
                        <option value="صالة مغطاة" {{ old('turf_type', $pitch->turf_type) == 'صالة مغطاة' ? 'selected' : '' }}>صالة مغطاة داخلية (Indoor Court)</option>
                        <option value="ترتان" {{ old('turf_type', $pitch->turf_type) == 'ترتان' ? 'selected' : '' }}>ترتان احترافي (Tartan)</option>
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="hourly_rate">سعر الفترة الافتراضي (ريال يمني) *</label>
                    <input type="number" id="hourly_rate" name="hourly_rate" class="form-control" value="{{ old('hourly_rate', (int)$pitch->hourly_rate) }}" min="1000" step="500" required>
                    <div class="helper-text">سعر المباراة الافتراضي عند توليد فترات جديدة.</div>
                </div>

                <div class="form-group">
                    <label for="contact_phone">رقم هاتف التواصل والواتساب *</label>
                    <input type="text" id="contact_phone" name="contact_phone" class="form-control" value="{{ old('contact_phone', $pitch->contact_phone) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="image_url">رابط صورة الملعب (URL)</label>
                <input type="url" id="image_url" name="image_url" class="form-control" value="{{ old('image_url', $pitch->image_url) }}" placeholder="https://example.com/pitch.jpg">
            </div>

            <div class="form-group">
                <label for="description">وصف ومميزات الملعب</label>
                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $pitch->description) }}</textarea>
            </div>

            <div class="form-group">
                <div class="toggle-group">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $pitch->is_active) ? 'checked' : '' }}>
                    <label for="is_active" style="margin-bottom: 0; cursor: pointer;">
                        <strong>تفعيل الملعب (متاح للحجز)</strong>
                        <div class="helper-text">إلغاء التحديد سيجعل الملعب يظهر كـ "مغلق مؤقتاً للصيانة" للاعبين.</div>
                    </label>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem;">
                <a href="{{ route('owner.pitches.show', $pitch) }}" class="btn btn-outline-light" style="color: var(--color-text-body); border-color: var(--color-border);">إلغاء</a>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                    <svg class="svg-icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    حفظ التعديلات
                </button>
            </div>
        </form>

        <!-- Danger Zone: Delete Pitch -->
        <div class="danger-zone-box">
            <div>
                <strong style="color: #991B1B; display: block; margin-bottom: 0.2rem;">حذف هذا الملعب نهائياً</strong>
                <span style="font-size: 0.85rem; color: #7F1D1D;">سيؤدي هذا لحذف جدول المواعيد المرتبط به. لا يمكن الحذف إذا كانت هناك حجوزات نشطة.</span>
            </div>
            <form action="{{ route('owner.pitches.destroy', $pitch) }}" method="POST" onsubmit="return confirm('تحذير: هل أنت متأكد من حذف الملعب وجدول مواعيده نهائياً؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background: #DC2626; color: #FFFFFF; font-size: 0.88rem; padding: 0.5rem 1.25rem;">
                    <svg class="svg-icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    حذف الملعب
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
