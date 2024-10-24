<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash here
use Inertia\Inertia;

class UserController extends Controller
{

    public function index()
{
    $users = User::with('tenants')->get(); // Fetch users with their tenants
    return Inertia::render('Users/Index', [
        'users' => $users,
    ]);
}


// public function index()
// {
//     // Assuming you have a way to get the current tenant
//     $tenantId = tenant('id');
    
//     // Fetch users associated with the current tenant
//     $users = User::whereHas('tenants', function ($query) use ($tenantId) {
//         $query->where('tenant_id', $tenantId);
//     })->get();

//     return Inertia::render('Users/Index', [
//         'users' => $users,
//     ]);
// }



    public function create()
    {
        $tenants = Tenant::all(); 
        return Inertia::render('Users/Create', [
            'tenants' => $tenants  
        ]);
    }

    public function store(Request $request)
    {   
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'tenants' => 'array|required',
        ]);
    
        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
    
        // Sync the tenants with the user
        $user->tenants()->sync(collect($validatedData['tenants'])->pluck('id'));
    
        return redirect()->route('users.index');
    }
    
}
