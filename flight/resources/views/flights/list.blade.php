<!DOCTYPE html>
<html>
<head>
    <title>Available Flights</title>
</head>
<body>
    <h2>Flights</h2>

    <p><a href="{{ route('logout') }}">Logout</a></p>

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <table border="1" cellpadding="10">
        <tr>
            <th>Flight Number</th>
            <th>From</th>
            <th>To</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Seats</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        @foreach ($flights as $flight)
            <tr>
                <td>{{ $flight->number }}</td>
                <td>{{ $flight->departure_city }}</td>
                <td>{{ $flight->arrival_city }}</td>
                <td>{{ $flight->departure_time }}</td>
                <td>{{ $flight->arrival_time }}</td>
                <td>{{ $flight->passengers_count }} / {{ $flight->available_seats }}</td>
                <td>
                    @if ($flight->passengers_count >= $flight->available_seats)
                        <span style="color:red;">Fully Booked</span>
                    @else
                        <span style="color:green;">Available</span>
                    @endif
                </td>
                <td>
                    @if ($flight->passengers_count < $flight->available_seats)
                        <form method="POST" action="{{ route('flights.book', $flight->id) }}">
                            @csrf
                            <button type="submit">Book</button>
                        </form>
                    @else
                        <button disabled>Book</button>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
