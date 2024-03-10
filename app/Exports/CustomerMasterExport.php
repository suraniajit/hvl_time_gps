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
use DateTime;


class CustomerMasterExport implements FromCollection,WithHeadings,WithMapping,WithColumnFormatting,WithStyles  //ShouldAutoSize    
{
    
    protected $param;
    protected $comman_state;
    protected $comman_city;
    
    function __construct($param) {
        $this->param = $param;
        $this->comman_state = $this->getStates();
        $this->comman_city = $this->getCommonCity();
        
    }

    public function headings():array{
        $heading_data = [];
        if(!Auth::User()->hasRole('customers_admin')){
            $heading_data[] =   'Customer Code';
        }
        $heading_data[] =   'Customer Name';
        $heading_data[] =   'Customer Alias';
        $heading_data[] =   'Billing Address';
        $heading_data[] =   'Billing State';
        $heading_data[] =   'Billing City';
        $heading_data[] =   'Billing Pin Code';
        $heading_data[] =   'Contact Person';
        $heading_data[] =    'Contact Phone';
        $heading_data[] =   'Billing Mail';
        $heading_data[] =   'Billing Phone';
        $heading_data[] =   'Operator';
        $heading_data[] =   'Operation Executive';
        if(!Auth::User()->hasRole('customers_admin')){
            $heading_data[] =   'Sales Person';
        }   
        $heading_data[] =   'Reference';
        $heading_data[] =   'Creation Date (MM/DD/YYYY)';
        $heading_data[] =   'Shipping Address';
        $heading_data[] =   'Shipping State';
        $heading_data[] =   'Shipping City';
        $heading_data[] =   'Shipping Pincode';
        $heading_data[] =   'Credit Limite';
        $heading_data[] =   'Have GST';
        $heading_data[] =   'GSTIN';
        $heading_data[] =   'Branch';
        $heading_data[] =    'Payment Mode';
        $heading_data[] =   'Contract Start Date(MM/DD/YYYY)';
        $heading_data[] =   'Contract End Date(MM/DD/YYYY)';
        if(!Auth::User()->hasRole(['customers_admin','Operators'])){
            $heading_data[] =   'Value';
        }
        $heading_data[] =   'Status';
        $heading_data[] =   ' is Contract Expired';
        $heading_data[] =   'Inactive Date';
        
        
    return $heading_data;
    } 
    public function map($customer_master): array{
        
           
            $customer_master_model = new CustomerMaster();
            $excel_data =[];
            if(!Auth::User()->hasRole('customers_admin')){
                $excel_data []= $customer_master->customer_code;
            }
            $excel_data []= $customer_master->customer_name;
            $excel_data []= $customer_master->customer_alias;
            $excel_data []= $customer_master->billing_address;
            $excel_data []= (isset($this->comman_state[$customer_master->billing_state]))?$this->comman_state[$customer_master->billing_state]:'';
            $excel_data []= (isset($this->comman_city[$customer_master->billing_city]))?$this->comman_city[$customer_master->billing_city]:'';
            $excel_data []= $customer_master->billing_pincode;
            $excel_data []= $customer_master->contact_person;
            $excel_data []= $customer_master->contact_phone;
            $excel_data []= $customer_master->billing_mail;
            $excel_data []= $customer_master->billing_phone;
            $excel_data []= $customer_master->operator;
            $excel_data []= $customer_master->operation_executive;
            if(!Auth::User()->hasRole('customers_admin')){
                $excel_data []= $customer_master->sales_person;
            }
            $excel_data []= $customer_master->reference;
            $excel_data []= Date::stringToExcel($customer_master->creation_date);
            $excel_data []= $customer_master->shipping_address;
            $excel_data []= (isset($this->comman_state[$customer_master->shipping_state]))?$this->comman_state[$customer_master->shipping_state]:'';
            $excel_data []= (isset($this->comman_city[$customer_master->shipping_city]))?$this->comman_city[$customer_master->shipping_city]:'';
            $excel_data []= $customer_master->shipping_pincode;
            $excel_data []= $customer_master->credit_limite;
            $excel_data []= $customer_master->gst_reges_type;
            $excel_data []= $customer_master->GSTIN;
            $excel_data []= $customer_master->branch_name;
            $excel_data []= $customer_master->payment_mode;
            $excel_data []= Date::stringToExcel($customer_master->con_start_date);
            $excel_data []= Date::stringToExcel($customer_master->con_end_date);
            if(!Auth::User()->hasRole(['customers_admin','Operators'])){
                $excel_data []= $customer_master->cust_value;
            }
            $excel_data []= $customer_master_model->getStatus($customer_master->status);
            
            $con_end_date =date_create($customer_master->con_end_date);
            $diff=date_diff($con_end_date,new DateTime());
            $con_exp_time = $diff->format("%R%a");
            $excel_data []= ($con_exp_time > 0)?'YES':'NO';
            $excel_data []= Date::stringToExcel($customer_master->inactive_date);
            
            return $excel_data;
    }
    public function columnFormats(): array
    {
        return [
            'P' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
            'Z' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
            'AA' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
            'AE'=>NumberFormat::FORMAT_DATE_YYYYMMDD2,
        ];
    }
    public function collection()
    {       
        $query =  $this->getQuery();
       
        return $query->select([
                    'hvl_customer_master.customer_code as customer_code',
                    'hvl_customer_master.customer_name as customer_name',
                    'hvl_customer_master.customer_alias as customer_alias',
                    'hvl_customer_master.billing_address as billing_address',
                    'hvl_customer_master.billing_state as billing_state',
                    'hvl_customer_master.billing_city as billing_city',
                    'hvl_customer_master.billing_pincode as billing_pincode',
                    'hvl_customer_master.contact_person as contact_person',
                    'hvl_customer_master.contact_person_phone as contact_phone',
                    'hvl_customer_master.billing_email as billing_mail',
                    'hvl_customer_master.billing_mobile as billing_phone',
                    'hvl_customer_master.operator as operator',
                    'hvl_customer_master.operation_executive as operation_executive',
                    'hvl_customer_master.sales_person as sales_person',
                    'hvl_customer_master.reference as reference',
                    DB::raw('DATE_FORMAT(hvl_customer_master.create_date,"%d-%m-%Y") as creation_date'),
                    'hvl_customer_master.shipping_address as shipping_address',
                    'hvl_customer_master.shipping_state as shipping_state',
                    'hvl_customer_master.shipping_city as shipping_city',
                    'hvl_customer_master.shipping_pincode as shipping_pincode',
                    'hvl_customer_master.credit_limit as credit_limite',
                    'hvl_customer_master.gst_reges_type as gst_reges_type', 
                    'hvl_customer_master.gstin as GSTIN',
                    'Branch.Name as branch_name',
                    'hvl_customer_master.payment_mode as payment_mode',
                    'hvl_customer_master.payment_mode as payment_mode',
                    DB::raw('DATE_FORMAT(hvl_customer_master.con_start_date,"%d-%m-%Y") as con_start_date'),
                    DB::raw('DATE_FORMAT(hvl_customer_master.con_end_date,"%d-%m-%Y") as con_end_date'),
                    'hvl_customer_master.cust_value as cust_value',
                    'hvl_customer_master.status as status',
                    DB::raw('DATE_FORMAT(hvl_customer_master.inactive_date,"%d-%m-%Y") as inactive_date')
                    
                    
                 ])->get();
                 
                           
    }
    
