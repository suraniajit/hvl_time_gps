<?php

namespace App\Http\Controllers;

use App\Mail\DownloadAttachementMail;
use App\Mail\SendAuditReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendCSV(Request $request)
    {
        $message = Mail::to($request->to);

        if (isset($request->cc))
            $message->cc($request->cc);

        if (isset($request->bcc))
            $message->bcc($request->bcc);

         $message->send(new DownloadAttachementMail($request->csvfile, $request->subject, $request->body));

        return redirect('/customer-master')->with('success', 'Email Sent successfully.');
    }
    public function sendCSV1(Request $request)
    {
        $message = Mail::to($request->to);

        if (isset($request->cc))
            $message->cc($request->cc);

        if (isset($request->bcc))
            $message->bcc($request->bcc);

         $message->send(new DownloadAttachementMail($request->csvfile, $request->subject, $request->body));

        return redirect('/lead-master')->with('success', 'Email Sent successfully.');
    }

    public function sendaudit(Request $request)
    {

        $audit_path = DB::table('hvl_audit_reports')
            ->where('activity_id',$request->act_id)
            ->orderBy('id','DESC')
            ->first();
//    $file = $audit_path->path .'/'.$audit_path->report;
if (!empty($audit_path))
{
    $input = $request->all();
//        try {
    $emailParams = new \stdClass();
    $emailParams->receiverName = $input['customer'];
    $emailParams->email = $input['to'];
//            $emailParams->attachments = $request->file('attach');
    $emailParams->sender = 'Hvl';
    $emailParams->subject = $input['subject'];
    $emailParams->body = $input['body'];
    $emailParams->path = $audit_path->path;
    $emailParams->file = $audit_path->report;
    $emailParams->file_type = $audit_path->type;

    $message = Mail::to($emailParams->email);
    $message->send(new SendAuditReportMail($emailParams));
    $response = [
        'success' => true,
        'message' => 'Email notification will be sent to the given patient shortly!'
    ];
    return redirect()->back()->with('success', 'Email Sent successfully.');
}
else
{
    return redirect()->back()->with('error', 'Please upload audit report first !');
}


    }
}
