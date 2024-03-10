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
 use App\Models\hvl\ActivityServiceReport;

class ExpenseReportExport implements FromCollection,WithHeadings,WithMapping,WithColumnFormatting,WithStyles    //ShouldAutoSize  
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
         $heading_data[] =   'Employee Name';
        $heading_data[] =   'Total Claim Amount';
        $heading_data[] =   'Total Settlement Amount';
        $heading_data[] =   'Total Reject Amount';
      
        
    return $heading_data;
    } 
    public function map($activity_master): array{
            //$customactivityr_model = new CustomerMaster();
            $excel_data=[];
            $excel_data[]= app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $activity_master->is_user, 'name');
            $excel_data[]= DB::table('api_expenses')->where('api_expenses.is_user', '=', $activity_master->is_user)
                            ->where('api_expenses.is_save', '=', '1')
                    ->whereIn('is_process', [3, 12])
                    ->whereIn('payment_status_id', [4])
                    ->sum('api_expenses.claim_amount');
            $excel_data[]= DB::table('api_expenses')
                            ->where('api_expenses.is_user', '=', $activity_master->is_user)
                            ->where('api_expenses.is_save', '=', '1')
                            ->whereIn('is_process', [3, 12])
                    ->whereIn('payment_status_id', [4])
                    ->sum('api_expenses.settlement_amount');
            $excel_data[] =DB::table('api_expenses')
                                    ->where('api_expenses.is_user', '=', $activity_master->is_user)
                                    ->where('api_expenses.is_save', '=', '1')
                    ->whereIn('is_process', [3, 12])
                    ->whereIn('payment_status_id', [4])
                                    ->sum('api_expenses.reject_amount');
            return $excel_data;
    }
    public function columnFormats(): array
    {
        return [
//            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
//            'G' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
//            'J' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
        ];
    }
    public function collection()
    {   
     $query =  $this->getQuery();
        return $query       
                 ->select([
                     'api_expenses.*',
                    ])->get();
                           
    }
    private function getQuery(){
            
      $activity_details = DB::table('api_expenses')
                   ->select('api_expenses.*')
                    ->groupBy('api_expenses.is_user')
                    ->whereIn('is_process', [3, 12])
                    ->whereIn('payment_status_id', [4]);
      
        $activity_details = $activity_details->GroupBy('api_expenses.is_user');
                    $activity_details = $activity_details->orderBy('api_expenses.account_action_date', 'DESC');
        
        
           
                    
//                     echo "<pre>";
//                     print_r($activity_details->toSql()); 
//                     die;
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
