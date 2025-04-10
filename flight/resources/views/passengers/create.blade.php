<form action="{{ route('passengers.store') }}" method="POST">
    @csrf
    <label for="first_name">First Name</label>
    <input type="text" name="first_name" id="first_name" required>
    
    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" id="last_name" required>
    
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>
    
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>
    <label for="password_confirmation">Confirm Password</label>
<input type="password" name="password_confirmation" id="password_confirmation" required>

    <label for="dob">Date of Birth</label>
    <input type="date" name="dob" id="dob" required>
    
    <label for="passport_expiry_date">Passport Expiry Date</label>
    <input type="date" name="passport_expiry_date" id="passport_expiry_date" required>
    
    <button type="submit">Create Passenger</button>
</form>
