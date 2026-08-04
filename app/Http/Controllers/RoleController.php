<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::withCount('permissions', 'users')->orderBy('name')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            // Group "users.view", "users.create" etc under "users" for the checkbox UI.
            return explode('.', $permission->name)[0];
        });

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role = Role::create(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()
            ->route('roles.index')
            ->with('success', "Role \"{$role->name}\" created.");
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role->name = $data['name'];
        $role->save();
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()
            ->route('roles.index')
            ->with('success', "Role \"{$role->name}\" updated.");
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name === 'admin') {
            return redirect()
                ->route('roles.index')
                ->with('error', 'The admin role cannot be deleted.');
        }

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted.');
    }
}
