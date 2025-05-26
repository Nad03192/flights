<h2>Hello {{ $passenger->name }},</h2>

<p>This is a reminder that your flight <strong>{{ $flight->number }}</strong> is scheduled to depart in 24 hours.</p>

<p><strong>From:</strong> {{ $flight->departure_city }}<br>
<strong>To:</strong> {{ $flight->arrival_city }}<br>
<strong>Departure Time:</strong> {{ $flight->departure_time }}</p>

<p>We wish you a pleasant journey!</p>
