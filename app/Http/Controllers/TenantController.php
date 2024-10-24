<?php
namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all(); // Fetch all tenants
        return Inertia::render('TenantIndex', ['tenants' => $tenants]);
    }

    public function create()
    {
        return Inertia::render('TenantForm', ['isEdit' => false]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:tenants,name', // Validate tenant name
        ]);

        Tenant::create([
            'name' => $validatedData['name'], // Create tenant with the validated name
        ]);

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
    }

    public function edit(Tenant $tenant)
    {
        return Inertia::render('TenantForm', [
            'tenant' => $tenant,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'name' => 'required|string|unique:tenants,name,' . $tenant->id, // Validate name for update
        ]);

        $tenant->update([
            'name' => $request->name,
        ]);

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }

    public function destroy(Tenant $tenant)
    {
        // Delete the tenant
        $tenant->delete();

        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully.');
    }
}
