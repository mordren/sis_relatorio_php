<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('profile')->orderBy('name')->paginate(20);
        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'is_admin' => ['boolean'],
            'cargo'                  => ['nullable', 'string', 'max:255'],
            'registro_profissional'  => ['nullable', 'string', 'max:255'],
            'telefone'               => ['nullable', 'string', 'max:20'],
            'ativo'                  => ['boolean'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $request->boolean('is_admin'),
        ]);

        $user->profile()->create([
            'cargo'                 => $validated['cargo'] ?? null,
            'registro_profissional' => $validated['registro_profissional'] ?? null,
            'telefone'              => $validated['telefone'] ?? null,
            'ativo'                 => $request->boolean('ativo', true),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $user): View
    {
        $user->load('profile');
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', "unique:users,email,{$user->id}"],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'is_admin' => ['boolean'],
            'cargo'                  => ['nullable', 'string', 'max:255'],
            'registro_profissional'  => ['nullable', 'string', 'max:255'],
            'telefone'               => ['nullable', 'string', 'max:20'],
            'ativo'                  => ['boolean'],
        ]);

        $user->update([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'is_admin' => $request->boolean('is_admin'),
        ]);

        if (! empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'cargo'                 => $validated['cargo'] ?? null,
                'registro_profissional' => $validated['registro_profissional'] ?? null,
                'telefone'              => $validated['telefone'] ?? null,
                'ativo'                 => $request->boolean('ativo', true),
            ]
        );

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Você não pode excluir sua própria conta.');
        }

        if ($user->relatoriosResponsavel()->exists()) {
            return back()->with('error', "Não é possível excluir o usuário \"{$user->name}\" pois ele é responsável técnico em um ou mais relatórios. Reatribua os relatórios antes de excluir.");
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
