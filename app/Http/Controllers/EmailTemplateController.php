<?php

namespace App\Http\Controllers;

use App\Models\email_template\email_templates;
use App\Models\email_template\email_templates_master;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use App\Models\hrms\Batch;
use SweetAlert;
use Validator;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class EmailTemplateController extends Controller {

    public function index() {
        $id = Auth::id();
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $breadcrumbs = [
            ['link' => "", 'name' => "Home"],
            ['link' => "emailtemplate", 'name' => "Email Template"],
        ];

        $rightlink = [
            ['rightlink' => "emailtemplate/create", 'name' => "Create"]
        ];

        //Get Email Templates Data
        $data = email_templates::where('user_id', $id)->get();
        //Get Favourite Email Templates Data
        $data_fav = email_templates::where('user_id', $id)->where('is_fav', '1')->get();

        return view('emailtemplate.index', [
            'rightlink' => $rightlink,
            'data' => $data,
            'data_fav' => $data_fav,
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function view($id) {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $breadcrumbs = [
            ['link' => "", 'name' => "Home"],
            ['link' => "emailtemplate", 'name' => "Email Template"],
            ['link' => "emailtemplate/view", 'name' => "View"],
        ];

        //Get Filename from DB and opens the .txt
        $filename = email_templates::where('id', $id)->value('filename');
        $myfile = fopen(public_path("master_email_templates/templates/" . $filename), "r");

        if (filesize(public_path("master_email_templates/templates/" . $filename)) > 0) {
            $file_content = fread($myfile, filesize(public_path("master_email_templates/templates/" . $filename)));
            fclose($myfile);

            return view('emailtemplate.view', [
                'file_content' => $file_content,
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
            ]);
        } else {
            return view('emailtemplate.view', [
                'file_content' => NULL,
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs,
            ]);
        }
    }

    public function create() {
        $breadcrumbs = [
            ['link' => "", 'name' => "Home"],
            ['link' => "emailtemplate", 'name' => "Email Template"],
            ['link' => "emailtemplate/create", 'name' => "Create"],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        //Fetch Master Layout Details
        $templates = email_templates_master::all();
        return view('emailtemplate.create', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'templates' => $templates
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'filename' => 'required',
        ]);

        $id = Auth::id();
        $data = $request->temp_hidden;
        $name = $request->filename;
        $fname = $id . '_' . $name . '.txt';

        //Create new txt and store html in it
        $fp = fopen(public_path("master_email_templates/templates/" . $fname), 'w');
        fwrite($fp, $data);
        fclose($fp);

        $temp = new email_templates();
        $temp->user_id = $id;
        $temp->title = $request->filename;
        $temp->filename = $fname;
        $temp->save();
        return redirect()->route('emailtemplate.index');
    }

    public function update(Request $request, $temp_id) {
        $validatedData = $request->validate([
            'filename' => 'required',
        ]);

        $id = Auth::id();
        $data = $request->temp_hidden;
        $name = $request->filename;
        $fname = $id . '_' . $name . '.txt';

        $fp = fopen(public_path("master_email_templates/templates/" . $fname), 'w');
        fwrite($fp, $data);
        fclose($fp);

        email_templates::where('id', $temp_id)
                ->update([
                    'title' => $name,
                    'filename' => $fname
        ]);
        return redirect()->route('emailtemplate.index');
    }

    public function edit($id) {
        $filenam = DB::table('email_templates')->select('filename', 'id', 'title')->where('id', '=', $id)->get();
        foreach ($filenam as $file) {
            $myfile = fopen(public_path("master_email_templates/templates/" . $file->filename), "r");
            $template_name = $file->title;

            //Open a particular file and fetch its content
            $myfile = fopen(public_path("master_email_templates/templates/" . $file->filename), "r");
            if (filesize(public_path("master_email_templates/templates/" . $file->filename)) > 0) {
                $file_content = fread($myfile, filesize(public_path("master_email_templates/templates/" . $file->filename)));
                fclose($myfile);
                return view('emailtemplate.edit', [
                    'file_content' => $file_content,
                    'template_name' => $template_name,
                    'id' => $id,
                ]);
            } else {
                return view('emailtemplate.edit', [
                    'file_content' => NULL,
                    'template_name' => $template_name,
                    'id' => $id,
                ]);
            }
        }
    }

    public function changefav($id) {
        $fav = email_templates::where('id', $id)->value('is_fav');
        if ($fav == '1') {
            email_templates::where('id', $id)
                    ->update([
                        'is_fav' => '0',
            ]);
        } elseif ($fav == '0') {
            email_templates::where('id', $id)
                    ->update([
                        'is_fav' => '1',
            ]);
        }

        return redirect()->route('emailtemplate.index');
    }

    //Open Email Builder after one master layout is selected
    public function createtemp($id) {
        $filenam = DB::table('email_templates_master')->select('filename')->where('id', '=', $id)->get();
        foreach ($filenam as $file) {
            $myfile = fopen(public_path("master_email_templates/$file->filename"), "r");
        }
        if ((filesize(public_path("master_email_templates/$file->filename"))) > 0) {
            $file_content = fread($myfile, filesize(public_path("master_email_templates/$file->filename")));

            return view('emailtemplate.createtemp', [
                'file_content' => $file_content
            ]);
        } else {
            return view('emailtemplate.createtemp', [
                'file_content' => NULL,
            ]);
        }
    }

    function delete(Request $request) {
        /* single delete */
        $temp = email_templates::find($request->input('id'));
        if ($temp->delete()) {
            echo 'Data Deleted';
        }
        unlink(public_path("master_email_templates/templates/" . $temp->filename));
    }

    function multidelete(Request $request) {
        /* multi delete */
        $temp_id_array = $request->input('id');
        $temp = email_templates::whereIn('id', $temp_id_array);
        if ($temp->delete()) {
            echo 'Data Deleted';
        }
        unlink(public_path("master_email_templates/templates/" . $temp->filename));
    }

    //Open Email Sending Index Page
    public function indexsend($id) {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];
        $breadcrumbs = [
            ['link' => "", 'name' => "Home"],
            ['link' => "emailtemplate", 'name' => "Email Template"],
            ['link' => "emailtemplate", 'name' => "Send"],
        ];

        $users = User::get(['name', 'email']);

        return view('emailtemplate.send', [
            'id' => $id,
            'users' => $users,
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    //Sending Email
    public function send(Request $request) {

        $validatedData = $request->validate([
            'subject' => 'required',
            'email' => 'required',
        ]);

//        $email = $request->email;
        $email = array('abc', 'test', 'next');
        $nn = implode(",", $email);
        $nn = explode(',', $nn);
        print_r($email);
        dd($request->all());

        $filename = email_templates::where('id', $request->id)->value('filename');
        $myfile = fopen(public_path("master_email_templates/templates/" . $filename), "r");
        $myfile1 = fopen(public_path("master_email_templates/master.txt"), "r");

        if (filesize(public_path("master_email_templates/templates/" . $filename)) > 0) {
            $file_content = fread($myfile, filesize(public_path("master_email_templates/templates/" . $filename)));
            $master = fread($myfile1, filesize(public_path("master_email_templates/master.txt")));
            fclose($myfile);
            fclose($myfile1);

            $body = $master . $file_content;


            $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 587, 'tls'))
                    ->setUsername('a779bb5426f202')
                    ->setPassword('b5d7597aa9a031');

            $mailer = new Swift_Mailer($transport);

            for ($i = 0; $i < count($nn); $i = $i + 2) {
                $message = (new Swift_Message($request->subject))
                        ->setFrom(['rajb986@gmail.com' => 'Raj Banker'])
                        ->setTo([$nn[$i] => $nn[$i + 1]])
                        ->setBody($body, 'text/html');

                $result = $mailer->send($message);
            }

            if ($result) {
                echo 'sent';
            } else {
                echo 'not sent';
            }

            return redirect()->route('emailtemplate.index');
        }
    }

}
