<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use App\Models\hvl\CustomerMaster;
use App\Models\hvl\ActivityServiceReport;

class ActivityMasterExport implements FromCollection,WithHeadings,WithMapping,WithColumnFormatting,WithStyles    //ShouldAutoSize  
{
    
    protected $activity_jobcard = null;
    protected $activity_audit_report = null;
    protected $activity_service_report =null;
    protected $param;
    function __construct($param) {
        $this->param = $param;
        $this->activity_jobcard = $this->getJobcardUpdateDate();
        $this->activity_audit_report = $this->getAuditReport();
        $this->activity_service_report = $this->getActivityServiceReport();   
    }

    public function headings():array{
        $heading_data = [];
        $heading_data[] =   'Transaction Id';
        $heading_data[] =   'Customer Name';
        $heading_data[] =   'Customer Code';
        $heading_data[] =   'Subject';
        $heading_data[] =   'Branch';
        $heading_data[] =   'Start Date';
        $heading_data[] =   'End Date';
        $heading_data[] =    'Status';
        $heading_data[] =   'Frequency';
        $heading_data[] =   'Completion Date';
        $heading_data[] =   'Download report';
        $heading_data[] =   'Remark';
        // $heading_data[] =   'Download report';
        $heading_data[] =   'Per Service Value';
        $heading_data[] =   'Job Update';
        // $heading_data[] =   'Audit Update';
        $heading_data[] =   'Operator';
        $heading_data[] =   'Operation Executive';
        
    return $heading_data;
    } 
    public function map($activity_master): array{
            $customactivityr_model = new CustomerMaster();
            $excel_data =[];
            $excel_data []= $activity_master->transaction_id;
            $excel_data []= $activity_master->customer_name;
            $excel_data []= $activity_master->customer_code;
            $excel_data []= $activity_master->subject;
            $excel_data []= $activity_master->branch;
            $excel_data []= Date::stringToExcel($activity_master->start_date);
            $excel_data []= Date::stringToExcel($activity_master->end_date);
            $excel_data []= $activity_master->status;
            $excel_data []= $activity_master->frequency;
            $excel_data []= Date::stringToExcel($activity_master->completion_date);
            $excel_data []= (isset($this->activity_service_report[$activity_master->transaction_id]))?'Report':'';
            $excel_data []= $activity_master->remark;
            $excel_data []= $activity_master->per_service_value;
            $date_data = '';
            if(isset($this->activity_service_report[$activity_master->transaction_id])){
                $date_data = $this->activity_service_report[$activity_master->transaction_id];
            }
            else if(isset($this->activity_jobcard[$activity_master->transaction_id])){
                $date_data = $this->activity_jobcard[$activity_master->transaction_id];
            }
            $excel_data [] = $date_data;
            // $excel_data [] = (isset($this->activity_audit_report[$activity_master->transaction_id]))?$this->activity_audit_report[$activity_master->transaction_id]:'';
            $excel_data []= $activity_master->operator;
            $excel_data []= $activity_master->operation_executive;
            return $excel_data;
    }
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
            'G' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
            'J' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
        ];
    }
    public function collection()
    {   
        $query =  $this->getQuery();
        return $query       
                 ->select([
                    'hvl_activity_master.id as transaction_id',
                    'hvl_customer_master.customer_name as customer_name',
                    'hvl_customer_master.customer_code as customer_code',
                    'hvl_activity_master.subject  as subject',
                    'Branch.Name  as branch',
                    DB::raw('DATE_FORMAT(hvl_activity_master.start_date,"%d-%m-%Y") as start_date'),
                    DB::raw('DATE_FORMAT(hvl_activity_master.end_date,"%d-%m-%Y") as end_date'),
                    'activitystatus.Name as status',
                    'hvl_activity_master.frequency as frequency',
                    DB::raw('DATE_FORMAT(hvl_activity_master.complete_date,"%d-%m-%Y") as completion_date'),
                    'hvl_activity_master.remark as remark',
                    'hvl_activity_master.services_value as per_service_value',
                    'hvl_customer_master.operator as operator',
                    'hvl_customer_master.operation_executive as operation_executive'
                    ])->get();
                           
    }
    private function getQuery(){
            $search_branch          = $this->param['branch'];
            $search_customer_ids        = ( (isset($this->param['customers_id'])) && ($this->param['customers_id'] != null)  )?explode(",",$this->param['customers_id']):null;
            $search_status_id       = ( (isset($this->param['search_status'])) && ($this->param['search_status'] != null)  )?explode(",",$this->param['search_status']):null;
            $search_start_date      = (isset($this->param['search_start_date']))?$this->param['search_start_date']:null;
            $search_end_date        = (isset($this->param['search_end_date']))?$this->param['search_end_date']:null; 
            $is_today               = $this->param["is_today"]; 
            $em_id                  = Auth::User()->id;
            $emp                    = DB::table('employees')->where('user_id', '=', $em_id)->first();
            $today_date             = Carbon::today()->format('Y-m-d');
            $customerDetails        = "";
            $db_customersIds = [];
            
            $activity_details = DB::table('hvl_activity_master')
                    ->select('hvl_activity_master.*', 'hvl_customer_master.branch_name')
                    ->join('hvl_customer_master', 'hvl_customer_master.id', '=', 'hvl_activity_master.customer_id')
                    ->join('Branch', 'hvl_customer_master.branch_name', '=', 'Branch.id')
                    ->join('activitystatus', 'hvl_activity_master.status', '=', 'activitystatus.id');
                    if (!($em_id == 1 or $em_id == 122 or $em_id == 184)) {
                        if ($emp) {
                            $activity_details = $activity_details
                                ->join('hvl_customer_employees', 'hvl_customer_employees.customer_id', '=', 'hvl_customer_master.id')
                                ->where('hvl_customer_employees.employee_id', $emp->id);
                        }else{
                            $customers_admin = CustomersAdmin::where('user_id', Auth::User()->id)->first();
                            if ($customers_admin) {
                                $db_customersIds = json_decode($customers_admin->customers_id, true);
                            } 
                            $activity_details = $activity_details->whereIn('hvl_activity_master.customer_id', $db_customersIds);
                        }
                    }
                    if($is_today!=0) {
                        // echo 44; die;
                        $activity_details = $activity_details->where('hvl_activity_master.start_date', $today_date);
                    } else {
                        // echo 55; die;
                        if ($search_start_date != null && $search_end_date != null) {
                            $activity_details = $activity_details->whereBetween('hvl_activity_master.start_date', [$search_start_date, $search_end_date]);
                        }
                    }
                    if ($search_status_id != null && (!empty($search_status_id))) {
                        $activity_details = $activity_details->whereIn('hvl_activity_master.status', $search_status_id);
                    }
                    if ($search_customer_ids != null && (!empty($search_customer_ids))) {
                        $activity_details = $activity_details->whereIn('hvl_activity_master.customer_id', $search_customer_ids);
                    }
                    if ($search_branch != null) {
                        $activity_details = $activity_details->where('hvl_customer_master.branch_name', $search_branch);
                    }
                    if( isset($this->param['data_limit']) && $this->param['data_limit'] == 1){
                        $activity_details = $activity_details->take(10000);
                    }  
                    $activity_details = $activity_details->GroupBy('hvl_activity_master.id');
                    // $activity_details = $activity_details->orderBy('hvl_activity_master.id', 'A');
                    
                    // echo "<pre>";
                    // print_r($activity_details->toSql()); 
                    // die;
        return $activity_details;
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }
       
      public function getActivityServiceReport(){
            return ActivityServiceReport::pluck('created_at', 'activity_id');
      }
    public function getJobcardUpdateDate(){
        return  DB::table('hvl_job_cards')
            ->groupBy('hvl_job_cards.activity_id')
            ->orderBy('id', 'DESC')
            ->pluck('hvl_job_cards.added', 'hvl_job_cards.activity_id')
            ->toArray();
    }
    public function getAuditReport(){        
    return DB::table('hvl_audit_reports')
        ->groupBy('hvl_audit_reports.activity_id')
        ->orderBy('id', 'DESC')
        ->pluck('hvl_audit_reports.added', 'hvl_audit_reports.activity_id')
        ->toArray();
    }
}
