<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Application;


class AjaxController extends Controller
{
    public function dt_application(Request $request) {

        if($request->ajax()) {

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
                    if (auth()->user()->account_type == "faculty" && ($row->status == "Pending" || $row->status == "Rejected by Bursary" || $row->status == "Rejected by Dean")) {
                        $btn .= '<a type="button" id="'. $row->id . '" class="delete ml-2 btn btn-danger btn-sm text-white">Delete</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }

        return redirect('/');

     }

     public function view_application(Request $request) {

        if($request->ajax()) {

            $id = $request['id'];
            $applications = DB::table('applications')->where('id', $id)->get();
            foreach ($applications as $application) {
                $application->created_at = date("d M Y - g:i A", strtotime($application->created_at));
                $application->message = "<table class='table table-bordered' style='width:100%'>" . 
                "<tr><td style='width:20%'>Application Title</td><td class='text-center'>" . $application->title . "</td></tr>" .
                "<tr><td>Justification</td><td class='text-center'>" . $application->justification . "</td></tr>" .
                "<tr><td>Faculty</td><td class='text-center'>" . $application->faculty . "</td></tr>" .
                "<tr><td>Budget Type</td><td class='text-center'>" . $application->budget_type . "</td></tr>" .
                "<tr><td>Usage Type</td><td class='text-center'>" . $application->usage_type . "</td></tr>" .
                "<tr><td>General Ledger</td><td class='text-center'>" . $application->general_ledger . "</td></tr>" .
                "<tr><td>Application Date</td><td class='text-center'>" . $application->created_at . "</td></tr>" .
                "<tr><td>Status</td><td class='text-center'>" . $application->status . "</td></tr>";

                if ( (isset($application->remark)) && $application->remark !== "") {
                    $application->message .= "<tr><td>Remark</td><td class='text-center'>" . $application->remark . "</td></tr>";
                }
            
                $application->message .= "</table>" .
                "<table class='table table-bordered' style='width:100%'><thead>" . 
                "<tr><th style='width:5%'>No.</th>" . 
                "<th>Item Name</th>" . 
                "<th>Type</th>" . 
                "<th>Justification</th>" . 
                "<th>Price per unit (RM)</th>" .
                "<th>Quantity</th>" . 
                "<th>Unit of Measurement</th>" .
                "<th>Total (RM)</th></tr></thead>" .
                "<tbody>";

                $items = DB::table('items')->where('app_id', $application->id)->get();
                $i = 0;
                foreach ($items as $item) {
                    $i++;
                    $application->message .=    "<tr><td>" . $i . "</td>" .
                                                "<td>" . $item->item_name . "</td>" .
                                                "<td>" . $item->item_type . "</td>" .
                                                "<td>" . $item->item_justification . "</td>" .
                                                "<td>" . $item->item_price . "</td>" .
                                                "<td>" . $item->item_quantity . "</td>" .
                                                "<td>" . $item->item_unit_of_measurement . "</td>" .
                                                "<td>" . number_format($item->item_total, 2) . "</td></tr>";
                }
                $application->message .= "<tr><td colspan='7' class='text-right'><b>GRAND TOTAL (RM)</b></td><td>" . $application->total . "</td></tr>";
                if ($application->status == "Approved by Bursary") {
                    $application->message .= "<tr><td colspan='7' class='text-right'><b>APPROVED TOTAL (RM)</b></td><td>" . $application->approved_total . "</td></tr>";
                }
                $application->message .= "</tbody></table>";
            }

            return response()->json($applications);
            
        }

        return redirect('/');

     }

     public function update_application(Request $request) {

        if($request->ajax()) {

            $id = $request['id'];
            $status = $request['status'];
            $remark = $request['remark'];

            if (isset($request['approved_total'])) {
                $approved_total = number_format($request['approved_total'], 2);
                $application = Application::where('id', $id)->update(['status' => $status, 'remark' => $remark, 'approved_total' => $approved_total]);
            } else {
                $application = Application::where('id', $id)->update(['status' => $status, 'remark' => $remark]);
            }

            return response()->json("This applicated has been marked as '" . $status . "'");
            
        }

        return redirect('/');

     }

     public function delete_application(Request $request) {

        
        if($request->ajax()) {
            $id = $request['id'];

            $items = DB::table('items')->where('app_id', $id)->delete();
            $application = DB::table('applications')->where('id', $id)->delete();

            $response = "Budget application has been deleted.";
            return response()->json($response);
        }

        return redirect('/');

     }
}
