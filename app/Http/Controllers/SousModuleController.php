<?php
 

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\SousModule;
use Illuminate\Http\Request;

class SousModuleController extends Controller
{
    public function index()
    {
        $sousmodules = SousModule::all();
        return view('sousmodules.indexsousmodules', compact('sousmodules'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('sousmodules.createsousmodules', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
          
            'module_id' => 'required|exists:modules,id',
        ]);

        $sousmodule = new SousModule();
        $sousmodule->name = $request->name;
     
        $sousmodule->module_id = $request->module_id;
        $sousmodule->save();

        return redirect()->route('sousmodules.indexsousmodules');
    }

   
    public function edit(SousModule $sousmodule)
    {
        $modules = Module::all();
        return view('sousmodules.editsousmodules', compact('sousmodule', 'modules'));
    }

    public function update(Request $request, SousModule $sousmodule)
    {
        $request->validate([
            'name' => 'required', 
            'module_id' => 'required|exists:modules,id',
        ]);

        $sousmodule->name = $request->name;
       
        $sousmodule->module_id = $request->module_id;
        $sousmodule->save();

        return redirect()->route('sousmodules.index');
    }

    public function destroy(SousModule $sousmodule)
    {
        $sousmodule->delete();
        return redirect()->route('sousmodules.indexsousmodules');
    }
}
