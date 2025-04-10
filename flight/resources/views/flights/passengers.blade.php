
<h2>Passengers on Flight {{ $flight->number }}</h2>

<ul>
    @forelse($passengers as $passenger)
        <li>{{ $passenger->first_name }} {{ $passenger->last_name }} ({{ $passenger->email }})</li>
    @empty
        <li>No passengers found.</li>
    @endforelse
</ul>

<a href="{{ route('flights.index') }}">Back</a>

