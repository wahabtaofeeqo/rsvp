<x-mail::message>

# Hello Guest

<p>Thanks for registering </p>

<p>Below is a QR code that will be scanned upon arrival at the venue: ONLY REGISTERED GUESTS WILL BE ALLOWED INTO THE PREMISES </p>

<p style="margin-bottom: 5px">We look forward to welcoming you!</p>
<div>
    <img src="{{ asset("qrcode/" . $user->code . ".png") }}" alt="QR Code">
</div>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
