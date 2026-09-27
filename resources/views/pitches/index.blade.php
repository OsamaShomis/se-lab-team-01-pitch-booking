@extends('layouts.app')

@section('title', 'دليل واستعراض الملاعب الرياضية — كورة بلص')

@section('styles')
<style>
    .hero-split-grid {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 2rem;
        align-items: center;
    }
    .pitch-card-visual {
        height: 180px;
        position: relative;
        overflow: hidden;
        background-color: #17321F;
    }
    .pitch-card-visual img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }
    .pitch-card:hover .pitch-card-visual img {
        transform: scale(1.06);
    }
    .hero-media-box {
        position: relative;
        height: 220px;
        border-radius: var(--radius-card);
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.25);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
    }
    .hero-media-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    @media (max-width: 860px) {
        .hero-split-grid {
            grid-template-columns: 1fr;
        }
        .hero-media-box {
            height: 180px;
        }
    }
</style>
@endsection

@section('content')
<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0.5rem 0 3rem 0;">

    {{-- Split Hero Section --}}
    <div style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, #15803D 100%); border-radius: var(--radius-card); padding: 2.25rem 2rem; color: #FFFFFF; margin-bottom: 2rem; box-shadow: var(--shadow-md); position: relative; overflow: hidden;">
        <div style="position: absolute; left: -40px; top: -40px; width: 180px; height: 180px; border-radius: 50%; background: rgba(255, 255, 255, 0.05); pointer-events: none;"></div>
        
        <div class="hero-split-grid" style="position: relative; z-index: 1;">
            {{-- Right Info Side (RTL) --}}
            <div>
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px); padding: 0.35rem 0.85rem; border-radius: var(--radius-pill); font-size: 0.825rem; font-weight: 700; margin-bottom: 0.85rem;">
                    <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="m4.93 4.93 4.24 4.24"/>
                        <path d="m14.83 9.17 4.24-4.24"/>
                        <path d="m14.83 14.83 4.24 4.24"/>
                        <path d="m9.17 14.83-4.24 4.24"/>
                        <circle cx="12" cy="12" r="4"/>
                    </svg>
                    <span>دليل الملاعب المعتمدة الرسمية</span>
                </div>

                <h1 style="font-size: 2.1rem; font-weight: 900; margin-bottom: 0.6rem; line-height: 1.3; text-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                    اختر ملعبك، حدد موعدك، وانطلق للمباراة
                </h1>
                
                <p style="color: rgba(255, 255, 255, 0.9); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.25rem;">
                    تصفح أفضل الملاعب المعشبة والصالات المغطاة في مختلف المدن، اطلع على التقييمات والمرافق، وتأكد من الساعات الشاغرة فورياً وبدون أي وساطة.
                </p>

                <div style="display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap; font-size: 0.85rem; font-weight: 600;">
                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                        <svg class="icon" style="width: 1.1rem; height: 1.1rem; color: #86EFAC;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        <span>{{ $pitches->count() }} ملاعب نشطة ومجهزة</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                        <svg class="icon" style="width: 1.1rem; height: 1.1rem; color: #86EFAC;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        <span>عشب صناعي وطبيعي وهجين</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                        <svg class="icon" style="width: 1.1rem; height: 1.1rem; color: #86EFAC;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        <span>تأكيد لحظي للحجز (BR-02)</span>
                    </div>
                </div>
            </div>

            {{-- Left Visual Side: Featured Stadium Frame --}}
            <div class="hero-media-box">
                <img src="{{ asset('images/hero-pitch.jpg') }}" alt="ملاعب كرة القدم في كورة بلص">
                <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(13,45,25,0.7) 100%);"></div>
                <div style="position: absolute; bottom: 12px; right: 14px; left: 14px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.775rem; font-weight: 700; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); padding: 0.3rem 0.65rem; border-radius: var(--radius-pill); border: 1px solid rgba(255, 255, 255, 0.25);">
                        ملاعب بمعايير دولية معتمدة
                    </span>
                    <span style="font-size: 0.75rem; color: #FEF08A; font-weight: 700; background: rgba(21, 128, 61, 0.85); padding: 0.25rem 0.6rem; border-radius: var(--radius-pill);">
                        تحديث مباشر
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Search Form --}}
    <div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-card); padding: 1.25rem; margin-bottom: 2rem; box-shadow: var(--shadow-sm);">
        <form action="{{ route('pitches.index') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 0.85rem; align-items: end;">
            
            {{-- Search Input --}}
            <div>
                <label style="display: block; font-size: 0.825rem; font-weight: 700; color: var(--color-text-title); margin-bottom: 0.35rem;">
                    البحث بالاسم أو الحي أو المحافظة
                </label>
                <div style="position: relative;">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="اكتب اسم الملعب أو الحي أو المحافظة..." style="width: 100%; padding: 0.65rem 0.85rem 0.65rem 2.25rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-size: 0.9rem; background-color: var(--color-bg-main); color: var(--color-text-title); outline: none;">
                    <svg class="icon" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 1.1rem; height: 1.1rem; color: var(--color-text-muted); pointer-events: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </div>
            </div>

            {{-- City Filter --}}
            <div>
                <label style="display: block; font-size: 0.825rem; font-weight: 700; color: var(--color-text-title); margin-bottom: 0.35rem;">
                    المدينة / المنطقة
                </label>
                <select name="location" style="width: 100%; padding: 0.65rem 0.85rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-size: 0.9rem; background-color: var(--color-bg-main); color: var(--color-text-title); outline: none;">
                    <option value="">جميع المدن</option>
                    @foreach($locations as $key => $name)
                        <option value="{{ $key }}" {{ ($location ?? '') === $key ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Turf Type Filter --}}
            <div>
                <label style="display: block; font-size: 0.825rem; font-weight: 700; color: var(--color-text-title); margin-bottom: 0.35rem;">
                    نوع الأرضية
                </label>
                <select name="turf_type" style="width: 100%; padding: 0.65rem 0.85rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-size: 0.9rem; background-color: var(--color-bg-main); color: var(--color-text-title); outline: none;">
                    <option value="">جميع الأرضيات</option>
                    @foreach($turfOptions as $val => $label)
                        <option value="{{ $val }}" {{ ($turfType ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Sort By --}}
            <div>
                <label style="display: block; font-size: 0.825rem; font-weight: 700; color: var(--color-text-title); margin-bottom: 0.35rem;">
                    ترتيب حسب
                </label>
                <select name="sort" style="width: 100%; padding: 0.65rem 0.85rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-size: 0.9rem; background-color: var(--color-bg-main); color: var(--color-text-title); outline: none;">
                    <option value="latest" {{ ($sort ?? '') === 'latest' ? 'selected' : '' }}>الأحدث إضافة</option>
                    <option value="price_asc" {{ ($sort ?? '') === 'price_asc' ? 'selected' : '' }}>السعر: من الأقل للأعلى</option>
                    <option value="price_desc" {{ ($sort ?? '') === 'price_desc' ? 'selected' : '' }}>السعر: من الأعلى للأقل</option>
                    <option value="name_asc" {{ ($sort ?? '') === 'name_asc' ? 'selected' : '' }}>الاسم أبجدياً</option>
                </select>
            </div>

            {{-- Submit & Reset Buttons --}}
            <div style="display: flex; gap: 0.4rem;">
                <button type="submit" class="btn btn-primary" style="padding: 0.65rem 1.15rem; display: inline-flex; align-items: center; gap: 0.4rem; white-space: nowrap;">
                    <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                    </svg>
                    <span>تصفية</span>
                </button>
                @if(!empty($search) || !empty($location) || !empty($turfType) || ($sort ?? '') !== 'latest')
                    <a href="{{ route('pitches.index') }}" class="btn btn-outline-light" style="padding: 0.65rem 0.85rem; color: var(--color-text-muted); border-color: var(--color-border);" title="إلغاء الفلاتر">
                        <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </a>
                @endif
            </div>

        </form>
    </div>

    {{-- Pitches Grid or Empty State --}}
    @if($pitches->isEmpty())
        <div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-card); padding: 3.5rem 1.5rem; text-align: center; max-width: 620px; margin: 2rem auto;">
            <div style="width: 64px; height: 64px; border-radius: var(--radius-pill); background-color: var(--color-surface-mint); color: var(--color-primary-dark); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;">
                <svg class="icon" style="width: 2rem; height: 2rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--color-text-title); margin-bottom: 0.6rem;">
                لا توجد ملاعب مطابقة لبحثك
            </h3>
            <p style="color: var(--color-text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                لم نتمكن من العثور على أي ملعب يطابق المعايير أو الكلمات المحددة. جرب اختيار مدينة أخرى أو مسح الفلاتر.
            </p>
            <a href="{{ route('pitches.index') }}" class="btn btn-primary">
                عرض جميع الملاعب ({{ \App\Models\Pitch::where('is_active', true)->count() }} ملاعب)
            </a>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 1.5rem;">
            @foreach($pitches as $pitch)
                <div class="pitch-card" style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-card); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.25s ease, box-shadow 0.25s ease; box-shadow: var(--shadow-sm);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='var(--shadow-md)';" onmouseout="this.style.transform='none'; this.style.boxShadow='var(--shadow-sm)';">
                    
                    {{-- Card Visual Header with Real Image --}}
                    <div class="pitch-card-visual">
                        @if($pitch->image_url && file_exists(public_path($pitch->image_url)))
                            <img src="{{ asset($pitch->image_url) }}" alt="{{ $pitch->name }}">
                        @elseif($pitch->image_url && (str_starts_with($pitch->image_url, 'http://') || str_starts_with($pitch->image_url, 'https://')))
                            <img src="{{ $pitch->image_url }}" alt="{{ $pitch->name }}">
                        @else
                            <img src="{{ asset('images/hero-pitch.jpg') }}" alt="{{ $pitch->name }}">
                        @endif

                        {{-- Dark Scrim Overlay for crisp text and badges --}}
                        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.08) 45%, rgba(13,38,22,0.9) 100%);"></div>

                        {{-- Top Badges --}}
                        <div style="position: absolute; top: 12px; left: 12px; right: 12px; display: flex; justify-content: space-between; align-items: center; z-index: 2;">
                            {{-- Turf Badge --}}
                            <span style="font-size: 0.775rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: var(--radius-pill); background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); border: 1px solid rgba(255, 255, 255, 0.25); color: #FFFFFF; display: inline-flex; align-items: center; gap: 0.35rem;">
                                @if($pitch->turf_type === 'natural')
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #4ADE80;"></span>
                                    <span>عشب طبيعي</span>
                                @elseif($pitch->turf_type === 'hybrid')
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #FACC15;"></span>
                                    <span>صالة مغطاة / هجين</span>
                                @else
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #60A5FA;"></span>
                                    <span>عشب صناعي (FIFA)</span>
                                @endif
                            </span>

                            {{-- Price Badge --}}
                            <div style="background: rgba(255, 255, 255, 0.95); color: var(--color-primary-dark); font-weight: 800; font-size: 0.95rem; padding: 0.25rem 0.75rem; border-radius: var(--radius-pill); box-shadow: var(--shadow-sm);">
                                <span>{{ number_format($pitch->hourly_rate) }}</span>
                                <span style="font-size: 0.75rem; font-weight: 600; color: var(--color-text-muted);">ر.ي/ساعة</span>
                            </div>
                        </div>

                        {{-- Pitch Name on Image --}}
                        <div style="position: absolute; bottom: 12px; right: 14px; left: 14px; z-index: 2;">
                            <h2 style="font-size: 1.35rem; font-weight: 900; color: #FFFFFF; margin: 0; text-shadow: 0 2px 6px rgba(0,0,0,0.8);">
                                {{ $pitch->name }}
                            </h2>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div style="padding: 1.25rem; flex: 1; display: flex; flex-direction: column;">
                        
                        {{-- Location Info --}}
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <svg class="icon" style="width: 1.15rem; height: 1.15rem; color: var(--color-primary-emerald); flex-shrink: 0; margin-top: 0.15rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span style="font-size: 0.875rem; color: var(--color-text-body); font-weight: 600; line-height: 1.4;">
                                {{ $pitch->location }}
                            </span>
                        </div>

                        {{-- Description Snippet --}}
                        <p style="font-size: 0.85rem; color: var(--color-text-muted); line-height: 1.5; margin-bottom: 1rem; flex: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $pitch->description ?? 'ملعب مجهز بأفضل المعايير الرياضية لمباريات كرة القدم والتمارين الأسبوعية.' }}
                        </p>

                        {{-- Amenities Chips --}}
                        <div style="display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1.25rem;">
                            <span style="font-size: 0.75rem; background-color: var(--color-surface-mint); color: var(--color-primary-dark); padding: 0.2rem 0.55rem; border-radius: var(--radius-sm); font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem;">
                                <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2"/>
                                </svg>
                                كشافات LED ليلية
                            </span>
                            <span style="font-size: 0.75rem; background-color: var(--color-surface-mint); color: var(--color-primary-dark); padding: 0.2rem 0.55rem; border-radius: var(--radius-sm); font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem;">
                                <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 17V7h4a3 3 0 0 1 0 6H9"/>
                                </svg>
                                مواقف سيارات
                            </span>
                            <span style="font-size: 0.75rem; background-color: var(--color-surface-mint); color: var(--color-primary-dark); padding: 0.2rem 0.55rem; border-radius: var(--radius-sm); font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem;">
                                <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2v6h6M4 22h16a2 2 0 0 0 2-2V8l-6-6H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2z"/>
                                </svg>
                                غرف تبديل واستراحة
                            </span>
                        </div>

                        {{-- Action Buttons --}}
                        <div style="display: grid; grid-template-columns: 1fr auto; gap: 0.65rem; border-top: 1px solid var(--color-border); padding-top: 1rem;">
                            <a href="{{ route('pitches.slots', $pitch->id) }}" class="btn btn-primary" style="justify-content: center; font-size: 0.875rem; padding: 0.65rem 0.85rem;">
                                <svg class="icon" style="width: 1.05rem; height: 1.05rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <span>جدول الساعات والحجز</span>
                            </a>
                            <a href="{{ route('pitches.show', $pitch->id) }}" class="btn btn-outline-light" style="justify-content: center; font-size: 0.875rem; padding: 0.65rem 0.85rem; color: var(--color-text-title); border-color: var(--color-border);" title="استعراض التفاصيل الكاملة">
                                <span>التفاصيل</span>
                                <svg class="icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="15 18 9 12 15 6"/>
                                </svg>
                            </a>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
