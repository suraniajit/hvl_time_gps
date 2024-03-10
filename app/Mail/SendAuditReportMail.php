<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Config;

class SendAuditReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The emailParams object instance.
     *
     * @var emailParams
     */
    private $emailParams;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailParams) {
        $this->emailParams = $emailParams;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

//echo $this->emailParams->path;
//echo $this->emailParams->file;
//echo $this->emailParams->file_type;
//dd($this->emailParams);

//        application/vnd.ms-excel
//        application/vnd.ms-excel

            if ($this->emailParams->file_type == 'pdf')
            {

                $emailObj = $this->from('helpdesk@hvlpestservices.com')
                    ->view('emails.auditreport')
                    ->subject($this->emailParams->subject)
                    ->with(['body' => $this->emailParams->body])
                    ->with(['emailParams' => $this->emailParams])
                    ->attach($this->emailParams->path.'/'.$this->emailParams->file,
                        [
                            'as' => $this->emailParams->file,
                            'mime' => 'application/pdf',
                        ]);
            }
            else
            {
                $emailObj = $this->from('helpdesk@hvlpestservices.com')
                    ->view('emails.auditreport')
                    ->subject($this->emailParams->subject)
                    ->with(['body' => $this->emailParams->body])
                    ->with(['emailParams' => $this->emailParams])
                    ->attach($this->emailParams->path.'/'.$this->emailParams->file,
                        [
                            'as' => $this->emailParams->file,
                            'mime' => 'application/vnd.ms-excel',
                        ]);
            }


            return $emailObj;
    }
}
