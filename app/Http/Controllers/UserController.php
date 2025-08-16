<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Affiche la liste paginée des utilisateurs avec recherche.
    public function index(Request $request)
    {
        $query = User::query();
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('lastname', 'like', "%$search%")
                  ->orWhere('firstname', 'like', "%$search%")
                  ->orWhere('telephone', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('role', 'like', "%$search%") ;
            });
        }
        $users = $query->orderBy('lastname')->orderBy('firstname')->paginate(10);
        return view('users.index', compact('users', 'search'));
    }

    //Affiche les détails d'un utilisateur.
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    //Affiche le formulaire d'édition d'un utilisateur.
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    //Met à jour un utilisateur.
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:user,noc_engineer,network_lead,superadmin'],
        ]);
        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour.');
    }

    //Valide un utilisateur en attente (superadmin).
    public function validateUser(User $user)
    {
        $user->is_validated = true;
        $user->save();
        return redirect()->route('users.index')->with('success', 'Utilisateur validé avec succès.');
    }

    // Refuse (supprime) un utilisateur en attente (superadmin).
    public function refuseUser(User $user)
    {
        if (!$user->is_validated) {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Demande d\'inscription refusée et utilisateur supprimé.');
        }
        return redirect()->route('users.index')->with('error', 'Impossible de refuser un utilisateur déjà validé.');
    }

    // Affiche le formulaire de création d'un utilisateur (superadmin).
    public function create()
    {
        return view('users.create');
    }

    // Enregistre un nouvel utilisateur (superadmin).
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:user,noc_engineer,network_lead,superadmin'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);
        $password = $validated['password'] ?? 'password';
        $user = \App\Models\User::create([
            'lastname' => $validated['lastname'],
            'firstname' => $validated['firstname'],
            'telephone' => $validated['telephone'] ?? null,
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'is_validated' => true,
        ]);
        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }
} 