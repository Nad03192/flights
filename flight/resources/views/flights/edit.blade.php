

    <h1>Edit Flight</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('flights.update', $flight->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="number">Flight Number:</label>
        <input type="text" name="number" value="{{ old('number', $flight->number) }}" required><br><br>

        <label for="departure_city">Departure City:</label>
        <input type="text" name="departure_city" value="{{ old('departure_city', $flight->departure_city) }}" required><br><br>

        <label for="arrival_city">Arrival City:</label>
        <input type="text" name="arrival_city" value="{{ old('arrival_city', $flight->arrival_city) }}" required><br><br>

        <label for="departure_time">Departure Time:</label>
        <input type="datetime-local" name="departure_time" value="{{ old('departure_time', \Carbon\Carbon::parse($flight->departure_time)->format('Y-m-d\TH:i')) }}" required><br><br>

        <label for="arrival_time">Arrival Time:</label>
        <input type="datetime-local" name="arrival_time" value="{{ old('arrival_time', \Carbon\Carbon::parse($flight->arrival_time)->format('Y-m-d\TH:i')) }}" required><br><br>
        <label for="available_seats">Available Seats:</label>
<input type="number" name="available_seats" value="{{ old('available_seats', $flight->available_seats ?? '') }}" min="0" required><br><br>

        <button type="submit">Update Flight</button>
    </form>

    <br>
    <a href="{{ route('flights.index') }}">Back to Flight List</a>
