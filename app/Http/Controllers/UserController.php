<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Méthode pour le login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tentative de connexion avec les identifiants fournis
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        // Regénérer la session pour éviter les attaques de fixation de session
        $request->session()->regenerate();

        // Redirection vers le tableau de bord après une connexion réussie
        return redirect()->intended('/dashboard');
    }
    
    // Méthode pour la déconnexion
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidation de la session actuelle
        $request->session()->invalidate();

        // Regénération du token de session pour des raisons de sécurité
        $request->session()->regenerateToken();

        // Redirection vers la page de login après déconnexion
        return redirect('/login');
    }

    // Méthode pour l'inscription
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Création d'un nouvel utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Attribution du rôle
        $user->assignRole($validatedData['role']);

        // Redirection vers la liste des utilisateurs après une inscription réussie
        return redirect('/users');
    }

    // Méthode pour récupérer tous les rôles
    public function getAllRoles()
    {
        $roles = Role::pluck('name');
        return response()->json($roles);
    }

    // Méthode pour mettre à jour les informations de l'utilisateur
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $id,
        ]);

        $user = User::find($id);

        // Vérification et mise à jour du mot de passe
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Mise à jour des autres informations de l'utilisateur
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Réaffectation du rôle de l'utilisateur
        $user->roles()->detach();
        $user->assignRole($request->input('role'));

        $user->save();
      
         return redirect('/users');
    }
    public function index()
    {
        // Charger tous les utilisateurs avec leurs rôles
        $users = User::with('roles')->get();
        
        return view('crudusers', compact('users'));
    }
    public function edit($id)
{
    $user = User::findOrFail($id);
    $roles = Role::pluck('name');
    return view('editusers', compact('user', 'roles'));
}

    // Méthode pour supprimer un utilisateur
    public function delete($id)
    {
        $user = User::find($id);
        $user->roles()->detach();
        $user->delete();
        return redirect('/users');
    }
}
