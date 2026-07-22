<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ l('تغییر وضعیت تیکت') }}</title>
</head>
<body>
<p>
    {{ $ticketOwner->{{ l('name }} عزیز، سلام') }}
</p>
<p>
    تیکت پشتیبانی شما با کد #{{ $ticket->{{ l('token }} پاسخ داده شد.') }}
</p>
</body>
</html>
