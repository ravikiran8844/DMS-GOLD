<?php

namespace App\Jobs;

use App\Enums\Roles;
use App\Exports\OrderExport;
use App\Exports\OrderExportWithoutImage;
use App\Mail\AdminOrderMail;
use App\Mail\AdminOrderWithoutImageMail;
use App\Mail\OrderPlaced;
use App\Models\OrderDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class DealerProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $user;


    // public $timeout = 120; // Set timeout to 120 seconds
    // public $tries = 5; // Number of attempts

    public function __construct($order, $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function handle()
    {
        $order = $this->order;

        // Generate Excel invoice and store it
        $excelFileName = $order->order_no . '.xlsx';
        $excelFilePath = 'invoices/' . $excelFileName;
        $excelFileNames = $order->order_no . '.xlsx';
        $excelFilePaths = 'invoices/no-img/' . $excelFileNames;

        $datas = OrderDetail::select('order_details.*', 'products.product_image', 'products.product_unique_id', 'products.project_id', 'projects.project_name', 'orders.totalweight', 'orders.order_no', 'users.name', 'users.email', 'users.mobile', 'styles.style_name', 'silver_purities.silver_purity_percentage','finishes.finish_name')
            ->join('orders', 'orders.id', 'order_details.order_id')
            ->join('users', 'users.id', 'orders.user_id')
            ->join('products', 'products.id', 'order_details.product_id')
            ->join('projects', 'projects.id', 'products.project_id')
            ->join('styles', 'styles.id', 'order_details.box_id')
            ->join('silver_purities', 'silver_purities.id', 'products.purity_id')
            ->join('finishes', 'finishes.id', 'products.finish_id')
            ->where('orders.user_id', $order->user_id)
            ->where('order_details.order_id', $order->id)
            ->get();

        Excel::store(new OrderExport($datas, $order), $excelFilePath);
        Excel::store(new OrderExportWithoutImage($datas, $order), $excelFilePaths);

        // Generate PDF invoice and store it
        $pdfFileName = $order->order_no . '.pdf';
        $pdfFilePath = 'pdf/' . $pdfFileName;

        // Create a PDF from Blade view
        $pdf = Pdf::loadView('exports.pdf', ['order' => $order, 'datas' => $datas]);
        $fullPdfPath = public_path($pdfFilePath); // This line generates the full path to the PDF file

        // Ensure the directory exists
        $publicPdfDir = dirname($fullPdfPath);
        if (!is_dir($publicPdfDir)) {
            mkdir($publicPdfDir, 0755, true);
        }

        // Store the PDF file in the public path
        file_put_contents($fullPdfPath, $pdf->output());

        // Optional: Log the file path for confirmation
        Log::info("PDF stored at: " . $fullPdfPath);

        // Update the order's invoice paths
        $order->update([
            'invoice_path' => $excelFilePath,
            'invoice' => $excelFilePaths,
            'pdf_invoice' => $pdfFilePath,
        ]);

        // Send email to user and admin
        Mail::to($this->user->email)->send(new OrderPlaced($datas, $excelFilePath, $pdfFilePath));
        $adminMail = User::where('role_id', Roles::Admin)->value('email');
        Mail::to($adminMail)->bcc('sundaram@brightbridgeinfotech.com')->send(new OrderPlaced($datas, $excelFilePath, $pdfFilePath));
        Mail::to($adminMail)->bcc('sundaram@brightbridgeinfotech.com')->send(new AdminOrderWithoutImageMail($datas, $excelFilePaths, $this->user->name));
        // Send WhatsApp message
        $this->sendWhatsAppMessage($this->user->mobile, $order->order_no, url($pdfFilePath));
        // Optionally, log the message sending status
        Log::info('WhatsApp message sent to: ' . $this->user->mobile);
        Log::info('file: ' . url($pdfFilePath));
    }

    private function sendWhatsAppMessage($mobileNumber, $orderNo, $pdfUrl)
    {
        // WATI API endpoint for sending a template message
        $url = 'https://live-mt-server.wati.io/5708/api/v1/sendTemplateMessage?whatsappNumber=' . urlencode('91' . $mobileNumber);

        // Bearer token for authorization
        $token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJhNzFjOGNkZC0yMzBjLTQ2OWEtOTlmMy1iNzcxNTVjMjdiZDciLCJ1bmlxdWVfbmFtZSI6InZpc2hhbGhhcmlAZWppbmRpYS5jb20iLCJuYW1laWQiOiJ2aXNoYWxoYXJpQGVqaW5kaWEuY29tIiwiZW1haWwiOiJ2aXNoYWxoYXJpQGVqaW5kaWEuY29tIiwiYXV0aF90aW1lIjoiMTAvMDgvMjAyNCAwOTozMjozMSIsImRiX25hbWUiOiJtdC1wcm9kLVRlbmFudHMiLCJ0ZW5hbnRfaWQiOiI1NzA4IiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9yb2xlIjoiQURNSU5JU1RSQVRPUiIsImV4cCI6MjUzNDAyMzAwODAwLCJpc3MiOiJDbGFyZV9BSSIsImF1ZCI6IkNsYXJlX0FJIn0.553ARXacQ0-8oLB_QROQIVlWVXx5p3S15q_t9HMGQUk'; // Replace with your actual token

        // Prepare the data payload with template parameters
        $data = [
            'template_name' => 'invoice_utility', // Replace with your template name
            'broadcast_name' => 'invoice_utility',
            'parameters' => [
                [
                    'name' => 'orderID',
                    'value' => $orderNo, // Dynamic order number
                ],
                [
                    'name' => 'pdflink',
                    'value' => $pdfUrl, // Publicly accessible URL for the PDF invoice
                ],
            ],
        ];

        try {
            // Send the request to the WATI API using Laravel's HTTP client
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json', // Specify acceptable response format
                'Content-Type' => 'application/json', // Correct Content-Type for JSON
            ])->post($url, $data);

            // Log the response for debugging purposes
            Log::info('WhatsApp API Response: ', ['response' => $response->json()]);

            // Check if the response is successful
            if ($response->successful()) {
                Log::info('WhatsApp message successfully sent to: ' . $mobileNumber);
                return ['success' => true, 'message' => 'Message sent successfully'];
            } else {
                // Log and handle errors if the request fails
                Log::error('Failed to send WhatsApp message: ', ['response' => $response->json()]);
                return ['success' => false, 'message' => 'Message sending failed'];
            }
        } catch (\Exception $e) {
            // Handle and log any exceptions
            Log::error('Exception occurred while sending WhatsApp message: ' . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
    }
}
