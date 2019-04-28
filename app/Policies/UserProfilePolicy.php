<?php

namespace OpenLibrary\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use OpenLibrary\Models\User;
use OpenLibrary\Models\UserProfile;

class UserProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user profile.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->role !== 'leitor';
    }

    /**
     * Determine whether the user can view the user profile.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return bool
     */
    public function show(User $user, UserProfile $profile)
    {
        return $user->role !== 'leitor' || $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can create user profiles.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the user profile.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @param  \OpenLibrary\Models\UserProfile  $profile
     * @return bool
     */
    public function update(User $user, UserProfile $profile)
    {
        return $user->role === 'administrador' || $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can delete the user profile.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @param  \OpenLibrary\Models\UserProfile  $profile
     * @return bool
     */
    public function delete(User $user, UserProfile $profile)
    {
        return $user->role === 'administrador' || $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can restore the user profile.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @param  \OpenLibrary\Models\UserProfile  $profile
     * @return bool
     */
    public function restore(User $user, UserProfile $profile)
    {
        return $user->role === 'administrador' || $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can permanently delete the user profile.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return bool
     */
    public function forceDelete(User $user)
    {
        return $user->role === 'administrador';
    }
}
