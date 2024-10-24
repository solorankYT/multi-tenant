<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;

class InitializeTenantByUser
{
    public function handle($request, Closure $next)
    {
        $user = $request->user(); // Get the authenticated user
    
        if ($user) {
            // Find the tenant associated with this user through the pivot table
            $tenant = $user->tenants()->first(); // Assuming the user belongs to at least one tenant
    
            if ($tenant) {
                tenancy()->initialize($tenant); // Initialize the tenant

                session(['tenant_name' => $tenant->name]);
            } else {
                // Handle cases where no tenant is associated with the user
                abort(403, 'No tenant associated with this user.');
            }
        }
    
        return $next($request);
    }
    
}
