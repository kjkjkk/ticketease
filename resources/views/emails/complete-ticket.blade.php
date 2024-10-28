<!DOCTYPE html>
<html>

<head>
    <title>TicketEase Notice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f3f7;
            margin: 0;
            padding: 40px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: 40px auto;
            padding: 40px;
            border-left: 25px solid #006769;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px;
            margin-right: 20px;
        }

        h1 {
            font-size: 28px;
            color: #006769;
            margin-top: 50;
            text-align: left;
        }

        h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            text-align: left;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
            text-align: left;
            line-height: 1.6;
        }

        .footer {
            font-size: 12px;
            color: #999;
            margin-top: 30px;
            text-align: left;
        }

        .signature {
            font-size: 16px;
            color: #333;
            margin-top: 40px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="{{ $message->embed('img/logo.png') }}" alt="CHO ICT Logo">
            </div>
            <h1>Ticket Completion Notice</h1>
        </div>

        <h2>Hello, {{ $ticket->requestor->firstname }} {{ $ticket->requestor->lastname }}!</h2>

        <p>We are pleased to inform you that your ticket with ID <strong>{{ $ticket->id }}</strong>, concerning a
            <strong>{{ $ticket->ticketNature->ticket_nature_name }}</strong>, has been successfully completed.
        </p>

        <p>If you've brought in a device, it is ready for pick-up at our office. You can collect it during working
            hours.</p>

        <p>If you have further questions or need additional support, feel free to reply to this email or contact us
            directly.</p>

        <p class="signature">Best regards,<br>CHO ICT</p>
    </div>
</body>

</html>
