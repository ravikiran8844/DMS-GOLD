<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RetailerOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $details;
    public $pdfFilePath;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $invoice, $pdfFilePath)
    {
        $this->details = $details;
        $this->invoice = $invoice;
        $this->pdfFilePath = $pdfFilePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('retailer.mail.orderplaced', ['details' => $this->details])
            ->attach(storage_path('app/' . $this->invoice), [
                'as' => $this->invoice,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])->attach(public_path($this->pdfFilePath), [
                'as' => 'invoice.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
