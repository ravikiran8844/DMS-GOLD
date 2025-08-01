<?php

namespace App\Jobs;

use App\Enums\Roles;
use App\Exports\RetailerOrderExport;
use App\Exports\RetailerOrderExportWithoutImage;
use App\Mail\RetailerOrderMail;
use App\Mail\RetailerOrderWithoutImageMail;
use App\Models\OrderDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProcessOrder implements ShouldQueue
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

        $datas = OrderDetail::select('order_details.*', 'product_variants.Purity', 'products.DesignNo', 'products.Project', 'product_variants.size', 'product_variants.style', 'orders.totalweight', 'orders.order_no', 'users.name', 'users.email', 'users.mobile')
            ->join('orders', 'orders.id', 'order_details.order_id')
            ->join('users', 'users.id', 'orders.user_id')
            ->join('product_variants', 'product_variants.id', 'order_details.product_id')
            ->join('products', 'products.id', 'product_variants.product_id')
            ->where('orders.user_id', $order->user_id)
            ->where('order_details.order_id', $order->id)
            ->get();

        Excel::store(new RetailerOrderExport($datas, $order), $excelFilePath);
        Excel::store(new RetailerOrderExportWithoutImage($datas, $order), $excelFilePaths);

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
        Mail::to('vivin.emerald@gmail.com')->send(new RetailerOrderMail($datas, $excelFilePath, $pdfFilePath));
        $adminMail = User::where('role_id', Roles::Admin)->value('email');
        Mail::to($adminMail)->bcc('sundaram@brightbridgeinfotech.com')->send(new RetailerOrderMail($datas, $excelFilePath, $pdfFilePath));
        Mail::to($adminMail)->bcc('sundaram@brightbridgeinfotech.com')->send(new RetailerOrderWithoutImageMail($datas, $excelFilePaths, $this->user->shop_name));
        // Send WhatsApp message
        $this->sendWhatsAppMessage($this->user->mobile, $order->order_no, url($pdfFilePath));

        $mobileNumbers = ['6374262388', '7871116216'];
        $pdfFilePath = $pdfFilePath; // your actual PDF path
        $this->sendCustomWhatsAppTemplate($mobileNumbers, $order, $pdfFilePath);

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

    private function sendCustomWhatsAppTemplate(array $mobileNumbers, $order, $pdfFilePath)
    {
        $token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJhNzFjOGNkZC0yMzBjLTQ2OWEtOTlmMy1iNzcxNTVjMjdiZDciLCJ1bmlxdWVfbmFtZSI6InZpc2hhbGhhcmlAZWppbmRpYS5jb20iLCJuYW1laWQiOiJ2aXNoYWxoYXJpQGVqaW5kaWEuY29tIiwiZW1haWwiOiJ2aXNoYWxoYXJpQGVqaW5kaWEuY29tIiwiYXV0aF90aW1lIjoiMTAvMDgvMjAyNCAwOTozMjozMSIsImRiX25hbWUiOiJtdC1wcm9kLVRlbmFudHMiLCJ0ZW5hbnRfaWQiOiI1NzA4IiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9yb2xlIjoiQURNSU5JU1RSQVRPUiIsImV4cCI6MjUzNDAyMzAwODAwLCJpc3MiOiJDbGFyZV9BSSIsImF1ZCI6IkNsYXJlX0FJIn0.553ARXacQ0-8oLB_QROQIVlWVXx5p3S15q_t9HMGQUk'; // your token

        $customerName = $this->user->name; // Safely get customer name
        $partyNumber = $this->user->mobile;         // Party number
        $orderTime = $order->created_at->format('d-m-Y H:i'); // Format time
        $orderId = $order->order_no;
        $pdfUrl = url($pdfFilePath);

        foreach ($mobileNumbers as $mobileNumber) {

            $url = 'https://live-mt-server.wati.io/5708/api/v1/sendTemplateMessage?whatsappNumber=' . urlencode('91' . $mobileNumber);

            $data = [
                'template_name'   => 'gold_rms_opd',
                'broadcast_name'  => 'OPD_Order_Update',
                'parameters' => [
                    ['name' => 'date', 'value' => $orderTime],
                    ['name' => 'Custorderid', 'value' => $orderId],
                    ['name' => 'Partyname', 'value' => $customerName],
                    ['name' => 'Partynumber', 'value' => $partyNumber],
                    ['name' => 'pdflink', 'value' => $pdfUrl],
                ]
            ];

            try {
                $response = Http::withHeaders([
                    'Authorization' => $token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post($url, $data);

                $responseData = $response->json();

                Log::info("WhatsApp API Response ('gold_rms_opd') to $mobileNumber:", [
                    'response' => $responseData,
                ]);

                if (!empty($responseData['response']['result']) && $responseData['response']['result'] === true) {
                    Log::info("✅ WhatsApp message ('gold_rms_opd') successfully sent to: $mobileNumber");
                } else {
                    $error = $responseData['response']['info'] ?? 'Unknown error';
                    Log::warning("⚠️ Failed to send WhatsApp message ('gold_rms_opd') to $mobileNumber: $error");
                }
            } catch (\Exception $e) {
                Log::error("❌ Exception sending WhatsApp message ('gold_rms_opd') to $mobileNumber: " . $e->getMessage());
            }
        }

        return ['success' => true];
    }
}
