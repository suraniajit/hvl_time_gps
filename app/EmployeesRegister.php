<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class EmployeesRegister extends Model
{
    protected $table='employees_register';
    protected $fillable=[
        'employee_id',
        'start_time',
        'end_time',
        'log_date',
    ];
}
