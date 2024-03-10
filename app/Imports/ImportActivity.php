<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;


class ImportActivity implements ToCollection, withStartRow
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

//       $date = ;
        foreach ($collection as $data)
        {

         
            $emp_id = DB::table('employees')->where('Name',$data[0])->value('id');

            $cust_id = DB::table('hvl_customer_master')
                ->join('hvl_customer_employees','hvl_customer_employees.customer_id','=','hvl_customer_master.id')
//                ->where('hvl_customer_master.customer_name',$data[3]) //customer name
                ->where('hvl_customer_employees.employee_id',$emp_id) // employee
                ->where('hvl_customer_master.customer_code',$data[4])
                ->value('hvl_customer_master.id');

//            $cust_id = DB::table('hvl_customer_employees')
//                ->where('employee_id',$emp_id)
//                ->value('customer_id');

                if (empty($cust_id))
                {
                   $new_cust = DB::table('hvl_customer_master')
                       ->where('hvl_customer_master.customer_code',$data[4])
                        ->value('id');
//                        ->whereId('customer_name',$data[3])

                   DB::table('hvl_customer_employees')
                        ->insert([
                            'customer_id' => $new_cust,
                            'employee_id' => $emp_id
                        ]);
                   $cust_id = $new_cust;
                }

            DB::table('hvl_activity_master')->insert([
                'employee_id' => $emp_id,
                'subject' => $data[1],
                'type' => DB::table('activitytype')->where('Name',$data[2])->value('id'),
                'customer_id' => $cust_id,
                'status' => DB::table('activitystatus')->where('Name',$data[5])->value('id'),
                //'master_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[6]))->format('Y-m-d'),
                'start_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[7]))->format('Y-m-d'),
                'end_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[8]))->format('Y-m-d'),
                'created_by' => $data[9],
                'frequency' =>  $data[10],
            ]);

            $cust_id = "";
        }
    }

}
