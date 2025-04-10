<!-- resources/views/passengers/index.blade.php -->
<h1>Passengers</h1>

<!-- Search Form -->
<form action="{{ route('passengers.search') }}" method="GET">
    <input type="text" name="search" placeholder="Search passengers" value="{{ old('search', $searchTerm ?? '') }}" required>
    <button type="submit">Search</button>
</form>


<a href="{{ route('passengers.create') }}">Add New Passenger</a>

<!-- Display message if no passengers found -->
@if($passengers->isEmpty())
    <p>No passengers found.</p>
@else
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($passengers as $passenger)
                <tr>
                    <td>{{ $passenger->first_name }}</td>
                    <td>{{ $passenger->last_name }}</td>
                    <td>{{ $passenger->email }}</td>
                    <td>
                        @if ($passenger->trashed())
                            <form action="{{ route('passengers.restore', $passenger->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit">Restore</button>
                            </form>
                        @else
                            <a href="{{ route('passengers.edit', $passenger->id) }}">Edit</a>
                            <form action="{{ route('passengers.destroy', $passenger->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
