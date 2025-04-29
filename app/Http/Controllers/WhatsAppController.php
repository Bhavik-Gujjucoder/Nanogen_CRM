<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function sendPdf(Request $request)
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        $relativePath = 'distributors-price-lists/price-list.pdf';
        $pdfUrl = route('distributors_dealers.export_price_list');// asset('storage/' . $relativePath);
        $to = +919099909076; //$request->input('phone'); // example: +91XXXXXXXXXX


        $twilio->messages->create(
            "whatsapp:$to",
            [
                'from' => env('TWILIO_WHATSAPP_FROM'),
                'mediaUrl' => [$pdfUrl],
                'body' => 'Here is your PDF file.'
            ]
        );

        return response()->json(['message' => 'WhatsApp PDF sent successfully.']);
    }
}
