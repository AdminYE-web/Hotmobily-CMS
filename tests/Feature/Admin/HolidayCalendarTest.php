<?php

namespace Tests\Feature\Admin;

use App\Models\Holiday;
use Illuminate\Auth\Middleware\Authenticate;
use Tests\TestCase;

class HolidayCalendarTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        (require database_path('migrations/2026_09_02_032623_create_holidays_table.php'))->up();
        $this->withoutMiddleware(Authenticate::class);
    }

    private function holiday(string $calendarType): Holiday
    {
        return Holiday::create([
            'holiday_date' => '2026-11-03',
            'holiday_type' => 'type2',
            'calendar_type' => $calendarType,
        ]);
    }

    public function test_existing_holidays_become_normal_without_losing_details(): void
    {
        $holidays = collect(['both', 'cloth', 'normal'])->map(fn ($type) => $this->holiday($type));

        (require database_path('migrations/2026_10_15_000000_normalize_existing_holiday_calendars.php'))->up();

        $this->assertSame(3, Holiday::count());
        foreach ($holidays as $holiday) {
            $holiday->refresh();
            $this->assertSame('normal', $holiday->calendar_type);
            $this->assertSame('type2', $holiday->holiday_type);
            $this->assertSame('2026-11-03', $holiday->holiday_date->format('Y-m-d'));
        }
    }

    public function test_both_is_rejected_when_creating_and_updating(): void
    {
        $holiday = $this->holiday('normal');
        $payload = ['holiday_date' => '2026-11-03', 'holiday_type' => 'type2', 'calendar_type' => 'both'];

        $this->postJson('/api/v1/holidays', $payload)->assertUnprocessable()->assertJsonValidationErrors('calendar_type');
        $this->putJson('/api/v1/holidays/'.$holiday->id, $payload)->assertUnprocessable()->assertJsonValidationErrors('calendar_type');
        $this->assertSame('normal', $holiday->fresh()->calendar_type);
    }

    public function test_normal_and_cloth_can_be_saved_and_filtered_separately(): void
    {
        foreach (['normal', 'cloth'] as $type) {
            $this->postJson('/api/v1/holidays', [
                'holiday_date' => '2026-11-03',
                'holiday_type' => 'type2',
                'calendar_type' => $type,
            ])->assertCreated();
        }

        foreach (['normal', 'cloth'] as $type) {
            $this->getJson('/api/v1/holidays?calendar_type='.$type)
                ->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.calendar_type', $type);
        }
    }
}
