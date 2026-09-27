@extends('layouts.app')

@section('title', $pitch->name . ' — تفاصيل ومواصفات الملعب')

@section('content')
<div class="container" style="max-width: 1100px; margin: 0 auto; padding: 0.5rem 0 3rem 0;">

    {{-- Breadcrumb Navigation --}}
    <nav style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--color-text-muted); margin-bottom: 1.25rem;">
        <a href="{{ route('home') }}" style="color: var(--color-text-muted); text-decoration: none;">الرئيسية</a>
        <span>/</span>
        <a href="{{ route('pitches.index') }}" style="color: var(--color-text-muted); text-decoration: none;">الملاعب الرياضية</a>
        <span>/</span>
        <span style="color: var(--color-primary-dark); font-weight: 700;">{{ $pitch->name }}</span>
    </nav>

    {{-- Pitch Details Grid (Main content + Sidebar CTA) --}}
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
        
        {{-- Main Column --}}
        <div>
            {{-- Pitch Banner with Real Photo --}}
            <div style="height: 240px; border-radius: var(--radius-card); padding: 1.75rem; color: #FFFFFF; display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; margin-bottom: 1.5rem; box-shadow: var(--shadow-sm); background-color: #17321F;">
                @if($pitch->image_url && file_exists(public_path($pitch->image_url)))
                    <img src="{{ asset($pitch->image_url) }}" alt="{{ $pitch->name }}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                @else
                    <img src="{{ asset('images/hero-pitch.jpg') }}" alt="{{ $pitch->name }}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                @endif
                <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.45) 0%, rgba(13,40,22,0.6) 45%, rgba(10,30,16,0.92) 100%);"></div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1;">
                    <span style="font-size: 0.8rem; font-weight: 700; padding: 0.3rem 0.75rem; border-radius: var(--radius-pill); background: rgba(0, 0, 0, 0.35); backdrop-filter: blur(4px); border: 1px solid rgba(255, 255, 255, 0.2); display: inline-flex; align-items: center; gap: 0.4rem;">
                        @if($pitch->turf_type === 'natural')
                            <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #4ADE80;"></span>
                            <span>عشب طبيعي معتمد</span>
                        @elseif($pitch->turf_type === 'hybrid')
                            <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #FACC15;"></span>
                            <span>صالة رياضية مغطاة</span>
                        @else
                            <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #60A5FA;"></span>
                            <span>عشب صناعي (FIFA Standard)</span>
                        @endif
                    </span>

                    <span style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px); padding: 0.3rem 0.75rem; border-radius: var(--radius-pill); font-size: 0.825rem; font-weight: 600;">
                        ملعب معتمد في كورة بلص
                    </span>
                </div>

                <div style="position: relative; z-index: 1;">
                    <h1 style="font-size: 1.85rem; font-weight: 800; margin: 0 0 0.4rem 0;">
                        {{ $pitch->name }}
                    </h1>
                    <div style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.95rem; opacity: 0.95;">
                        <svg class="icon" style="width: 1.1rem; height: 1.1rem; color: #86EFAC;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>{{ $pitch->location }}</span>
                    </div>
                </div>
            </div>

            {{-- Description Card --}}
            <div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-card); padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--color-text-title); margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="icon" style="width: 1.25rem; height: 1.25rem; color: var(--color-primary-emerald);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6"/>
                        <line x1="8" y1="12" x2="21" y2="12"/>
                        <line x1="8" y1="18" x2="21" y2="18"/>
                        <line x1="3" y1="6" x2="3.01" y2="6"/>
                        <line x1="3" y1="12" x2="3.01" y2="12"/>
                        <line x1="3" y1="18" x2="3.01" y2="18"/>
                    </svg>
                    <span>نبذة ومواصفات الملعب</span>
                </h3>
                <p style="color: var(--color-text-body); font-size: 0.95rem; line-height: 1.8; margin: 0;">
                    {{ $pitch->description ?? 'ملعب مجهز بأفضل المعايير الرياضية لمباريات كرة القدم والتمارين الأسبوعية، مع إضاءة ليلية عالية الكفاءة وخدمات متكاملة للفرق واللاعبين.' }}
                </p>
            </div>

            {{-- Facilities & Features --}}
            <div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-card); padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--color-text-title); margin-bottom: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="icon" style="width: 1.25rem; height: 1.25rem; color: var(--color-primary-emerald);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <span>المرافق والتجهيزات المتوفرة</span>
                </h3>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background-color: var(--color-bg-main); border-radius: var(--radius-sm);">
                        <div style="width: 36px; height: 36px; border-radius: var(--radius-pill); background-color: var(--color-surface-mint); color: var(--color-primary-dark); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg class="icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2"/>
                            </svg>
                        </div>
                        <div>
                            <div style="font-size: 0.875rem; font-weight: 700; color: var(--color-text-title);">كشافات LED ليلية</div>
                            <div style="font-size: 0.775rem; color: var(--color-text-muted);">إضاءة كاشفة ممتازة للعب المسائي</div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background-color: var(--color-bg-main); border-radius: var(--radius-sm);">
                        <div style="width: 36px; height: 36px; border-radius: var(--radius-pill); background-color: var(--color-surface-mint); color: var(--color-primary-dark); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg class="icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 17V7h4a3 3 0 0 1 0 6H9"/>
                            </svg>
                        </div>
                        <div>
                            <div style="font-size: 0.875rem; font-weight: 700; color: var(--color-text-title);">مواقف سيارات خاصة</div>
                            <div style="font-size: 0.775rem; color: var(--color-text-muted);">مواقف مجانية وآمنة للاعبين</div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background-color: var(--color-bg-main); border-radius: var(--radius-sm);">
                        <div style="width: 36px; height: 36px; border-radius: var(--radius-pill); background-color: var(--color-surface-mint); color: var(--color-primary-dark); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg class="icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2v6h6M4 22h16a2 2 0 0 0 2-2V8l-6-6H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div style="font-size: 0.875rem; font-weight: 700; color: var(--color-text-title);">غرف تبديل واستحمام</div>
                            <div style="font-size: 0.775rem; color: var(--color-text-muted);">مرافق نظيفة واستراحة مكيفة</div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background-color: var(--color-bg-main); border-radius: var(--radius-sm);">
                        <div style="width: 36px; height: 36px; border-radius: var(--radius-pill); background-color: var(--color-surface-mint); color: var(--color-primary-dark); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg class="icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8zM6 1v3M10 1v3M14 1v3"/>
                            </svg>
                        </div>
                        <div>
                            <div style="font-size: 0.875rem; font-weight: 700; color: var(--color-text-title);">كافتيريا ومشروبات</div>
                            <div style="font-size: 0.775rem; color: var(--color-text-muted);">مياه شرب وعصائر ومشروبات طاقة</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Booking Rules & Policies --}}
            <div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-card); padding: 1.5rem; box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--color-text-title); margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="icon" style="width: 1.25rem; height: 1.25rem; color: var(--color-primary-dark);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>قواعد الحجز وسياسة الإلغاء (Rules & Policies)</span>
                </h3>

                <ul style="padding-right: 1.25rem; margin: 0; color: var(--color-text-body); font-size: 0.875rem; line-height: 1.8;">
                    <li><strong>تأكيد فوري (BR-02):</strong> بمجرد تأكيد حجزك، يتم قفل الفترة الزمنية فوراً ولا يمكن لأي مستخدم آخر حجزها.</li>
                    <li><strong>سياسة الإلغاء (BR-03):</strong> يحق للاعب إلغاء الحجز مجاناً وبكل سهولة حتى <strong>ساعتين قبل بداية المباراة</strong>، ولا يُقبل الإلغاء بعدها لضمان حقوق الملعب.</li>
                    <li><strong>الدفع عند الوصول:</strong> يتم سداد قيمة الحجز في مقر الملعب نقداً قبل بدء المباراة.</li>
                </ul>
            </div>
        </div>

        {{-- Sidebar Column: Action Card & Contact Info --}}
        <div>
            
            {{-- Reservation CTA Card --}}
            <div style="background-color: var(--color-card-bg); border: 2px solid var(--color-surface-mint); border-radius: var(--radius-card); padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-md);">
                
                <div style="margin-bottom: 1.25rem; text-align: center;">
                    <div style="font-size: 0.85rem; color: var(--color-text-muted); font-weight: 600; margin-bottom: 0.25rem;">
                        سعر حجز الساعة الواحدة
                    </div>
                    <div style="font-size: 2rem; font-weight: 900; color: var(--color-primary-dark); line-height: 1;">
                        {{ number_format($pitch->hourly_rate) }} <span style="font-size: 0.95rem; font-weight: 600; color: var(--color-text-body);">ر.ي</span>
                    </div>
                    <div style="font-size: 0.8rem; color: var(--color-primary-emerald); font-weight: 700; margin-top: 0.35rem;">
                        المباراة الكاملة (90 دقيقة): {{ number_format($pitch->hourly_rate * 1.5) }} ر.ي
                    </div>
                </div>

                {{-- Available Slots Alert --}}
                <div style="background-color: var(--color-surface-mint); border-radius: var(--radius-sm); padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; font-size: 0.875rem;">
                    <div style="display: flex; align-items: center; gap: 0.4rem; color: var(--color-primary-dark); font-weight: 700;">
                        <svg class="icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span>الفترات الشاغرة اليوم:</span>
                    </div>
                    <span style="background-color: var(--color-primary-dark); color: #FFFFFF; font-weight: 800; padding: 0.15rem 0.55rem; border-radius: var(--radius-pill); font-size: 0.8rem;">
                        {{ $availableSlotsCount }} فترات
                    </span>
                </div>

                {{-- Direct Action Button to FR-03 --}}
                <a href="{{ route('pitches.slots', $pitch->id) }}" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.85rem; font-size: 1rem; font-weight: 700; box-shadow: var(--shadow-sm); margin-bottom: 0.75rem;">
                    <svg class="icon" style="width: 1.2rem; height: 1.2rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <span>عرض جدول الساعات والحجز</span>
                </a>

                <a href="{{ route('pitches.index') }}" class="btn btn-outline-light" style="width: 100%; justify-content: center; padding: 0.65rem; font-size: 0.875rem; color: var(--color-text-body); border-color: var(--color-border);">
                    <span>العودة لجميع الملاعب</span>
                </a>
            </div>

            {{-- Pitch Owner Contact Card --}}
            <div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-card); padding: 1.25rem; box-shadow: var(--shadow-sm);">
                <h4 style="font-size: 0.95rem; font-weight: 800; color: var(--color-text-title); margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.4rem;">
                    <svg class="icon" style="width: 1.1rem; height: 1.1rem; color: var(--color-primary-emerald);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span>مسؤول الملعب</span>
                </h4>

                <div style="font-size: 0.9rem; font-weight: 700; color: var(--color-text-title); margin-bottom: 0.35rem;">
                    {{ $pitch->owner?->name ?? 'إدارة الملعب' }}
                </div>
                <div style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.875rem; color: var(--color-text-body); margin-bottom: 0.85rem;">
                    <svg class="icon" style="width: 0.95rem; height: 0.95rem; color: var(--color-primary-emerald);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    <span dir="ltr">{{ $pitch->contact_phone }}</span>
                </div>

                <a href="tel:{{ $pitch->contact_phone }}" class="btn btn-outline-light" style="width: 100%; justify-content: center; font-size: 0.8rem; padding: 0.45rem; border-color: var(--color-border); color: var(--color-primary-dark);">
                    اتصال للاستفسار
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
