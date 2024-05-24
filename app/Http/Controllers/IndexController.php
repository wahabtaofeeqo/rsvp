<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Rsvp;
use App\Models\Guest;
use App\Imports\GuestsImport;
use Maatwebsite\Excel\Facades\Excel;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IndexController extends Controller
{
    public function init() {
        Excel::import(new GuestsImport, 'list.xlsx');
        return "Uploaded";
    }

    public function index() {
        return Inertia::render('Index');
    }

    public function thanks() {
        return Inertia::render('ThankYou');
    }

    public function store(Request $request) {

        // Alter phone number
        $payload = $request->all();
        $payload['phone'] = $request->code . '' . $request->phone;
        $request->replace($payload);

        $request->validate([
            'name' => 'required|string',
            'children' => 'required|array',
            'children.*.name' => 'required|string',
            'phone' => 'required|exists:guests|unique:rsvps'
        ]);
        
        $guest = Guest::where('phone', $request->phone)->first();
        if(count($request->children) > $guest->total) {
            return redirect()->back()->withErrors(['children' => ['You can only enter max of ' . $guest->total . ' children']]);
        }

        $payload = $request->all();
        $children = '';
        foreach ($request->children as $key => $value) {
           $children = $children . $value['name'] . ', ';
        }

        $payload['children'] = trim($children);
        $model = Rsvp::create($payload);

        // SMS
        $this->sendSMS($model);

        //
        return redirect()->route('thanks')->with('message', 'Thank you for RSVP-ing');
    }

    public function dashboard() {
        return Inertia::render('Dashboard', [
            'models' => Rsvp::latest()->paginate(10)
        ]);
    }

    private function sendSMS($user) {

        $code = str_pad(strval($user->id), 4, "0");
        $path = public_path('qrcode/' . $user->id);
        if(!file_exists($path)) mkdir($path, 0777, true);

        $file = $code . ".png";
        $filename = $path . "/" . $file;

        \QrCode::color(255, 0, 127)->format('png')
            ->size(500)->generate(strval($code), $filename);

        //
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
 
        $body = <<<EOT
            Hello $user->children

            Thanks for registering 
            Below is a QR code that will be scanned upon arrival at the venue:
            
            ONLY REGISTERED GUESTS WILL BE ALLOWED INTO THE PREMISES 
            
            We look forward to welcoming you!

            $filename
        EOT;

         try {
            $message = $twilio->messages->create("whatsapp:+" . $user->phone, // to
                [
                    "contentSid" => "HXccc9d797a991507afb0ff15b461632b2",
                    "from" => "MG018ee670d457100f1e059c498af63ce3",
                    "contentVariables" => json_encode([
                        "1" => $user->children,
                        "2" => url($filename)
                    ])
                ]
            );

            $user->code = $code;
            $user->is_sent = true;
            $user->save();
        } 
        catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
