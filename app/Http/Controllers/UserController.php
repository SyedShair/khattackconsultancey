<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(protected UserService $users)
    {
    }

    /**
     * Render the page shell. The table itself is populated via AJAX (data()).
     */
    public function index(): View
    {
        $roles = Role::orderBy('name')->pluck('name');

        return view('users.index', compact('roles'));
    }

    /**
     * JSON endpoint the page's JS calls to (re)load the table.
     * GET /users/data?search=&status=&page=
     */
    public function data(Request $request): JsonResponse
    {
        $users = $this->users->paginate(
            search: $request->string('search')->toString() ?: null,
            status: $request->string('status')->toString() ?: null,
            perPage: 10
        );

        $users->getCollection()->transform(function (User $user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'status' => $user->status,
                'avatar' => $user->avatar ? asset('storage/'.$user->avatar) : null,
                'roles' => $user->roles->pluck('name'),
                'created_at' => $user->created_at->format('Y-m-d'),
            ];
        });

        return response()->json($users);
    }

    /**
     * Return a single user's data, used to pre-fill the edit modal.
     */
    public function show(User $user): JsonResponse
    {
        $user->load('roles');

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'status' => $user->status,
            'avatar' => $user->avatar ? asset('storage/'.$user->avatar) : null,
            'roles' => $user->roles->pluck('name'),
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->users->create($request->validated(), $request->file('avatar'));

        return response()->json([
            'message' => "User \"{$user->name}\" created successfully.",
            'user' => $user,
        ], 201);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        if ($user->id === auth()->id()
            && $user->hasRole('admin')
            && ! in_array('admin', $request->input('roles', []), true)) {
            return response()->json([
                'message' => 'You cannot remove your own admin role.',
            ], 422);
        }

        $user = $this->users->update($user, $request->validated(), $request->file('avatar'));

        return response()->json([
            'message' => "User \"{$user->name}\" updated successfully.",
            'user' => $user,
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'message' => 'You cannot delete your own account.',
            ], 422);
        }

        $this->users->delete($user);

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }
}
