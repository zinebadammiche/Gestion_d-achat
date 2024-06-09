<?php
namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::all();
        return view('modules.indexmodules', compact('modules'));
    }

    public function create()
    {
        return view('modules.createmodules');
    }

    public function store(Request $request)
    {
        $module = new Module();
        $module->name = $request->name; 
        $module->save();

        return redirect()->route('modules.indexmodules');
    }

    public function show(Module $module)
    {
        return view('modules.showmodules', compact('module'));
    }

    public function edit(Module $module)
    {
        return view('modules.editmodules', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $module->name = $request->name; 
        $module->save();

        return redirect()->route('modules.indexmodules');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('modules.indexmodules');
    }
}
