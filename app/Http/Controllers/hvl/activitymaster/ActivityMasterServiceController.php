<?php

namespace App\Http\Controllers\hvl\activitymaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hvl\ActivityServiceReport;
use App\TempUploadFile;
use File;
use PDF;
use Illuminate\Support\Facades\Validator;
use App\RelainceServiceForm;
use App\RelainceServiceFirstForm;
use App\RelainceServiceSecondForm;
use App\RelainceServiceThirdForm;
use App\RelainceServiceFourthForm;
use App\RelainceServiceFifthForm;
use App\Helpers\Helper;

class ActivityMasterServiceController extends Controller {

    public function saveImage(Request $request) {

        try {
            $filename = $this->saveImageFile('signature', $request->image_file);
            $helper = new Helper();
            return response()->json([
                        'status' => 'success',
                        'message' => 'successfully signature upload',
                        'data' => [
                            'user_type' => $request->user_type,
                            'file' => $helper->getGoogleDriveImage($filename),
                            'sign_time' => date('H:i'),
                            'file_name' => $filename,
                            
                        ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                        'status' => 'error',
                        'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveAndUpdateForm(Request $request) {
        try {
            // $technician_image = $this->tempToService($request->temp_technician_sign_id);// now upload google drive direct by ajit

            $technician_image = $request->technician_sign_file_name;
            // $client_image = $this->tempToService($request->temp_client_sign_id);// now upload google drive direct by ajit

            $client_image = $request->client_sign_file_name;
            $customer_activity = ActivityServiceReport::where('activity_id', $request->activity_id)->first();
            if (!$customer_activity) {
                $customer_activity = new ActivityServiceReport();
            }
            $customer_activity->client_sign_image = $client_image;
            $customer_activity->technican_sign_image = $technician_image;
            $customer_activity->activity_id = $request->activity_id;
            $customer_activity->service_spacification = $request->service_spacification;
            $customer_activity->in_time = $request->in_time;
            $customer_activity->out_time = $request->out_time;
            $customer_activity->technican_name = $request->technican_name;
            $customer_activity->client_name = $request->client_name;
            $customer_activity->client_mobile = $request->client_mobile;
            $customer_activity->save();
            date_default_timezone_set("Asia/Kolkata");
            DB::table('hvl_activity_master')
                    ->where('id', $request->activity_id)
                    ->update([
                        'status' => 1,
                        'complete_date' => date('Y-m-d')
            ]);
            return response()->json([
                        'status' => 'success',
                        'message' => 'successfuly data save.',
            ]);
        } catch (\Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            return response()->json([
                        'status' => 'error',
                        'message' => 'somthing went to wrong',
            ]);
        }
    }

    function saveImageFile($name, $file) {
        date_default_timezone_set("Asia/Kolkata");
        $filename = $name . "_" . date('Y_m_d_h_i_s_A') . ".jpg";
        // google drive by ajit
        $file_param = [
            'file_name' => $filename,
        ];
        $helper = new Helper();
        $file_result = $helper->uploadGoogleFile($file, $file_param);
        // google drive by ajit
        $path = ActivityServiceReport::IMAGE_PATH;
        $file->move($path, $filename);
        return $filename;
    }

    public function getActivityServieFormInfo($activity_id) {
        try {
            $activity_data = DB::table('hvl_activity_master')
                    ->leftJoin('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                    ->Join('Branch', 'hvl_customer_master.branch_name', '=', 'Branch.id')
                    ->select([
                        'branch_name' => 'Branch.name',
                        'site_name' => 'hvl_customer_master.customer_name',
                        'customer_add' => 'hvl_customer_master.billing_address',
                        'contact_parson' => 'hvl_customer_master.contact_person',
                        'contact_person_phone' => 'hvl_customer_master.contact_person_phone',
                        'contact_person_mail' => 'hvl_customer_master.billing_email',
                        'shipping_address' => 'hvl_customer_master.shipping_address',
                    ])
                    ->where('hvl_activity_master.id', $activity_id)
                    ->first();
            return response()->json([
                        'status' => 'success',
                        'message' => 'successfully get service form data',
                        'data' => $activity_data,
            ]);
        } catch (\Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            return response()->json([
                        'status' => 'error',
                        'message' => 'somthing went to wrong',
            ]);
        }
    }

    public function getActivityServieForm($activity_id) {
        try {
            $path = ActivityServiceReport::IMAGE_PATH;
            $customer_activity = ActivityServiceReport::where('activity_id', $activity_id)->first();
            if (!$customer_activity) {
                $customer_activity = new ActivityServiceReport();
            }
            $helper = new Helper();
            date_default_timezone_set("Asia/Kolkata");
            $data = [
                'service_spacification' => $customer_activity->service_spacification,
                'in_time' => ($customer_activity->in_time != null) ? $customer_activity->in_time : date('H:i'),
                'out_time' => $customer_activity->out_time,
                'technican_name' => $customer_activity->technican_name,
                // 'technican_sign_image'=>(isset($customer_activity->technican_sign_image))?$path."/".$customer_activity->technican_sign_image:'',
                'technican_sign_image' => (isset($customer_activity->technican_sign_image)) ? $helper->getGoogleDriveImage($customer_activity->technican_sign_image) : '',
                'client_name' => $customer_activity->client_name,
                'client_mobile' => $customer_activity->client_mobile,
                'client_sign_image' => (isset($customer_activity->client_sign_image)) ? $helper->getGoogleDriveImage($customer_activity->client_sign_image) : '',
                'client_seal_image' => (isset($customer_activity->client_seal_image)) ? $helper->getGoogleDriveImage($customer_activity->client_seal_image) : '',
            ];
            return response()->json([
                        'status' => 'success',
                        'message' => 'successfully get service form data',
                        'data' => $data,
            ]);
        } catch (\Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            return response()->json([
                        'status' => 'error',
                        'message' => 'somthing went to wrong',
            ]);
        }
    }

    public function downloadReportPdf($activity_id) {
        $path = ActivityServiceReport::IMAGE_PATH;
        $activity_data = DB::table('hvl_activity_master')
                ->leftJoin('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                ->Join('Branch', 'hvl_customer_master.branch_name', '=', 'Branch.id')
                ->join('activity_service_reports', 'hvl_activity_master.id', '=', 'activity_service_reports.activity_id')
                ->select([
                    'Branch.name AS branch_name',
                    'hvl_customer_master.customer_name AS site_name',
                    'hvl_customer_master.billing_address AS customer_add',
                    'hvl_customer_master.contact_person AS contact_parson',
                    'hvl_customer_master.contact_person_phone AS contact_person_phone',
                    'hvl_customer_master.billing_email AS contact_person_mail',
                    'hvl_customer_master.shipping_address AS shipping_address',
                    'activity_service_reports.service_spacification AS service_detail',
                    'activity_service_reports.in_time AS service_in_time',
                    'activity_service_reports.out_time AS service_out_time',
                    'activity_service_reports.technican_name AS service_technican_name',
                    'activity_service_reports.client_name AS service_client_name',
                    'activity_service_reports.client_mobile AS service_client_mobile',
                    'activity_service_reports.created_at AS date_time',
                    'activity_service_reports.client_sign_image as service_client_sign_image'
                ])
                // ->selectRaw('CONCAT("'.asset($path).'", "/", activity_service_reports.client_sign_image) as service_client_sign_image')
                ->where('hvl_activity_master.id', $activity_id)
                ->first();
        view()->share('activity_data', $activity_data);
        $helper = new Helper();
        $pdf = PDF::loadView('hvl.activitymaster.report.download_report', ['helper' => $helper]);
        return $pdf->download('hvl_activitymaster_report_download_report.pdf');
        // return view('hvl.activitymaster.report.download_report');
    }

    public function moveServiceReport(Request $request) {
        $is_old_activity_exsit = DB::table('hvl_activity_master')->where('id', $request->current_id)->first();
        if (!$is_old_activity_exsit) {
            return response()->json([
                        'status' => 'error',
                        'message' => 'Activity Not Found In Activity List',
            ]);
        }
        $is_new_activity_exsit = DB::table('hvl_activity_master')->where('id', $request->new_id)->first();
        if (!$is_new_activity_exsit) {
            return response()->json([
                        'status' => 'error',
                        'message' => 'Activity Not Found In Activity List',
            ]);
        }

        $is_exsit = new ActivityServiceReport();
        $jobcart_exist = $is_exsit->where('activity_id', $request->current_id)->first();
        if (!$jobcart_exist) {
            return response()->json([
                        'status' => 'error',
                        'message' => 'Activity Not Found In Activity Service Report',
            ]);
        }
        $new_alreday_exsit = new ActivityServiceReport();
        $new_alreday_exsit = $new_alreday_exsit->where('activity_id', $request->new_id)->first();
        if ($new_alreday_exsit) {
            return response()->json([
                        'status' => 'error',
                        'message' => 'Activity Have Already Jobcard Report',
            ]);
        }
        DB::table('hvl_activity_master')->where('id', $request->new_id)->update(['status' => 1,
            'complete_date' => $is_old_activity_exsit->complete_date]);

        DB::table('hvl_activity_master')->where('id', $request->current_id)->update(['status' => 3,
            'complete_date' => null]);
        $jobcart_exist->activity_id = $request->new_id;
        $jobcart_exist->save();
        return response()->json([
                    'status' => 'success',
                    'message' => 'jobcart have been move please refresh page',
        ]);
    }

    // new relaince form
    public function saveAndUpdateRelainceServiceForm(Request $request) {

        DB::beginTransaction();
        try {
            $activity_id = $request->activity_id;
            $relaince_form = RelainceServiceForm::firstOrNew(['activity_id' => $activity_id]);
            $relaince_form->activity_id = $activity_id;
            $relaince_form->store_name = $request->main['store_name'];
            $relaince_form->store_code = $request->main['store_code'];
            $relaince_form->forment = $request->main['forment'];
            $relaince_form->state = $request->main['state'];
            $relaince_form->carpet_area = $request->main['carpet_area'];
            $relaince_form->vendor_name = $request->main['vendor_name'];
            $relaince_form->month = $request->main['month'];
            $relaince_form->year = $request->main['year'];
            $relaince_form->save();

            $main_form_id = $relaince_form->id;
            // entry in first table
            RelainceServiceFirstForm::where('main_form_id', $main_form_id)->delete();
            foreach ($request->first['activity'] as $key => $activity) {
                $first_relaince_form = new RelainceServiceFirstForm();
                $first_relaince_form->main_form_id = $main_form_id;
                $first_relaince_form->activity = $request->first['activity'][$key];
                $first_relaince_form->date_of_service = $request->first['date_of_service'][$key];
                $first_relaince_form->payable_amount = $request->first['payable_amount'][$key];
                $first_relaince_form->recommended_deductions = $request->first['recommended_deductions'][$key];
                $first_relaince_form->recommended_payments = $request->first['recommended_payments'][$key];
                $first_relaince_form->remarks = $request->first['remarks'][$key];
                $first_relaince_form->save();
            }
            RelainceServiceSecondForm::where('main_form_id', $main_form_id)->delete();
            foreach ($request->second['detail_of_activity'] as $key => $row) {
                $second_relaince_form = new RelainceServiceSecondForm();
                $second_relaince_form->main_form_id = $main_form_id;
                $second_relaince_form->detail_of_activity = $request->second['detail_of_activity'][$key];
                $second_relaince_form->week_1 = $request->second['week_1'][$key];
                $second_relaince_form->week_2 = $request->second['week_2'][$key];
                $second_relaince_form->week_3 = $request->second['week_3'][$key];
                $second_relaince_form->week_4 = $request->second['week_4'][$key];
                $second_relaince_form->remarks = $request->second['remarks'][$key];
                $second_relaince_form->save();
            }

            RelainceServiceThirdForm::where('main_form_id', $main_form_id)->delete();
            $third_relaince_form = new RelainceServiceThirdForm();
            $third_relaince_form->main_form_id = $main_form_id;
            $third_relaince_form->last_observations_date = $request->third['last_observations_date'];
            $third_relaince_form->last_audit_suggestional = $request->third['last_audit_suggestional'];
            $third_relaince_form->earlier_audit_recommended = $request->third['earlier_audit_recommended'];
            $third_relaince_form->save();

            //fourth table entry
            RelainceServiceFourthForm::where('main_form_id', $main_form_id)->delete();
            foreach ($request->fourth['frequency'] as $key => $week) {
                $fourth_relaince_form = new RelainceServiceFourthForm();
                $fourth_relaince_form->main_form_id = $main_form_id;
                $fourth_relaince_form->pest_control_service = $request->fourth['pest_control_service'][$key];
                $fourth_relaince_form->frequency = $request->fourth['frequency'][$key];
                $fourth_relaince_form->date_of_service = $request->fourth['date_of_service'][$key];
                $fourth_relaince_form->service_type = $request->fourth['service_type'][$key];
                $fourth_relaince_form->dilution = $request->fourth['dilution'][$key];
                $fourth_relaince_form->application_method = $request->fourth['application_method'][$key];
                $fourth_relaince_form->pco_sign = $request->fourth['pco_sign'][$key];
                $fourth_relaince_form->remark = $request->fourth['remark'][$key];
                $fourth_relaince_form->save();
            }

            RelainceServiceFifthForm::where('main_form_id', $main_form_id)->delete();
            foreach ($request->fifth['vender_name'] as $key => $week) {
                $fifth_relaince_form = new RelainceServiceFifthForm();
                $fifth_relaince_form->main_form_id = $main_form_id;
                $fifth_relaince_form->vender_name = $request->fifth['vender_name'][$key];
                $fifth_relaince_form->employee_name = $request->fifth['employee_name'][$key];
                $fifth_relaince_form->mobile = $request->fifth['mobile'][$key];

                $fifth_relaince_form->week = $request->fifth['week'][$key];
                $fifth_relaince_form->vender_sign = $request->fifth['vender_sign'][$key];
                $fifth_relaince_form->store_manager_name = $request->fifth['store_manager_name'][$key];
                $fifth_relaince_form->store_manager_sign = $request->fifth['store_manager_sign'][$key];
                $fifth_relaince_form->save();
            }
            DB::commit();
            return response()->json([
                        'status' => 'success',
                        'message' => 'jobcart have been move please refresh page',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                            $e->getMessage());
        }
    }

    public function getActivityRelainceServiceForm($activity) {
        $helper = new Helper();
        $relaince_form = RelainceServiceForm::where(['activity_id' => $activity])->first();
        if (!$relaince_form) {
            return response()->json([
                        'status' => 'fail',
                        'message' => 'no record found',
            ]);
        }
        $data['main_form'] = [
            'store_name' => $relaince_form->store_name,
            'store_code' => $relaince_form->store_code,
            'forment' => $relaince_form->forment,
            'state' => $relaince_form->state,
            'carpet_area' => $relaince_form->carpet_area,
            'vendor_name' => $relaince_form->vendor_name,
            'month' => $relaince_form->month,
            'year' => $relaince_form->year,
        ];

        $saved_first_table = RelainceServiceFirstForm::where('main_form_id', $relaince_form->id)->get();
        foreach ($saved_first_table as $key => $row) {
            $data['first_element']['date_of_service'][] = $row->date_of_service;
            $data['first_element']['payable_amount'][] = $row->payable_amount;
            $data['first_element']['recommended_deductions'][] = $row->recommended_deductions;
            $data['first_element']['recommended_payments'][] = $row->recommended_payments;
            $data['first_element']['remarks'][] = $row->remarks;
        }
        $saved_second_table = RelainceServiceSecondForm::where('main_form_id', $relaince_form->id)->get();
        foreach ($saved_second_table as $key => $row) {
            $data['second_element']['detail_of_activity'][] = $row->detail_of_activity;
            $data['second_element']['week_1'][] = $row->week_1;
            $data['second_element']['week_2'][] = $row->week_2;
            $data['second_element']['week_3'][] = $row->week_3;
            $data['second_element']['week_4'][] = $row->week_4;
            $data['second_element']['remarks'][] = $row->remarks;
        }
        $saved_third_table = RelainceServiceThirdForm::where('main_form_id', $relaince_form->id)->get();
        foreach ($saved_third_table as $key => $row) {
            $data['third_element']['last_audit_suggestional'][] = $row->last_audit_suggestional;
            $data['third_element']['earlier_audit_recommended'][] = $row->earlier_audit_recommended;
            $data['third_element']['last_observations_date'][] = $row->last_observations_date;
        }
        $saved_fourth_table = RelainceServiceFourthForm::where('main_form_id', $relaince_form->id)->get();
        foreach ($saved_fourth_table as $key => $row) {
            $data['fourth_element']['pest_control_service'][] = $row->pest_control_service;
            $data['fourth_element']['frequency'][] = $row->frequency;
            $data['fourth_element']['date_of_service'][] = $row->date_of_service;
            $data['fourth_element']['service_type'][] = $row->service_type;
            $data['fourth_element']['dilution'][] = $row->dilution;
            $data['fourth_element']['application_method'][] = $row->application_method;
            $data['fourth_element']['pco_sign'][] = $row->pco_sign;
            $data['fourth_element']['pco_sign_image'][] = ($row->pco_sign) ? $helper->getGoogleDriveImage($row->pco_sign) : null;
            $data['fourth_element']['remark'][] = $row->remark;
        }

        $saved_fifth_table = RelainceServiceFifthForm::where('main_form_id', $relaince_form->id)->get();
        foreach ($saved_fifth_table as $key => $row) {
            $data['fifth_element']['vender_name'][] = $row->vender_name;
            $data['fifth_element']['week'][] = $row->week;
            $data['fifth_element']['employee_name'][] = $row->employee_name;
            $data['fifth_element']['mobile'][] = $row->mobile;

            $data['fifth_element']['vender_sign'][] = $row->vender_sign;
            $data['fifth_element']['vender_sign_image'][] = ($row->vender_sign) ? $helper->getGoogleDriveImage($row->vender_sign) : null;
            $data['fifth_element']['store_manager_name'][] = $row->store_manager_name;
            $data['fifth_element']['store_manager_sign'][] = $row->store_manager_sign;
            $data['fifth_element']['store_manager_sign_image'][] = ($row->store_manager_sign) ? $helper->getGoogleDriveImage($row->store_manager_sign) : null;
        }
        return response()->json([
                    'status' => 'success',
                    'message' => 'relaince for data',
                    'data' => $data,
        ]);
    }

}
