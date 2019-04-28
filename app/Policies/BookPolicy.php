<?php

namespace OpenLibrary\Policies;

use OpenLibrary\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the book.
     *
     * @return mixed
     */
    public function view()
    {
        return true;
    }

    /**
     * Determine whether the user can create books.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can update the book.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can delete the book.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can restore the book.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can permanently delete the book.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role === 'administrador';
    }
}
