<!DOCTYPE html>
<html>
<head>
    <title>Flight Reminder</title>
</head>
<body>
    <h1>Hi {{ $passenger->first_name }},</h1>
    <p>This is a reminder that you have a flight scheduled at {{ $flight->departure_time }}.</p>
    <p>Please make sure to be ready at the airport on time!</p>
    <p>Thank you for choosing us.</p>
</body>
</html>
