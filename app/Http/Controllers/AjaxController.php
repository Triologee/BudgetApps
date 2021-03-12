<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AjaxController extends Controller
{
    public function dt_application(Request $request) {

        // if($request->ajax()) {

            $applications = DB::table('applications')->get();
            // foreach ($applications as $application) {
            //     // $support->created_at = date("d M Y - g:i A", strtotime($support->created_at));
            //     if ($support->last_updated_by == '0') {
            //         $support->last_updated_by = "User-Generated";
            //     }
            // }

            return Datatables::of($applications)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return [
                        'display' => Carbon::parse($row->created_at)->format('d M Y - g:i A'),
                        'timestamp' => strtotime($row->created_at)
                    ];
                })
                ->addColumn('action', function($row){
                    $btn = '<a id="'. $row->id . '" class="view btn btn-sm btn-outline-secondary btn-icon-text">View</a>';
                    $btn .= '<a type="button" id="'. $row->id . '" class="delete ml-2 btn btn-danger btn-sm text-white">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        //     }

        // return redirect('/');

     }
}
