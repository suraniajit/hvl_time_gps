<?php

namespace App\Http\Controllers;

use Auth;
use App\Lead;
use App\Employee;
use App\Module;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\WorkflowController;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Carbon\Carbon;

class LeadController extends Controller {

    function leadsStatus($lead_id, $date) {
//        echo $lead_id;
//        echo '<br>' . $date;
//        $DataArray = array(
//            'lead_progress_status' => '1'
//        );
//        $StatusUpdate = Lead::whereId($table_id);
//        $StatusUpdate->update($DataArray);


        DB::table('lead_opration')->where('lead_id', $lead_id)->update(array('lead_progress_status' => '1'));

        /**/
//        DB::table('leave_request')->insert(
//                [
//                    'employee_id' => $id,
//                    'from_date' => $date,
//                    'end_date' => $date,
//                    'holiday_date_' => $date,
//                    'total_days' => 1,
//                    'status' => 1 // holidays status
//                ]
//        );
        return redirect('user-profile-page');
    }

    public static function sendNormalMail($email, $subject, $Messagebody) {

//        $subject = $request->subject;
//        $email = $request->email;
//        $validatedData = $request->validate([
//            'subject' => 'required',
//            'email' => 'required',
//        ]);


        $nn = implode(",", $email);
        $nn = explode(',', $nn);


        $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 587, 'tls'))
                ->setUsername('a779bb5426f202')
                ->setPassword('b5d7597aa9a031');

        $mailer = new Swift_Mailer($transport);

        for ($i = 0; $i < count($nn); $i++) {
            $message = (new Swift_Message($subject))
                    ->setFrom(['hiteshv253@gmail.com' => 'Hitesh vishwakarma'])
                    ->setTo([$nn[$i] => $nn[$i]])
                    ->setBody($Messagebody, 'text/html');

            $result = $mailer->send($message);
        }
    }

    public function leadStore(Request $request) {

        /* work flow rules condion matchin start */
        $custome_redirect = '';

        $module_table_name = 'leads';

        $workflowConditon = DB::table('workflow_rules')
                ->select('*')
                ->where('module_id', '=', $module_table_name)
                ->where('when_execute', '=', 'create')
                ->get();





        if (count($workflowConditon) > 0) {

            $email_template_id = $workflowConditon[0]->email_template_id;
            $rule_name = $workflowConditon[0]->name;
            $module_id = $workflowConditon[0]->module_id;
            $radio = $workflowConditon[0]->radio;

            $email = array('hiteshv253@gmail.com', 'kumar32@yahoo.in', 'hiteshkumar32@yahoo.in');

            if ($module_id == 'leads') {
                if ($radio == 'some_') {
                    echo 'you are enter in some';

                    $workflowMultiConditon = DB::table('workflow_rules')
                            ->select('*')
                            ->join('workflow_multi_rules', 'workflow_multi_rules.rules_id', 'workflow_rules.id')
                            ->where('workflow_rules.module_id', '=', $module_table_name)
                            ->where('workflow_rules.when_execute', '=', 'create')
                            ->get();

                    $data = DB::table('leads');
                    foreach ($workflowMultiConditon as $key => $workflowMulti) {


                        $module_columes = $workflowMulti->module_columes;
                        $when_execute = $workflowMulti->when_execute;
                        $condition = $workflowMulti->condition;
                        $condition_input = $workflowMulti->condition_input;
                        $logical_operator_condition = $workflowMulti->logical_operator_condition;

                        if (($logical_operator_condition == '0')) {
                            if (($condition == 'is') && ( $condition = 'contains')) {
                                $data->where($module_columes, '=', "'$condition_input'");
                            }
                        }
                        if ($logical_operator_condition == 'or') {
                            if (($condition == 'is') && ( $condition = 'contains')) {
                                $data->orWhere($module_columes, '=', "'$condition_input'");
                            }
                        }
                        if (($logical_operator_condition == 'and')) {
                            if (($condition == 'is') && ( $condition = 'contains')) {
                                $data->where($module_columes, '=', "'$condition_input'");
                            }
                        }


//                        if (($condition == 'is_not_empty') && ( $condition = 'is_empty')) {
//                            $condition = 'IS NOT NULL';
//                            $data->where($module_columes, $condition, $condition_input);
//                            $data->orWhere($module_columes, $condition, $condition_input);
//                        }
//                        if (($condition == 'is') && ( $condition = 'contains')) {
//                            $condition = ' = ';
//                            $data->where($module_columes, $condition, $condition_input);
//                            $data->orWhere($module_columes, $condition, $condition_input);
//                        }
//                        if ($condition == 'isn_t') {
//                            $condition = ' != ';
//                            $data->where($module_columes, $condition, $condition_input);
//                            $data->orWhere($module_columes, $condition, $condition_input);
//                        }
                    }
                    $rows = $data->get();
                    echo count($rows);
                    dd($rows, $request->all());

                    $mail_sent_all = WorkflowController::sendMail($email, $rule_name, $email_template_id);
                    DB::table('workflow_rules')
                            ->where('module_id', $module_table_name)
                            ->update(array(
                                'mail_status' => '1', // sent
                                'count_result' => count($rows) // sent
                    ));
                }
                if ($radio == 'all_') {
//                echo 'you are enter in all';

                    $mail_sent_all = WorkflowController::sendMail($email, $rule_name, $email_template_id);

                    DB::table('workflow_rules')
                            ->where('module_id', $module_table_name)
                            ->update(array(
                                'mail_status' => '1' // sent
                    ));
                }
            } else {
                echo 'Work Flow is not applyed';
            }
        }



        /* work flow rules condion matchin end */





        $validatedData = $request->validate([
            'Name' => 'unique:leads,Name,' . $request->id
        ]);

        $table_id = Lead::insertGetId([]);
        $department = Lead::find($table_id);

        /* leads aprove and reject opration start */
        $values = array(
            'lead_id' => $table_id,
            'lead_create_date' => Carbon::today()->format('Y-m-d'),
            'lead_progress_status' => '0' // not start
        );
        DB::table('lead_opration')->insert($values);
        /* leads aprove and reject opration end */



        $fields = Module::where('name', 'leads')->select('form')->get();

        foreach ($fields as $field) {
            foreach (json_decode($field->form) as $item) {
                if ($item->type !== 'section') {
                    $f = str_replace(' ', '_', $item->label);

                    if (is_array($request->$f) === true) {

                        $array_value = implode(', ', $request->$f);
                        Lead::where('id', $table_id)->update([
                            $f => $array_value
                        ]);
                    } else {

                        if ($item->type === 'file') {
                            if ($request->hasFile($f)) {
                                $file_path = $this->uploadFile($request->$f);
                            } else {
                                $file_path = '';
                            }

                            Lead::where('id', $table_id)->update([
                                $f => $file_path
                            ]);
                        } else {

                            Lead::where('id', $table_id)->update([
                                $f => $request->$f
                            ]);
                        }
                    }
                }
            }
        }



        /* workflow_submit_rules start */

        $workflowSubmitRules = DB::table('workflow_submit_rules')
                ->select('*')
                ->where('module_id', '=', $module_table_name)
                ->get();

        if (count($workflowSubmitRules) > 0) {

            $rule_action = $workflowSubmitRules[0]->rule_action;
            $email = array('hiteshv253@gmail.com', 'kumar32@yahoo.in', 'hiteshkumar32@yahoo.in');
            $subject = 'Submit Rules';
            if ($rule_action == 'message') {
//                echo '-----';
                $Messagebody = $workflowSubmitRules[0]->course_description;
                $mail_sent_all = $this->sendNormalMail($email, $subject, $Messagebody);
                $custome_redirect = ('/modules/module/leads');
            } elseif ($rule_action == 'existing_page') {
                if ($workflowSubmitRules[0]->existing_page == 'dashborad') {
//                    echo '***';
                    $custome_redirect = '/dashboard/crm-dashboard';
                }
            }
        } else {
            $custome_redirect = ('/modules/module/leads');
//            $custome_redirect = (route('modules.module', 'leads'))->with('message', 'Record Inserted!');
        }
        /* workflow_submit_rules end */

//         dd($request->all());
        return redirect($custome_redirect);
    }

    public function leadUpdate(Request $request) {

        /* workflow start */
        /* work flow rules condion matchin start */
        $module_table_name = $request->table_name;

        $workflowConditon = DB::table('workflow_rules')
                ->select('*')
                ->where('module_id', ' = ', $module_table_name)
                ->where('when_execute', ' = ', 'edit')
                ->get();
        if (count($workflowConditon) > 0) {
            $email_template_id = $workflowConditon[0]->email_template_id;
            $rule_name = $workflowConditon[0]->name . ' Edit';
            $module_id = $workflowConditon[0]->module_id;
            $radio = $workflowConditon[0]->radio;

            $email = array('hiteshv253@gmail.com', 'kumar32@yahoo.in', 'hiteshkumar32@yahoo.in');

            if ($module_id == 'leads') {
                if ($radio == 'some_') {
                    echo '<br>you are enter in some lead<br>';

                    $workflowMultiConditon = DB::table('workflow_rules')
                            ->select('*')
                            ->join('workflow_multi_rules', 'workflow_multi_rules.rules_id', 'workflow_rules.id')
                            ->where('workflow_rules.module_id', ' = ', $module_table_name)
                            ->where('workflow_rules.when_execute', ' = ', 'edit')
                            ->get();

                    $data = DB::table('leads')->where('id', ' = ', $request->id);
                    foreach ($workflowMultiConditon as $key => $workflowMulti) {


                        $module_columes = $workflowMulti->module_columes;
                        $when_execute = $workflowMulti->when_execute;
                        $condition = $workflowMulti->condition;
                        $condition_input = $workflowMulti->condition_input;


                        if (($condition == 'is_not_empty') && ( $condition = 'is_empty')) {
                            $condition = 'IS NOT NULL';
                            $data->where($module_columes, $condition, $condition_input);
                        }
                        if (($condition == 'is') && ( $condition = 'contains')) {
                            $condition = ' = ';
                            $data->where($module_columes, $condition, $condition_input);
                        }
                        if ($condition == 'isn_t') {
                            $condition = ' != ';
                            $data->where($module_columes, $condition, $condition_input);
                        }
                    }
                    $rows = $data->get();

                    if (count($rows) > 0) {
                        $mail_sent_all = WorkflowController::sendMail($email, $rule_name, $email_template_id);
                        DB::table('workflow_rules')
                                ->where('module_id', $module_table_name)
                                ->update(array(
                                    'mail_status' => '1', // sent
                                    'count_result' => count($rows) // sent
                        ));
                        echo '<br>rules is matched mail sent<br>';
                    } else {
                        echo '<br>rules is not matched mail is not sent<br>';
                    }
                }
                if ($radio == 'all_') {

                    echo '<br>you are enter in All lead<br>';

                    $mail_sent_all = WorkflowController::sendMail($email, $rule_name, $email_template_id);

                    DB::table('workflow_rules')
                            ->where('module_id', $module_table_name)
                            ->update(array(
                                'mail_status' => '1' // sent
                    ));
                }
            } else {
                echo 'Work Flow is not applyed';
            }
        }
        /* workflow end */

//        dd($request->all());
        Lead::where('id', $request->id)->update([
            'Name' => 'unique:leads, Name, ' . $request->id
        ]);

        $fields = Module::where('name', 'leads')->select('form')->get();



        foreach ($fields as $field) {
            foreach (json_decode($field->form) as $item) {
                if ($item->type !== 'section') {
                    $f = str_replace(' ', '_', $item->label);

                    if (is_array($request->$f) === true) {

                        $array_value = implode(', ', $request->$f);
                        Lead::where('id', $request->id)->update([
                            $f => $array_value
                        ]);
                    } else {

                        if ($item->type === 'file') {
                            if ($request->hasFile($f)) {
                                $file_path = $this->uploadFile($request->$f);
                            } else {
                                $file_path = '';
                            }

                            Lead::where('id', $request->id)->update([
                                $f => $file_path
                            ]);
                        } else {

                            Lead::where('id', $request->id)->update([
                                $f => $request->$f
                            ]);
                        }
                    }
                }
            }
        }
//        dd($request->all());
        return redirect(route('modules.module', 'leads'))->with('message', 'Record Updated!');
    }

}
