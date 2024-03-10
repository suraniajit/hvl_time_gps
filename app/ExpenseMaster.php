<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseMaster extends Model {

    protected $table = 'api_expenses';
    protected $fillable = [
        'emp_id',
        'expense_type',
        'amount',
        'currency',
        'spent_at',
        'description',
        'city',
        'category_id',
        'sub_category_id',
        'date_time_of_expense',
        'multi_day_expens',
        'document_id',
        'is_notified',
    ];

}
