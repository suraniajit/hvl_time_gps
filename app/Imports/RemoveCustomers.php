<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Models\hvl\CustomerMaster;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class RemoveCustomers implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //

        foreach ($collection as $data)
        {
            
            $cust_id =  CustomerMaster::where('customer_code',$data[1])->value('id');


            DB::table('hvl_customer_employees')
                ->where('customer_id',$cust_id)
                ->delete();
            DB::table('hvl_activity_master')
                ->where('customer_id',$cust_id)
                ->delete();
            DB::table('hvl_customer_master')
                ->whereId($cust_id)
                ->delete();
        }

    }
}
