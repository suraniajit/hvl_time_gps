<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class EmployeesLocationHistory extends Model
{
    protected $table='employees_location_history';
    protected $fillable=[
        'employee_id',
        'location_time',
        'location_date',
        'lat',
        'lang'
    ];
}
