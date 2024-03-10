<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerAuditMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $emailParams;
    public function __construct($emailParams)
    {
        $this->emailParams = $emailParams;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $EmailObj = 
        $this->from('helpdesk@hvlpestservices.com')
            ->to($this->emailParams->to_mail)
            ->view('emails.customer_audit_report')      
            ->subject($this->emailParams->subject)
            ->with(['emailParams' => $this->emailParams])
            ->with(['body' => $this->emailParams->body])
            ->attach($this->emailParams->file,
                [
                    'as' => 'audit_report.pdf',
                    'mime' => 'application/pdf',
                ]);
        return $EmailObj;
        
    }
}
