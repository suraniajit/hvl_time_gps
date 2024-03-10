<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Carbon;
use App\Models\hvl\LeadMaster;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;

class ImportLeads implements ToCollection, withStartRow
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

            if (!empty($data[5])) {
                $follow = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[5]))->format('Y-m-d');
            }
            else
            {
                $follow = 0000-00-00;
            }

            LeadMaster::create([
                'company_type' =>  DB::table('CompanyType')->where('Name',$data[0])->value('id'),
                'last_company_name' => $data[1],
                'f_name' => $data[2],
                'email' => $data[3],
                'employee_id' => DB::table('employees')->where('Name',$data[14])->value('id'),
                'owner' => DB::table('employees')->where('Name',$data[4])->value('id'),
                'follow_date' => $follow,
                'create_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[6]))->format('Y-m-d'),
                'status' => DB::table('LeadStatus')->where('Name',$data[7])->value('id'),
                'rating' =>  DB::table('Rating')->where('Name',$data[8])->value('id'),
                'lead_source' =>  DB::table('LeadSource')->where('Name',$data[9])->value('id'),
                'industry' =>  DB::table('Industry')->where('Name',$data[10])->value('id'),
                'phone' => $data[11],
                'address' => $data[12],
                'comment' => $data[13],
                'is_active' => 0,

            ]);

        }
    }
}
