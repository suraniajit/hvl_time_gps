<?php

namespace App\Http\Controllers\hvl\activitymaster;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportActivity;
use App\Http\Requests\ExcelBulkUploadRequest;
use App\User;
use Auth;
use App\Helpers\Helper;

class ActivityBulkUpdateController extends Controller {

    private $designation = [];
    private $team = [];
    private $departments = [];
    private $city = [];
    private $activity_status =[];

    public function index() {
        $user = Auth::user();
        if (!$user->can('Update Activity Bulkupdate')) {
            abort(403, 'Access denied');
        }
        return view('hvl.activitymaster.bulk_upload');
    }

    public function updateActivityStartdateEnddate(ExcelBulkUploadRequest $request) {
        $Edit_Activity = false;
        $user = Auth::user();
        if ($user->can('Edit Activity')) {
            $Edit_Activity = true;
        }
        if (!$user->can('Update Activity Bulkupdate')) {
            abort(403, 'Access denied');
        }
        $can_activity_edit = $user->can('activity.edit_activity');
        $line_no = 0;
        $flag = false;
        $existingActivity = array_flip(array_change_key_case($this->getExsitingActivity(), CASE_UPPER));
        try {
            DB::beginTransaction();
            $ExcelArray = Excel::toArray(new Controller(), $request->file('excel_file'));
            $prepare_data = $this->setData($ExcelArray[0]);
            // date_default_timezone_set("Asia/Kolkata");
           
//   echo "<pre>";
//         print_r( $prepare_data);
//         die;
            foreach ($prepare_data as $line_no => $row) {
                $activity_id = $row['id'];
                $activity_occur_count = count(array_filter($existingActivity, function ($a)use ($activity_id) {
                            return $a == $activity_id;
                        }));
                if ($row['action'] == 'EDIT') {
                    if (!$Edit_Activity) {
                        abort(403, 'Access Denied Multi edit Activity');
                    }

                    if ($activity_occur_count > 1) {
                        throw new \ErrorException('Same Activity id use multiple Activity have');
                    } else if ($activity_occur_count < 1) {
                        throw new \ErrorException('Activity not found');
                    }
                    /*
                      $activity_model2 = DB::table('hvl_activity_master')->where('id',$row['id'])->first();
                      $startEnddateFlag =
                      (Auth::user()->email != $super_admin && (!Auth::user()->hasRole('Coordinator')))
                      ?
                      (in_array(date('d') , Config::get('app.edit_start_end_date_date_enable_activity')))
                      ?
                      (date('m',strtotime($activity_model2->start_date))== date('m') )
                      ?
                      true
                      :
                      false
                      :false
                      :
                      true;
                      if(!$startEnddateFlag){
                      throw new \ErrorException('Today  not able to update');
                      }
                     */

                    $update_data = [];
                    if(isset($row['start_date']) && $row['start_date'] != null){
                        $update_data['start_date'] = $row['start_date'];
                    }
                    if(isset($row['end_date']) && $row['end_date'] != null){
                        $update_data['end_date'] = $row['end_date'];
                    }
                    if(isset($row['status']) && $row['status'] != null){
                        $update_data['status'] = $row['status'];
                    }
                    $activity_model = DB::table('hvl_activity_master');
                    $activity_data = $activity_model
                            ->where('id', $row['id'])
                            ->update($update_data);
                }
            }
            DB::commit();
            return redirect()->route('admin.activity_bulk_update.index')->with('success', 'Data has been uploaded successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return self::index($request)->withErrors("Please show a list of fields or row no = " . ($line_no + 2) . " where error is " . $e->getMessage());
        }
    }

    public function getExsitingActivity() {
        $employee = DB::table('hvl_activity_master')->pluck('id', 'id')->toArray();
        return $employee;
    }

    private function setData($data) {
        $helper = new Helper();
        $status_array = $this->getStatusArray();
     
        $response = [];
        foreach ($data as $key => $row) {
            if ($key == 0) {
                continue;
            }
            if (($row[0] == null) || ($row[1] == null) || ($row[2] == null) || ($row[3] == null)) {
                continue;
            }
            if (!isset($row[0])) {

                throw new \ErrorException('Action not found');
            }
            if (!isset($row[1])) {
                throw new \ErrorException('Transaction Id not found');
            }
            // if (!isset($row[2])) {
            //     throw new \ErrorException('Start date not found');
            // }
            // if (!isset($row[3])) {
            //     throw new \ErrorException('End date not found');
            // }
            $response[] = [
                'action' => trim(strtoupper($row[0])),
                'id' => trim($row[1]),
                'start_date' => (isset($row[2]) && $row[2] != null)?$helper->transformDate($row[2]):null,
                'end_date' =>( isset($row[3]) && $row[3] != null)? $helper->transformDate($row[3]):null,
                'status'=> ($row[4] != null && isset( $status_array[trim( strtoupper($row[4]))]))?$status_array[trim( strtoupper( $row[4]))]:null,
            ];
        }
        
        return $response;
    }
    public function getStatusArray(){
        $activity_status = DB::table('activitystatus')->pluck('Name','id')->toArray();
        
        return array_change_key_case(array_flip($activity_status),CASE_UPPER);
    }

}
