<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Models\hvl\CustomerMaster;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportCustomers implements ToCollection, withStartRow
{

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //



        foreach ($collection as $data)
        {
//            dd($data);

            // for inserting in custoemr master table
//                $billdata =  DB::table('common_states')->where('state_name',$data[4])->value('id');
//                $shippdata =  DB::table('common_states')->where('state_name',$data[13])->value('id');
//                $branchdata =  DB::table('Branch')->where('Name',$data[18])->value('id');
//
//                if (!empty($billdata))
//                {
//                    $bill_state = $billdata;
//                }
//                else
//                {
//                    $bill_state = 0;
//                }
//                if (!empty($shippdata))
//                {
//                    $ship_state = $shippdata;
//                }
//                else
//                {
//                    $ship_state = 0;
//                }
//                if (!empty($branchdata))
//                {
//                    $branch_id = $branchdata;
//                }
//                else
//                {
//                    $branch_id = 0;
//                }
//            if (!empty($data[19])) {
//                $start_date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[19]))->format('Y-m-d');
//            }
//            else
//            {
//                $start_date = 0000-00-00;
//            }
//            if (!empty($data[20])) {
//                $end_date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[20]))->format('Y-m-d');
//            }
//            else
//            {
//                $end_date = 0000-00-00;
//            }
//          $cust_id =  CustomerMaster::insertGetId([
//                'customer_code' => $data[0],
//                'customer_name' => $data[1],
//                'customer_alias' => $data[2],
//                'billing_address' => $data[3],
//                'billing_state' =>  $bill_state,
//                'contact_person' => $data[5],
//                'contact_person_phone' => $data[6],
//                'billing_email' => $data[7],
//                'billing_mobile' => $data[8],
//                'sales_person' => $data[9],
//                'status' => $data[10],
//                'create_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[11]))->format('Y-m-d'),
//                'shipping_address' => $data[12],
//                'shipping_state' =>  $ship_state,
////                'shipping_city' => $data[5],
//                'credit_limit' => $data[14],
//                'gstin' => $data[15],
//                'gst_reges_type' => $data[16],
//                'payment_mode' => $data[17],
//                'branch_name' =>   $branch_id,
//                'con_start_date' => $start_date,
//                'con_end_date' => $end_date,
//                'cust_value' => $data[21],
//            ]);



            // for inserting in customer employee table

            $cust_id = DB::table('hvl_customer_master')->where('customer_code',$data[0])->value('id');
          DB::table('hvl_customer_employees')
              ->insert([
                  'customer_id' => $cust_id,
                  'employee_id' => DB::table('employees')->where('Name',$data[1])->value('id')
              ]);
        }
    }
}
