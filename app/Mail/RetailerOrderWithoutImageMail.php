<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RetailerOrderWithoutImageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $details;
    public $shopname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $invoice, $shopname)
    {
        $this->details = $details;
        $this->invoice = $invoice;
        $this->shopname = $shopname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('retailer.mail.adminorderplaced', [
            'shopname' => $this->shopname,
        ])
            ->attach(storage_path('app/' . $this->invoice), [
                'as' => $this->invoice,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }
}
