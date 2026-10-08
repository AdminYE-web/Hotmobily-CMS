<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MeetingDateController extends Controller
{
    private const TABLE = 'HM_meeting_date';

    /** @var list<string> */
    private const STATUSES = [
        'New',
        'In progress',
        'Closed',
    ];

    public function index(Request $request): View
    {
        $filters = $this->filters($request);
        $tableReady = Schema::hasTable(self::TABLE);
        $meetingDates = collect();

        if ($tableReady) {
            $query = DB::table(self::TABLE)
                ->select([
                    'id',
                    'date_create',
                    'status',
                    'cont_type',
                    'company_name',
                    'person_name',
                    'email',
                ])
                ->orderByDesc('date_create')
                ->orderByDesc('id');

            if (filled($filters['id'])) {
                $query->where('id', 'like', '%'.$filters['id'].'%');
            }

            if (filled($filters['email'])) {
                $query->where('email', 'like', '%'.$filters['email'].'%');
            }

            if (filled($filters['company_name'])) {
                $query->where('company_name', 'like', '%'.$filters['company_name'].'%');
            }

            if (filled($filters['person_name'])) {
                $query->where('person_name', 'like', '%'.$filters['person_name'].'%');
            }

            if (filled($filters['cont_type'])) {
                $query->where('cont_type', $filters['cont_type']);
            }

            if (filled($filters['date_from'])) {
                $query->whereDate('date_create', '>=', $filters['date_from']);
            }

            if (filled($filters['date_to'])) {
                $query->whereDate('date_create', '<=', $filters['date_to']);
            }

            if (filled($filters['status'])) {
                $query->where('status', $filters['status']);
            }

            $meetingDates = $query->get();
        }

        return view('admin.meeting-date.index', [
            'meetingDates' => $meetingDates,
            'filters' => $filters,
            'statuses' => self::STATUSES,
            'tableReady' => $tableReady,
        ]);
    }

    public function show(string $meetingDate): View
    {
        abort_unless(Schema::hasTable(self::TABLE), 404);

        $record = DB::table(self::TABLE)
            ->where('id', $meetingDate)
            ->first();

        abort_if($record === null, 404);

        return view('admin.meeting-date.show', [
            'record' => $record,
            'statuses' => self::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, string $meetingDate): RedirectResponse
    {
        abort_unless(Schema::hasTable(self::TABLE), 404);

        abort_unless(
            DB::table(self::TABLE)->where('id', $meetingDate)->exists(),
            404
        );

        $data = $request->validate([
            'status' => ['required', 'string', Rule::in(self::STATUSES)],
        ]);

        DB::table(self::TABLE)
            ->where('id', $meetingDate)
            ->update([
                'status' => $data['status'],
                'date_modify' => now(),
            ]);

        $this->writeLog('UPDATE:Meeting date status');

        return redirect()
            ->route('admin.meeting-date.show', ['meetingDate' => $meetingDate])
            ->with('success', 'Meeting date status updated.');
    }

    /** @return array<string, string> */
    private function filters(Request $request): array
    {
        $empty = [
            'id' => '',
            'email' => '',
            'company_name' => '',
            'person_name' => '',
            'cont_type' => '',
            'date_from' => '',
            'date_to' => '',
            'status' => '',
        ];

        if ($request->boolean('clear')) {
            return $empty;
        }

        if (! $request->hasAny(array_keys($empty))) {
            return $empty;
        }

        $data = $request->validate([
            'id' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'person_name' => ['nullable', 'string', 'max:255'],
            'cont_type' => ['nullable', 'string', 'max:100'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'status' => ['nullable', 'string', Rule::in(self::STATUSES)],
        ]);

        return array_map(
            static fn ($value): string => trim((string) ($value ?? '')),
            array_merge($empty, $data)
        );
    }

    private function writeLog(string $detail): void
    {
        if (! Schema::hasTable('HM_log')) {
            return;
        }

        DB::table('HM_log')->insert([
            'user' => auth('admin')->user()?->user ?? 'admin',
            'detail' => $detail,
            'date_create' => now(),
        ]);
    }
}
