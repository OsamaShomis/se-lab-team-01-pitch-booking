@extends('layouts.app')

@section('title', 'إضافة ملعب جديد — منصة كورة بلص')

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
</style>
@endpush

@section('content')
<div class="form-page-container">

    <div style="margin-bottom: 1.25rem;">
        <a href="{{ route('owner.pitches.index') }}" class="btn btn-outline-light" style="color: var(--color-primary-dark); border-color: var(--color-border); font-size: 0.88rem; padding: 0.4rem 0.9rem;">
            <svg class="svg-icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            العودة لقائمة ملاعبي
        </a>
    </div>

    <div class="form-card">
        <div class="form-header">
            <h1>
                <svg class="svg-icon" style="width: 1.75rem; height: 1.75rem;" viewBox="0 0 24 24"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                إضافة ملعب رياضي جديد
            </h1>
            <p>أدخل مواصفات الملعب، موقعه، وسعر المباراة. سيقوم النظام تلقائياً بتجهيز جدول المواعيد للـ 4 أيام القادمة فور الإنشاء.</p>
        </div>

        <form action="{{ route('owner.pitches.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">اسم الملعب أو المنشأة *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="مثال: ملعب النجوم الدولي، صالة القمة المغلقة" required>
                @error('name')
                    <div style="color: #DC2626; font-size: 0.82rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="location">المدينة / الحي والموقع *</label>
                    <input type="text" id="location" name="location" class="form-control" value="{{ old('location') }}" placeholder="مثال: صنعاء - حدة، شارع الخمسين" required>
                    @error('location')
                        <div style="color: #DC2626; font-size: 0.82rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="turf_type">نوع الأرضية والعشب *</label>
                    <select id="turf_type" name="turf_type" class="form-control" required>
                        <option value="عشب صناعي" {{ old('turf_type') == 'عشب صناعي' ? 'selected' : '' }}>عشب صناعي (5G Artificial Turf)</option>
                        <option value="عشب طبيعي" {{ old('turf_type') == 'عشب طبيعي' ? 'selected' : '' }}>عشب طبيعي (Natural Grass)</option>
                        <option value="عشب هجين" {{ old('turf_type') == 'عشب هجين' ? 'selected' : '' }}>عشب هجين (Hybrid Turf)</option>
                        <option value="صالة مغطاة" {{ old('turf_type') == 'صالة مغطاة' ? 'selected' : '' }}>صالة مغطاة داخلية (Indoor Court)</option>
                        <option value="ترتان" {{ old('turf_type') == 'ترتان' ? 'selected' : '' }}>ترتان احترافي (Tartan)</option>
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="hourly_rate">سعر الفترة الافتراضي (ريال يمني) *</label>
                    <input type="number" id="hourly_rate" name="hourly_rate" class="form-control" value="{{ old('hourly_rate', 15000) }}" min="1000" step="500" required>
                    <div class="helper-text">سعر المباراة الافتراضي (مدة 90 دقيقة).</div>
                </div>

                <div class="form-group">
                    <label for="contact_phone">رقم هاتف التواصل والواتساب *</label>
                    <input type="text" id="contact_phone" name="contact_phone" class="form-control" value="{{ old('contact_phone', '777000111') }}" placeholder="777XXXXXX" required>
                </div>
            </div>

            <div class="form-group">
                <label for="image_url">رابط صورة الملعب (URL)</label>
                <input type="url" id="image_url" name="image_url" class="form-control" value="{{ old('image_url', 'https://images.unsplash.com/photo-1529900240041-52c3ad58b021?auto=format&fit=crop&w=800&q=80') }}" placeholder="https://example.com/pitch.jpg">
                <div class="helper-text">يمكنك ترك الرابط الافتراضي أو وضع رابط صورة خاصة بملعبك.</div>
            </div>

            <div class="form-group">
                <label for="description">وصف ومميزات الملعب (اختياري)</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="مثال: إضاءة ليلية كاشفة ممتازة، كرات وأقمصة تدريب متوفرة، غرف تبديل ومغاسل نظيفة، ومواقف سيارات واسعة.">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <div class="toggle-group">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label for="is_active" style="margin-bottom: 0; cursor: pointer;">
                        <strong>تفعيل الملعب وجعله متاحاً للحجز فوراً</strong>
                        <div class="helper-text">يمكنك تعطيله مؤقتاً في أي وقت أثناء الصيانة.</div>
                    </label>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem;">
                <a href="{{ route('owner.pitches.index') }}" class="btn btn-outline-light" style="color: var(--color-text-body); border-color: var(--color-border);">إلغاء</a>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                    <svg class="svg-icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    حفظ وإضافة الملعب
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
