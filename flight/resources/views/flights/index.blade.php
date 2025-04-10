<h2>Flights</h2>

<form method="GET">
    <input type="text" name="search" placeholder="Search flights..." value="{{ $search ?? '' }}">
    <button type="submit">Search</button>
</form>

<form method="GET" style="margin-top: 10px;">
    <label for="per_page">Items per page:</label>
    <input type="number" name="per_page" id="per_page" value="{{ request('per_page', 10) }}" min="1">
    <button type="submit">Set</button>
</form>

<a href="{{ route('flights.create') }}">Create New Flight</a>

@if(session('success')) 
    <p>{{ session('success') }}</p> 
@endif

<table border="1">
    <thead>
        <tr>
            <th>Number</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($flights as $flight)
            <tr>
                <td>{{ $flight->number }}</td>
                <td>{{ $flight->departure_city }}</td>
                <td>{{ $flight->arrival_city }}</td>
                <td>
                    <a href="{{ route('flights.edit', $flight->id) }}">Edit</a> |
                    <a href="{{ route('flights.passengers', $flight->id) }}">Passengers</a> |
                    @if($flight->trashed())
                        <form action="{{ route('flights.restore', $flight->id) }}" method="POST" style="display:inline">
                            @csrf @method('PUT')
                            <button type="submit">Restore</button>
                        </form>
                    @else
                        <form action="{{ route('flights.destroy', $flight->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination links -->
<div>
    {{ $flights->appends(['search' => request('search'), 'per_page' => request('per_page')])->links() }}
</div>
