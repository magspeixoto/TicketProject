<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Ticket Created</title>
</head>

<body>
    <h1>New Ticket Created</h1>
    <p>A new ticket has been created with the following details:</p>
    <ul>
        <li><strong>Title:</strong> {{ $ticket->subject }}</li>
        <li><strong>Description:</strong> {{ $ticket->description }}</li>
        <li><strong>Status:</strong> {{ $ticket->status }}</li>
        <li><strong>Priority:</strong> {{ $ticket->priority }}</li>
    </ul>
</body>

</html>
