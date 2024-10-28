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
            border-left: 25px solid #e3342f;
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
            color: #e3342f;
            /* CHANGESSSSSSSs */
            margin-bottom: 20px;
        }

        h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .footer {
            font-size: 12px;
            color: #999;
            margin-top: 30px;
        }

        .signature {
            font-size: 16px;
            color: #333;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                {{-- CHANGESSSSSSS --}}
                <img src="{{ $message->embed('img/invalid.png') }}" alt="CHO ICT Logo">
            </div>
            <h1>Ticket Invalidation Notice</h1>
        </div>

        <h2>Dear {{ $ticket->requestor->firstname }} {{ $ticket->requestor->lastname }},</h2>

        <p>We regret to inform you that your ticket with ID <strong>{{ $ticket->id }}</strong>, concerning a
            <strong>{{ $ticket->ticketNature->ticket_nature_name }}</strong>, has been marked as invalid.
        </p>

        <p><strong>Reason for invalidation:</strong> {{ $reason }}.</p>

        <p>If you believe this was an error or have additional information to support your request, please feel free to
            submit a new ticket or contact us by replying to this email.</p>

        <p class="signature">Best regards,<br>CHO ICT</p>
    </div>
</body>

</html>
