
    <div class="container">
        <h1>Flights for {{ $passenger->first_name }} {{ $passenger->last_name }}</h1>

        @if ($flights->isEmpty())
            <p>No flights booked.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Flight Number</th>
                        <th>Departure City</th>
                        <th>Arrival City</th>
                        <th>Departure Time</th>
                        <th>Arrival Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($flights as $flight)
                        <tr>
                            <td>{{ $flight->number }}</td>
                            <td>{{ $flight->departure_city }}</td>
                            <td>{{ $flight->arrival_city }}</td>
                            <td>{{ \Carbon\Carbon::parse($flight->departure_time)->format('Y-m-d H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($flight->arrival_time)->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

