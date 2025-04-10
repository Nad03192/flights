
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passengers on Flight</title>
</head>
<body>
    <h2>Passengers on Flight</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <ul>
        @forelse($passengers as $passenger)
            <li>
                {{ $passenger->first_name }} {{ $passenger->last_name }} ({{ $passenger->email }})
                <form method="POST" action="{{ route('flights.passengers.remove', [$flight->id, $passenger->id]) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to remove this passenger?')">Remove</button>
                </form>
            </li>
        @empty
            <li>No passengers found for this flight.</li>
        @endforelse
    </ul>

    <a href="{{ route('flights.index') }}">Back to Flights</a>
</body>
</html>
