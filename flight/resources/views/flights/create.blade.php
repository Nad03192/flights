<form method="POST" action="{{ isset($flight) ? route('flights.update', $flight->id) : route('flights.store') }}">
    @csrf
    @if(isset($flight)) @method('PUT') @endif

    <input type="text" name="number" placeholder="Flight Number" value="{{ old('number', $flight->number ?? '') }}">
    <input type="text" name="departure_city" placeholder="Departure City" value="{{ old('departure_city', $flight->departure_city ?? '') }}">
    <input type="text" name="arrival_city" placeholder="Arrival City" value="{{ old('arrival_city', $flight->arrival_city ?? '') }}">
    <input type="datetime-local" name="departure_time" value="{{ old('departure_time', isset($flight) ? \Carbon\Carbon::parse($flight->departure_time)->format('Y-m-d\TH:i') : '') }}">
    <input type="datetime-local" name="arrival_time" value="{{ old('arrival_time', isset($flight) ? \Carbon\Carbon::parse($flight->arrival_time)->format('Y-m-d\TH:i') : '') }}">

    <button type="submit">{{ isset($flight) ? 'Update' : 'Create' }} Flight</button>
</form>
