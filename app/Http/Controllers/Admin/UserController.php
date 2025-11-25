<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Lista korisnika u admin panelu.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 20);

        $users = User::query()
            ->withCount('ads')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Forma za kreiranje korisnika.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Forma za izmenu korisnika.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:user,admin'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Korisnik je uspešno kreiran.');
    }

    /**
     * Ažuriranje korisnika.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['required', Rule::in(['user', 'admin'])],
        ]);

        $user->update($data);

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('success', 'Korisnik je uspešno ažuriran.');
    }

    /**
     * Brisanje korisnika.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Korisnik je uspešno obrisan.');
    }

    public function profile(User $user)
    {
        $ads = $user->ads()
            ->latest()
            ->paginate(12);

        $primaryAd = $user->ads()
            ->whereNotNull('phone')
            ->latest()
            ->first();

        return view('users.profile', [
            'user' => $user,
            'ads' => $ads,
            'primaryAd' => $primaryAd,
        ]);
    }
}
