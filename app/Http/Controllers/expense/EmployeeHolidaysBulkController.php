<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ExcelBulkUploadRequest;
use App\EmployeeHolidays;
use Auth;
use Carbon\Carbon;

class EmployeeHolidaysBulkController extends Controller {

    public function index($id = null) {
        $user = Auth::user();

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "holiday_index/", 'name' => "Holiday Bulk Upload"],
            ['name' => "holiday_index/", 'name' => "Holiday Bulk Upload"],
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $user = Auth::user();

        $employee_name = (new Controller)->getConditionDynamicNameTable('employees', 'id', $id, 'name');

        // getConditionDynamicNameTable($table_name, $where_condition, $where_value, $value) {


        return view('employee-master.holidaybulkupload.bulk_upload', [
            'pageConfigs' => $pageConfigs, 'employee_name' => $employee_name,
            'breadcrumbs' => $breadcrumbs, 'emp_id' => $id
        ]);
    }

    public function saveLeadManagementBulkUpload(ExcelBulkUploadRequest $request) {
        $empfrm_id = $request->emp_id;
        $line_no = 0;
        $flag = false;
        $existingLead = $this->getExsitingLead();
        $user = Auth::user();

        try {
            DB::beginTransaction();
            $ExcelArray = Excel::toArray(new Controller(), $request->file('excel_file'));
            $prepare_data = $this->setData($ExcelArray[0]);

            foreach ($prepare_data as $line_no => $row) {
//                $mail_id = $row['emp_id'];
//                $lead_occur_count = count(array_filter($existingLead, function ($a)use ($mail_id) {
//                            return $a == $mail_id;
//                        }));
                if ($row['action'] == 'ADD') {
//                    if ($lead_occur_count > 0) {
//                        throw new \ErrorException($row['email'] . ' employee already existing');
//                    }
                    EmployeeHolidays::create([
                        'emp_id' => $empfrm_id,
                        'holiday_type' => $row['holiday_type'],
                        'holiday_name' => $row['holiday_name'],
                        'holiday_date' => $row['holiday_date'],
                        'holiday_note' => $row['holiday_note'],
                    ]);
                } else if ($row['action'] == 'DELETE') {
                    if ($lead_occur_count == 1) {
                        $EmployeeHolidays = new EmployeeHolidays();
                        $EmployeeHolidays = $EmployeeHolidays->where('emp_id', $empfrm_id);
                        $EmployeeHolidays->delete();
                    } else if ($lead_occur_count < 1) {
                        throw new \ErrorException('Holiday not found => ' . $empfrm_id);
                    } else {
                        throw new \ErrorException($empfrm_id . "Holiday have no uniq please make it uniq first");
                    }
                } else if ($row['action'] == 'EDIT') {
                    if ($lead_occur_count == 1) {
                        $EmployeeHolidays = new EmployeeHolidays();
                        $EmployeeHolidays->empbulk = $empfrm_id;
                        $EmployeeHolidays->holiday_type = $row['holiday_type'];
                        $EmployeeHolidays->holiday_name = $row['holiday_name'];
                        $EmployeeHolidays->holiday_date = $row['holiday_date'];
                        $EmployeeHolidays->holiday_note = $row['holiday_note'];
                        $EmployeeHolidays->save();
                    } else if ($lead_occur_count < 1) {
                        throw new \ErrorException('Holiday Not Found => ' . $empfrm_id);
                    } else {
                        throw new \ErrorException($empfrm_id . " Holiday have no uniq please Make It uniq first");
                    }
                }
            }
            DB::commit();
//            return redirect()->route('emp')->with('success', 'Holiday Excel data has been uploaded successfully');
            redirect()->back()->with('success', 'Holiday Excel data has been uploaded successfully!');
            return redirect(route('emp.holidayshow', $empfrm_id));
        } catch (\Exception $e) {
            DB::rollBack();
            return self::index($request)->withErrors("Line No  " . ($line_no + 1) . " is " . $e->getMessage());
        }
    }

    public function getExsitingLead() {
        $leade_Master = EmployeeHolidays::pluck("emp_id", "id")->toArray();
        return $leade_Master;
    }

    public function setData($data) {

        foreach ($data as $key => $row) {
            if ($key == 0) {
                continue;
            }
            if ($row[1] == null || (!isset($row[1]))) {
                continue;
            }
            if (strtoupper($row[0]) == "DELETE") {

                if ($row[0] == null || (!isset($row[1]) )) {
                    throw new \ErrorException('Please provide in all excel data');
                }
                $response[] = [
                    'action' => strtoupper($row[0]),
                    'email' => $row[1],
                ];
            } else {
                if (
                        $row[0] == null ||
                        (!isset($row[1])) ||
                        (!isset($row[2])) ||
                        (!isset($row[3]))
                ) {
                    throw new \ErrorException('Please provide in all excel data');
                }
                $response[] = [
                    'action' => trim(strtoupper($row[0])),
                    'holiday_type' => $row[1],
                    'holiday_name' => $row[2],
                    'holiday_date' => Carbon::parse($row[3])->format('Y-m-d'),
                    'holiday_note' => $row[4],
                ];
            }
        }
        return $response;
    }

    public function transformDate($value, $format = 'Y-m-d') {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

}
