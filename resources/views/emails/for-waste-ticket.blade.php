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
            /* CHANGESSSSSSSSSSS */
            border-left: 25px solid #fbf664;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 70px;
            margin-right: 20px;
        }

        h1 {
            font-size: 28px;
            /* CHANGESSSSSSSSSSS */
            color: #fbf664;
            margin-top: 40;
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
                {{-- CHANGESSSSSSsss --}}
                <img src="{{ $message->embed('img/waste.png') }}" alt="CHO ICT Logo">
            </div>
            <h1>Ticket Status Notice</h1>
        </div>

        <h2>Hello, {{ $ticket->requestor->firstname }} {{ $ticket->requestor->lastname }}!</h2>

        <p>We would like to inform you that your ticket with ID <strong>{{ $ticket->id }}</strong>, regarding
            a <strong>{{ $ticket->ticketNature->ticket_nature_name }}</strong>, has been marked for waste.
        </p>

        <p>If you have any questions or need further assistance, feel free to reply to this email or contact us
            directly.</p>

        <p class="signature">Best regards,<br>CHO ICT</p>
    </div>
</body>

</html>
