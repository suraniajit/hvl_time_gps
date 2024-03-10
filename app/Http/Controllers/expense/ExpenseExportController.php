<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Datatables;
use SweetAlert;
use App\ExpenseMaster;
use Validator;
use Carbon\Carbon;
use App\Mail\DownloadAttachementMail;
use App\Exports\ExpenseExport;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseExportController extends Controller {

    public function get_student_data() {
        return Excel::download(new ExpenseExport($claim_amount), 'students.xlsx');
    }

}
