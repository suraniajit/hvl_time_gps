<?php
namespace App\Exports;

use Illuminate\Support\Collection;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class ExportActivity implements FromCollection
{
    use Exportable;
    public function collection()
    {
        $act_details = DB::table('hvl_activity_master')
            ->join('employees','employees.id','=','hvl_activity_master.employee_id')
            ->join('activitytype','activitytype.id','=','hvl_activity_master.type')
            ->join('activitystatus','activitystatus.id','=','hvl_activity_master.status')

            ->select(
                'employees.Name as emp_name',
                'hvl_activity_master.employee_id',
                'hvl_activity_master.customer_id',
                'hvl_activity_master.master_date',
                'hvl_activity_master.start_date',
                'hvl_activity_master.end_date',
                'hvl_activity_master.frequency',
                'activitytype.Name as type',
                'activitystatus.Name as status',
                'hvl_activity_master.created_by',
                'hvl_activity_master.complete_date',
                'hvl_activity_master.subject')
                ->get();

        return $act_details;
    }
}
