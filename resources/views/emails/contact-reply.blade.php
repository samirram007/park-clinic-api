<!DOCTYPE html>
<html>
<head>
    <title>Reply to your message</title>
</head>
<body>
    <h1>Hello, {{ $contact->name }}</h1>
    <p>Thank you for contacting us regarding: <strong>{{ $contact->subject }}</strong></p>
    <hr>
    <p><strong>Our reply:</strong></p>
    <p>{{ $contact->reply_message }}</p>
    <hr>
    <p>Best regards,<br>The Park Clinic Team</p>
</body>
</html>
