<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{
    /**
     * Guards available in this app. Adjust to match config/auth.php.
     */
    protected array $guards = ['web', 'api'];

    /**
     * Render the permissions page.
     */
    public function index()
    {
        return view('permissions.index', [
            'guards' => $this->guards,
        ]);
    }

    /**
     * AJAX: paginated / searchable / filterable list of permissions.
     */
    public function data(Request $request)
    {
        $query = Permission::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('guard_name', 'like', "%{$search}%");
            });
        }

        if ($guard = $request->get('guard')) {
            $query->where('guard_name', $guard);
        }

        $perPage = (int) $request->get('per_page', 10);

        $permissions = $query->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        $permissions->getCollection()->transform(function (Permission $permission) {
            return [
                'id'         => $permission->id,
                'name'       => $permission->name,
                'guard_name' => $permission->guard_name,
                'created_at' => optional($permission->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => optional($permission->updated_at)->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data'         => $permissions->items(),
            'current_page' => $permissions->currentPage(),
            'last_page'    => $permissions->lastPage(),
            'total'        => $permissions->total(),
        ]);
    }

    /**
     * AJAX: single permission (for edit modal).
     */
    public function show(Permission $permission)
    {
        return response()->json([
            'id'         => $permission->id,
            'name'       => $permission->name,
            'guard_name' => $permission->guard_name,
        ]);
    }

    /**
     * AJAX: store a new permission.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => [
                'required', 'string', 'max:150',
                'unique:permissions,name,NULL,id,guard_name,' . $request->input('guard_name', 'web'),
            ],
            'guard_name' => ['required', 'string', 'in:' . implode(',', $this->guards)],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $permission = Permission::create($validator->validated());

        $this->forgetCache();

        return response()->json([
            'message' => "Permission \"{$permission->name}\" created.",
            'data'    => $permission,
        ], 201);
    }

    /**
     * AJAX: update an existing permission.
     */
    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name'       => [
                'required', 'string', 'max:150',
                'unique:permissions,name,' . $permission->id . ',id,guard_name,' . $request->input('guard_name', $permission->guard_name),
            ],
            'guard_name' => ['required', 'string', 'in:' . implode(',', $this->guards)],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $permission->update($validator->validated());

        $this->forgetCache();

        return response()->json([
            'message' => "Permission \"{$permission->name}\" updated.",
            'data'    => $permission,
        ]);
    }

    /**
     * AJAX: duplicate ("Copy") a permission with a unique suffixed name.
     */
    public function duplicate(Permission $permission)
    {
        $base = $permission->name;
        $i    = 1;
        $newName = "{$base}_copy";

        while (Permission::where('name', $newName)->where('guard_name', $permission->guard_name)->exists()) {
            $i++;
            $newName = "{$base}_copy{$i}";
        }

        $copy = Permission::create([
            'name'       => $newName,
            'guard_name' => $permission->guard_name,
        ]);

        $this->forgetCache();

        return response()->json([
            'message' => "Permission copied as \"{$copy->name}\".",
            'data'    => $copy,
        ], 201);
    }

    /**
     * AJAX: delete a permission.
     */
    public function destroy(Permission $permission)
    {
        $name = $permission->name;
        $permission->delete();

        $this->forgetCache();

        return response()->json([
            'message' => "Permission \"{$name}\" deleted.",
        ]);
    }

    protected function forgetCache(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}