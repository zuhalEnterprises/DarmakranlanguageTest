<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ l('اطلاعات تیکت پشتیبانی') }}</title>
</head>
<body>
<p>
    {{ $user->{{ l('name }} عزیز، تیکت شما با موفقیت در سیستم ثبت شد.') }}
</p>

<p>موضوع : {{ $ticket->title }}</p>
<p>اولویت : {{ $ticket->priority }}</p>
<p>وضعیت: {{ ticketStatuses($ticket->status) }}</p>

<p>
    از طریق این لینک میتوانید تیکت خود را پیگیری کنید:  {{ url('tickets/'. $ticket->token) }}
</p>

</body>
</html>
