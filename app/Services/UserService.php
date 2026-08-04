<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * Get a paginated, filterable list of users for the DataTable.
     */
    public function paginate(?string $search = null, ?string $status = null, int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->with('roles')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Create a new user, attach roles, store avatar.
     */
    public function create(array $data, ?UploadedFile $avatar = null): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'] ?? 'active',
            'password' => Hash::make($data['password']),
        ]);

        if ($avatar) {
            $user->avatar = $this->storeAvatar($avatar);
            $user->save();
        }

        $user->syncRoles($data['roles'] ?? []);

        return $user;
    }

    /**
     * Update an existing user, attach roles, replace avatar if provided.
     */
    public function update(User $user, array $data, ?UploadedFile $avatar = null): User
    {
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'] ?? null;
        $user->status = $data['status'] ?? $user->status;

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if ($avatar) {
            $this->deleteAvatar($user);
            $user->avatar = $this->storeAvatar($avatar);
        }

        $user->save();
        $user->syncRoles($data['roles'] ?? []);

        return $user;
    }

    /**
     * Delete a user (and their avatar file).
     */
    public function delete(User $user): void
    {
        $this->deleteAvatar($user);
        $user->delete();
    }

    protected function storeAvatar(UploadedFile $avatar): string
    {
        return $avatar->store('avatars', 'public');
    }

    protected function deleteAvatar(User $user): void
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
    }
}
