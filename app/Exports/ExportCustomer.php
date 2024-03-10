<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use App\Models\hvl\CustomerMaster;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCustomer implements FromCollection, WithHeadings
{
    use Exportable;
    public function collection()
    {
        $customer_details = DB::table('hvl_customer_master')
            ->join('Branch','Branch.id','=','hvl_customer_master.branch_name')
            ->join('common_states AS ship_state', 'ship_state.id', '=', 'hvl_customer_master.shipping_state')
            ->join('common_states AS bill_state', 'bill_state.id', '=', 'hvl_customer_master.billing_state')
            ->select(
                'hvl_customer_master.customer_code',
                'hvl_customer_master.customer_name',
                'hvl_customer_master.customer_alias',
                'hvl_customer_master.billing_address',
                'bill_state.state_name as billing_state',
                'hvl_customer_master.contact_person',
                'hvl_customer_master.contact_person_phone',
                'hvl_customer_master.billing_email',
                'hvl_customer_master.billing_mobile',
                'hvl_customer_master.sales_person',
                'hvl_customer_master.status',
                'hvl_customer_master.create_date',
                'hvl_customer_master.shipping_address',
                'ship_state.state_name as shipping_state',
                'hvl_customer_master.credit_limit',
                'hvl_customer_master.gstin',
                'hvl_customer_master.gst_reges_type',
                'hvl_customer_master.payment_mode',
                'Branch.Name',
                'hvl_customer_master.con_start_date',
                'hvl_customer_master.con_end_date',
                'hvl_customer_master.reference',
                'hvl_customer_master.cust_value')
            ->get();

        return $customer_details;
    }
    public function headings(): array
    {
        return [
            'Customer Code',
            'Customer Name',
            'Customer Alias Name',
            'Billing Address',
            'Billing State',
            'Contact Person',
            'Contact Person No',
            'Billing Mail',
            'Billing Phone',
            'Sales Person',
            'Status',
            'Creation Date',
            'Shipping Address',
            'Shipping State',
            'Credit Limit',
            'GSTIN',
            'GST Registered',
            'Payment Mode',
            'Branch Name',
            'Contract Start Date',
            'Contract End Date',
            'Reference',
            'Value',

        ];
    }
}
