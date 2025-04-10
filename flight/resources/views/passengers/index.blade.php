<form method="GET" action="{{ route('passengers.index') }}">
    <label for="perPage">Results per page:</label>
    <input type="number" name="perPage" value="{{ request()->input('perPage', 15) }}" min="1">
    <button type="submit">Apply</button>
</form>

@if($passengers->count())
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
            @foreach($passengers as $passenger)
                <tr>
                    <td>{{ $passenger->first_name }}</td>
                    <td>{{ $passenger->last_name }}</td>
                    <td>{{ $passenger->email }}</td>
                    <td>
                        <a href="{{ route('passengers.edit', $passenger->id) }}">Edit</a>
                        <form action="{{ route('passengers.destroy', $passenger->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $passengers->links() }}
    </div>
@else
    <p>No passengers found</p>
@endif
