<?php

namespace OpenLibrary\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use OpenLibrary\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @param  \OpenLibrary\Models\User  $model
     * @return mixed
     */
    public function show(User $user, User $model)
    {
        return $user->role === 'administrador' || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @param  \OpenLibrary\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->role === 'administrador' || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @param  \OpenLibrary\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->role === 'administrador' || $user->id === $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role === 'administrador';
    }
}
