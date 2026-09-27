<?php

namespace Tests\Feature;

use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PitchCatalogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public catalog screen can be rendered successfully.
     */
    public function test_user_can_view_pitches_catalog_page(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب الأساطير الرياضي',
            'location' => 'صنعاء — حي حدة',
            'is_active' => true,
        ]);

        $response = $this->get(route('pitches.index'));

        $response->assertStatus(200);
        $response->assertSee('ملعب الأساطير الرياضي');
        $response->assertSee('صنعاء — حي حدة');
        $response->assertSee('تصفية');
    }

    /**
     * Test only active pitches are visible in the catalog.
     */
    public function test_only_active_pitches_are_listed_in_catalog(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $activePitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب نشط ومعتمد',
            'is_active' => true,
        ]);

        $inactivePitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب مغلق للصيانة',
            'is_active' => false,
        ]);

        $response = $this->get(route('pitches.index'));

        $response->assertStatus(200);
        $response->assertSee('ملعب نشط ومعتمد');
        $response->assertDontSee('ملعب مغلق للصيانة');
    }

    /**
     * Test search filter by name or keyword.
     */
    public function test_user_can_search_pitches_by_name(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $targetPitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب الصقر الملكي',
            'location' => 'تعز',
            'is_active' => true,
        ]);

        $otherPitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب اليرموك الذهبي',
            'location' => 'صنعاء',
            'is_active' => true,
        ]);

        $response = $this->get(route('pitches.index', ['search' => 'الصقر']));

        $response->assertStatus(200);
        $response->assertSee('ملعب الصقر الملكي');
        $response->assertDontSee('ملعب اليرموك الذهبي');
    }

    /**
     * Test filtering pitches by location.
     */
    public function test_user_can_filter_pitches_by_location(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $adenPitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب ساحل عدن',
            'location' => 'عدن — خور مكسر',
            'is_active' => true,
        ]);

        $sanaaPitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب السبعين',
            'location' => 'صنعاء — السبعين',
            'is_active' => true,
        ]);

        $response = $this->get(route('pitches.index', ['location' => 'عدن']));

        $response->assertStatus(200);
        $response->assertSee('ملعب ساحل عدن');
        $response->assertDontSee('ملعب السبعين');
    }

    /**
     * Test filtering pitches by turf type.
     */
    public function test_user_can_filter_pitches_by_turf_type(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $naturalPitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب العشب الطبيعي',
            'turf_type' => 'natural',
            'is_active' => true,
        ]);

        $artificialPitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب العشب الصناعي',
            'turf_type' => 'artificial',
            'is_active' => true,
        ]);

        $response = $this->get(route('pitches.index', ['turf_type' => 'natural']));

        $response->assertStatus(200);
        $response->assertSee('ملعب العشب الطبيعي');
        $response->assertDontSee('ملعب العشب الصناعي');
    }

    /**
     * Test viewing single pitch details.
     */
    public function test_user_can_view_single_pitch_details(): void
    {
        $owner = User::factory()->create(['role' => 'owner', 'name' => 'الكابتن علي', 'phone' => '777123456']);
        $pitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب النجوم العالمي',
            'location' => 'صنعاء — شارع حدة',
            'hourly_rate' => 12000.00,
            'contact_phone' => '777123456',
            'description' => 'ملعب سباعي مجهز بكشافات ليلية وغرف استراحة.',
            'is_active' => true,
        ]);

        // Add 2 available slots today
        TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => Carbon::today()->toDateString(),
            'status' => 'available',
        ]);

        $response = $this->get(route('pitches.show', $pitch));

        $response->assertStatus(200);
        $response->assertSee('ملعب النجوم العالمي');
        $response->assertSee('12,000');
        $response->assertSee('كشافات LED ليلية');
        $response->assertSee('الكابتن علي');
        $response->assertSee(route('pitches.slots', $pitch));
    }

    /**
     * Test viewing inactive pitch returns 404.
     */
    public function test_inactive_pitch_returns_404(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'is_active' => false,
        ]);

        $response = $this->get(route('pitches.show', $pitch));

        $response->assertStatus(404);
    }

    /**
     * Test API endpoint /api/pitches returns JSON with unified envelope.
     */
    public function test_api_pitches_endpoint_returns_json(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب API التجريبي',
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/pitches');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم جلب الملاعب بنجاح',
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'location',
                    'turf_type',
                    'hourly_rate',
                    'contact_phone',
                    'owner' => ['id', 'name'],
                ],
            ],
        ]);
    }

    /**
     * Test API endpoint /api/pitches/{id} returns pitch details.
     */
    public function test_api_pitch_show_endpoint_returns_json(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب تفاصيل API',
            'is_active' => true,
        ]);

        $response = $this->getJson("/api/pitches/{$pitch->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => $pitch->id,
                'name' => 'ملعب تفاصيل API',
            ],
        ]);
    }
}
