<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class ActivityLogController extends Controller
{
    public function data()
    {
        $data = Activity::query()
            ->with('causer')
            ->latest();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('causer', function (Activity $activity) {
                return $activity->causer ? $activity->causer->name : 'System';
            })
            ->addColumn('description', function (Activity $activity) {
                return $activity->description;
            })
            ->addColumn('created_at', function (Activity $activity) {
                return $activity->created_at->format('Y-m-d H:i:s');
            })
            ->make(true);
    }

    public function index()
    {
        return view('activity-log.index');
    }

}
