<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Division;
use App\Models\User;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('division', 'chefs')->get();
        
        return view('services.indexservices', compact('services'));
    }

    public function create()
    {
        $divisions = Division::all();
        $chefs = User::whereHas('roles', function($query) {
            $query->where('name', 'Chef service');
        })->get();
        return view('services.createservices', compact('divisions', 'chefs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'division_id' => 'required|exists:divisions,id',
            'chef_service_id' => 'required|exists:users,id',
        ]);

        Service::create($request->all());
        return redirect()->route('services.index');
    }

    public function edit(Service $service)
    {
        $divisions = Division::all();
        $chefs = User::whereHas('roles', function($query) {
            $query->where('name', 'Chef Service');
        })->get();
        return view('services.editservices', compact('service', 'divisions', 'chefs'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required',
            'division_id' => 'required|exists:divisions,id',
            'chef_service_id' => 'required|exists:users,id',
        ]);

        $service->update($request->all());
        return redirect()->route('services.index');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index');
    }
}
