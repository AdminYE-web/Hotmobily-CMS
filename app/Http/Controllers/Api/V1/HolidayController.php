<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $request->validate([
            'from' => [
                'nullable',
                'date',
            ],

            'to' => [
                'nullable',
                'date',
            ],

            'calendar_type' => [
                'nullable',
                'in:normal,cloth',
            ],
        ]);


        $query = Holiday::query();


        if ($request->filled('from')) {

            $query->whereDate(
                'holiday_date',
                '>=',
                $request->from
            );
        }


        if ($request->filled('to')) {

            $query->whereDate(
                'holiday_date',
                '<=',
                $request->to
            );
        }


        if ($request->filled('calendar_type')) {

            $calendarType =
                $request->calendar_type;


            $query->where(
                function ($q) use ($calendarType) {

                    $q->where(
                        'calendar_type',
                        $calendarType
                    )
                    ->orWhere(
                        'calendar_type',
                        'both'
                    );

                }
            );
        }


        $holidays = $query
            ->orderBy('holiday_date')
            ->get();


        return response()->json([

            'success' => true,

            'data' => $holidays->map(
                function ($holiday) {

                    return [

                        'id' =>
                            $holiday->id,

                        'date' =>
                            $holiday
                                ->holiday_date
                                ->format('Y-m-d'),

                        'type' =>
                            $holiday->holiday_type,

                        'calendar_type' =>
                            $holiday->calendar_type,

                        'title' =>
                            $holiday->title,

                    ];
                }
            ),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([

            'holiday_date' => [
                'required',
                'date',
            ],

            'holiday_type' => [
                'required',
                'in:type1,type2,type3',
            ],

            'calendar_type' => [
                'required',
                'in:normal,cloth,both',
            ],

            'title' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        $data['created_by'] =
            $request->user()?->email;


        $holiday =
            Holiday::create($data);


        return response()->json([

            'success' => true,

            'message' =>
                'Holiday created successfully.',

            'data' => $holiday,

        ], 201);
    }


    /*
    |--------------------------------------------------------------------------
    | Detail
    |--------------------------------------------------------------------------
    */

    public function show(Holiday $holiday)
    {
        return response()->json([

            'success' => true,

            'data' => [

                'id' =>
                    $holiday->id,

                'date' =>
                    $holiday
                        ->holiday_date
                        ->format('Y-m-d'),

                'type' =>
                    $holiday->holiday_type,

                'calendar_type' =>
                    $holiday->calendar_type,

                'title' =>
                    $holiday->title,

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Holiday $holiday
    ) {

        $data = $request->validate([

            'holiday_date' => [
                'required',
                'date',
            ],

            'holiday_type' => [
                'required',
                'in:type1,type2,type3',
            ],

            'calendar_type' => [
                'required',
                'in:normal,cloth,both',
            ],

            'title' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        $holiday->update($data);


        return response()->json([

            'success' => true,

            'message' =>
                'Holiday updated successfully.',

            'data' => $holiday,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();


        return response()->json([

            'success' => true,

            'message' =>
                'Holiday deleted successfully.',

        ]);
    }
}