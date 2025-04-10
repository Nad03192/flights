<!-- resources/views/passengers/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Passenger Details</h1>
    <p><strong>First Name:</strong> {{ $passenger->first_name }}</p>
    <p><strong>Last Name:</strong> {{ $passenger->last_name }}</p>
    <p><strong>Email:</strong> {{ $passenger->email }}</p>
    <p><strong>Date of Birth:</strong> {{ $passenger->dob }}</p>
    <p><strong>Passport Expiry Date:</strong> {{ $passenger->passport_expiry_date }}</p>
    <a href="{{ route('passengers.index') }}">Back to Passenger List</a>
@endsection
