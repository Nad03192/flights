<form action="{{ route('passengers.update', $passenger->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <label for="first_name">First Name</label>
    <input type="text" name="first_name" value="{{ $passenger->first_name }}" required>
    
    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" value="{{ $passenger->last_name }}" required>
    
    <label for="email">Email</label>
    <input type="email" name="email" value="{{ $passenger->email }}" required>
    
    <label for="password">Password</label>
    <input type="password" name="password" value="" placeholder="Leave empty to keep the current password">
    
    <label for="dob">Date of Birth</label>
    <input type="date" name="dob" value="{{ $passenger->dob }}" required>
    
    <label for="passport_expiry_date">Passport Expiry Date</label>
    <input type="date" name="passport_expiry_date" value="{{ $passenger->passport_expiry_date }}" required>
    
    <button type="submit">Update Passenger</button>
</form>
