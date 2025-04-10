<?php

    namespace App\Http\Controllers;

    use App\Models\Passenger;
    use Illuminate\Http\Request;
    
    class PassengerController extends Controller
    {
        public function index(Request $request)
        {
            $perPage = $request->input('perPage', 15);
            $passengers = Passenger::withTrashed()
                ->paginate($perPage);
            return view('passengers.index', compact('passengers'));
        }
    
        public function create()
        {
            return view('passengers.create');
        }
    
        public function store(Request $request)
        {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:passengers,email',
                'password' => 'required|string|min:8|confirmed',
                'dob' => 'required|date',
                'passport_expiry_date' => 'required|date',
            ]);
    
            Passenger::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'dob' => $request->dob,
                'passport_expiry_date' => $request->passport_expiry_date,
            ]);
    
            return redirect()->route('passengers.index')->with('success', 'Passenger added successfully.');
        }
    
        public function edit(Passenger $passenger)
        {
            return view('passengers.edit', compact('passenger'));
        }
    
        public function update(Request $request, Passenger $passenger)
        {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:passengers,email,' . $passenger->id,
                'password' => 'nullable|string|min:8|confirmed',
                'dob' => 'required|date',
                'passport_expiry_date' => 'required|date',
            ]);
    
            $passenger->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password ? bcrypt($request->password) : $passenger->password,
                'dob' => $request->dob,
                'passport_expiry_date' => $request->passport_expiry_date,
            ]);
    
            return redirect()->route('passengers.index')->with('success', 'Passenger updated successfully.');
        }
    
        public function destroy(Passenger $passenger)
        {
            $passenger->delete();
            return redirect()->route('passengers.index')->with('success', 'Passenger deleted successfully.');
        }
    
        public function restore($id)
        {
            $passenger = Passenger::withTrashed()->findOrFail($id);
            $passenger->restore();
            return redirect()->route('passengers.index')->with('success', 'Passenger restored successfully.');
        }
    
        public function search(Request $request)
        {
            $request->validate([
                'search' => 'required|string',
            ]);
    
            $searchTerm = $request->input('search');
            $passengers = Passenger::where('first_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                ->get();
    
            return view('passengers.index', compact('passengers', 'searchTerm'));
        }
    
        public function show(Passenger $passenger)
        {
            return view('passengers.show', compact('passenger'));
        }
    }
    


