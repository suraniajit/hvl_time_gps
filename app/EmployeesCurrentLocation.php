<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class EmployeesCurrentLocation extends Model
{
    protected $table='employees_current_position';
    protected $fillable=[
        'employee_id',
        'location_time',
        'location_date',
        'lat',
        'lang'
    ];
}
