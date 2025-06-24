<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RetailerOrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $datas;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($datas, $invoice)
    {
        $this->datas = $datas;
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('retailer.mail.orderplaced')
            ->attach(storage_path('app/' . $this->invoice), [
                'as' => $this->invoice,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }
}
