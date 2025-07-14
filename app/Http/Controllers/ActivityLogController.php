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
            ->with('causer', 'subject')
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
            ->addColumn('subject', function (Activity $activity) {
                return $activity->subject ? $activity->subject : 'System';
            })
            ->addColumn('changes', function (Activity $activity) {
                // You can customize this to show only updated/created properties
                $changes = $activity->changes;
                // Example: show only 'attributes' (new values)
                return isset($changes['attributes'])
                    ? json_encode($changes['attributes'])
                    : '';
            })
            ->make(true);
    }

    public function index()
    {
        return view('activity-log.index');
    }

}