    private function getQuery(){
            $search_branch          = $this->param['branch'];
            $search_customer        = ( (isset($this->param['customers_id'])) && ($this->param['customers_id'] != null)  )?explode(",",$this->param['customers_id']):null;
            $search_start_date      = (isset($this->param['search_start_date']))?$this->param['search_start_date']:null;
            $search_end_date        = (isset($this->param['search_end_date']))?$this->param['search_end_date']:null; 
            $em_id                  = Auth::User()->id;
            $emp                    = DB::table('employees')->where('user_id', '=', $em_id)->first();
            $customerDetails        = "";
            $db_customersIds = [];
            
            $customerDetails = DB::table('hvl_customer_master')
                ->join('Branch', 'Branch.id', '=', 'hvl_customer_master.branch_name');
                // ->join('common_states AS ship_state', 'ship_state.id', '=', 'hvl_customer_master.shipping_state')
                // ->join('common_states AS bill_state', 'bill_state.id', '=', 'hvl_customer_master.billing_state')
                // ->join('common_cities AS ship_city', 'ship_city.state_id', '=', 'ship_state.id')
                // ->join('common_cities AS bill_city', 'bill_city.state_id', '=', 'bill_state.id');
            
            if (!($em_id == 1 or $em_id == 122)) {
                if ($emp) {
                    $customerDetails = $customerDetails->join('hvl_customer_employees', 'hvl_customer_master.id', '=', 'hvl_customer_employees.customer_id');
                    $customerDetails = $customerDetails->where('hvl_customer_employees.employee_id', $emp->id);
                }else{
                    $customers_admin = CustomersAdmin::where('user_id', Auth::User()->id)->first();
                    if ($customers_admin) {
                        $db_customersIds = json_decode($customers_admin->customers_id, true);
                    }
                    $customerDetails = $customerDetails->whereIn('hvl_customer_master.id', $db_customersIds);
                }
            }
            if(isset($search_start_date) && isset( $search_end_date)){
                $customerDetails =$customerDetails->whereBetween('create_date', [$search_start_date, $search_end_date]);
            }
            if(isset($search_branch) &&  $search_branch != null){
            
                $customerDetails = $customerDetails->where('hvl_customer_master.branch_name', $search_branch);
            }
            if(isset($search_customer) && !(empty($search_customer)) ){
                $customerDetails = $customerDetails->whereIn('hvl_customer_master.id',$search_customer);            
            }  
            if( isset($this->param['data_limit']) && $this->param['data_limit'] == 1){
                $customerDetails = $customerDetails->take(10000);
            }   
            $customerDetails = $customerDetails->groupBy('hvl_customer_master.id');
            $customerDetails = $customerDetails->orderBy('hvl_customer_master.id', 'DESC');
            
        return $customerDetails;
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
    private function getStates(){
        if(!isset($this->states)){
            $this->states = DB::table('common_states')->where('country_id', '=', 1)->pluck('id','state_name')->toArray();
        }
        return array_change_key_case(array_flip($this->states),CASE_UPPER);
    }
    private function getCommonCity(){
         if(!isset($this->cities)){
            $this->cities = DB::table('common_cities')->pluck('id','Name')->toArray();
         }
        return array_change_key_case(array_flip($this->cities),CASE_UPPER);
        
    }
}
