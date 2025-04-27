<h2>Hello {{ $passenger->name }},</h2>

<p>This is a reminder that your flight <strong>{{ $flight->code }}</strong> is scheduled to depart in 24 hours.</p>

<p><strong>From:</strong> {{ $flight->from }}<br>
<strong>To:</strong> {{ $flight->to }}<br>
<strong>Departure Time:</strong> {{ $flight->departure_time }}</p>

<p>We wish you a pleasant journey!</p>
