<!DOCTYPE html>
<html>
<head>
    <title>Thank You for Contacting Us</title>
</head>
<body>
    <h1>Hello {{ $contactMessage->name }},</h1>
    <p>Thank you for reaching out to Park Clinic. We have received your message regarding "{{ $contactMessage->subject }}".</p>
    <p>Our team will review your inquiry and get back to you as soon as possible.</p>
    <p>Best regards,<br>
    The Park Clinic Team</p>
    <hr>
    <p><small>This is an automated response to your inquiry. There is no need to reply to this email.</small></p>
</body>
</html>
