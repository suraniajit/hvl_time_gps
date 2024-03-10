<?php

namespace App\Exports;

use App\Models\hvl\LeadMaster;
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

class LeadMasterExport implements FromCollection,WithHeadings,WithMapping,WithStyles,WithColumnFormatting //ShouldAutoSize,
{
    
    protected $param;
    function __construct($param) {
        $this->param = $param;
    }
    

    public function headings():array{
        return [
                'Email Id',
                'Company Type',
                'Company Name',
                'First Name',
                'Phone',
                'Employee Email',
                'Owner Email',
                'Creation Date(MM/DD/YYYY)',
                'Follow Up Date(MM/DD/YYYY)',
                'status',
                'Geographical Segment',
                'Lead Source',
                'Industry',
                'Address',
                'Revenue',
                'Comment 1',
                'Comment 2',
                'Comment 3',
                'Is Active',
                'Size',
                'Employee name',
                'Owner name',
                'Email 2',
                'Proposal Date',
        ];
    } 
    public function map($lead_master): array{
        $lead_master_model = new LeadMaster();
        return [
                $lead_master->email,
                $lead_master->company_type,
                $lead_master->company_name,
                $lead_master->first_name,
                $lead_master->phone,
                $lead_master->employee_email,
                $lead_master->owner_email,
                // $lead_master->create_date,
                // $lead_master->follow_date,
                
                Date::stringToExcel($lead_master->create_date),
                Date::stringToExcel($lead_master->follow_date),
                
                $lead_master->lead_status,
                $lead_master->geographical_segment,
                $lead_master->lead_source,
                $lead_master->industry_name,
                $lead_master->lead_address,
                $lead_master->lead_revenue,
                $lead_master->lead_comment_1,
                $lead_master->lead_comment_2,
                $lead_master->lead_comment_3,
                $lead_master_model->getIsActiveText($lead_master->is_active),
                $lead_master_model->getLeadSizeText($lead_master->lead_size),
                $lead_master->employee_name,
                $lead_master->owner_name,
                $lead_master->email_2,
                
        ];
    }
   
    public function columnFormats(): array
    {
       return [
            'H' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
            'I' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
        ];
        
    }

    public function collection()
    {
        $query =  $this->getQuery();
        return $query
                // ->select(array_values($helper->getLeadMasterFiled()))
                    
                 ->select([
                            'hvl_lead_master.email as email',
                            'CompanyType.Name as company_type',
                            'hvl_lead_master.last_company_name as company_name',
                            'hvl_lead_master.f_name as first_name',
                            'hvl_lead_master.phone as phone',
                            'emp.email as employee_email',
                            'owner.email as owner_email',
                            // 'hvl_lead_master.create_date as create_date',
                            DB::raw('DATE_FORMAT(hvl_lead_master.create_date,"%d-%m-%Y") as create_date'),
                            DB::raw('DATE_FORMAT(hvl_lead_master.follow_date,"%d-%m-%Y") as follow_date'),
                            'LeadStatus.Name as lead_status',
                            'Rating.Name as geographical_segment',
                            'LeadSource.Name as lead_source',
                            'LeadSource.Name as lead_source',
                            'Industry.Name as industry_name',
                            'hvl_lead_master.address as lead_address',
                            'hvl_lead_master.revenue as lead_revenue',
                            'hvl_lead_master.comment as lead_comment_1',
                            'hvl_lead_master.comment_2 as lead_comment_2',
                            'hvl_lead_master.comment_3 as lead_comment_3',
                            'hvl_lead_master.is_active as is_active',
                            'hvl_lead_master.lead_size as lead_size',
                            'hvl_lead_master.email_2 as email_2',
                            'emp.Name as employee_name',
                            'owner.Name as owner_name'
                        ])
                ->get();           
    }
    private function getQuery(){
        $search_start_date     =   (isset($this->param['search_start_date']))?$this->param['search_start_date']:null;
        $search_end_date       =  (isset($this->param['search_end_date']))?$this->param['search_end_date']:null; 
        $search_status         =   ( (isset($this->param['search_status'])) && ($this->param['search_status'] != null)  )?explode(",",$this->param['search_status']):null;
        $em_id = Auth::User()->id;
        $lead_master = new LeadMaster();
        if(!isset($search_status)){
            $search_status=[];
        }
        $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
        $leadDetails = DB::table('hvl_lead_master')
            ->leftJoin('employees AS emp', 'emp.id', '=', 'hvl_lead_master.employee_id')
            ->leftJoin('employees AS owner', 'owner.id', '=', 'hvl_lead_master.owner')
            ->leftJoin('CompanyType', 'CompanyType.id', '=', 'hvl_lead_master.company_type')
            ->leftJoin('LeadStatus', 'LeadStatus.id', '=', 'hvl_lead_master.status')
            ->leftJoin('LeadSource', 'LeadSource.id', '=', 'hvl_lead_master.lead_source')
            ->leftJoin('Rating', 'Rating.id', '=', 'hvl_lead_master.rating')
            ->leftJoin('Industry', 'Industry.id', '=', 'hvl_lead_master.industry')
            ->where('hvl_lead_master.flag', '=', 0);
            if(isset($search_start_date) && isset($search_end_date)){
                $leadDetails = $leadDetails->whereBetween('hvl_lead_master.create_date', [$search_start_date, $search_end_date]);
            }
            if(isset($search_status) && (!empty($search_status))){
                $leadDetails = $leadDetails->whereIn('hvl_lead_master.status', $search_status);
            }
            if (!($em_id == 1 or $em_id == 122 or $em_id == 213)) {
                $leadDetails = $leadDetails->where('hvl_lead_master.employee_id', '=', $emp->id);
            }
            if( isset($this->param['data_limit']) && $this->param['data_limit'] == 1){
                $leadDetails = $leadDetails->take(10000);
            }   
            $leadDetails = $leadDetails->orderBy('hvl_lead_master.id', 'DESC')
                ->orderBy('hvl_lead_master.id', 'DESC');
        return $leadDetails;
            
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
}
