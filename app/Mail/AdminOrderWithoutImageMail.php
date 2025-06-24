<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOrderWithoutImageMail extends Mailable
{
    use Queueable, SerializesModels;
    public $invoice;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($details, $invoice)
    {
        $this->details = $details;
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.mail.adminorderplaced')
            ->attach(storage_path('app/' . $this->invoice), [
                'as' => $this->invoice,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }
}
