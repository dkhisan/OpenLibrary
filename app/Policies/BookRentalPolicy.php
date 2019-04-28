<?php

namespace OpenLibrary\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use OpenLibrary\Models\User;
use OpenLibrary\Models\BookRental;

class BookRentalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the book rental.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role !== 'leitor';
    }

    /**
     * Determine whether the user can view the book rental.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @param  \OpenLibrary\Models\BookRental  $rent
     * @return mixed
     */
    public function show(User $user, BookRental $rent)
    {
        return $user->role !== 'leitor' || $user->profile->id === $rent->profile_id;
    }

    /**
     * Determine whether the user can create book rentals.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role !== 'leitor';
    }

    /**
     * Determine whether the user can update the book rental.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role !== 'leitor';
    }

    /**
     * Determine whether the user can delete the book rental.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @param  \OpenLibrary\Models\BookRental  $rent
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can restore the book rental.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can permanently delete the book rental.
     *
     * @param  \OpenLibrary\Models\User  $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role === 'administrador';
    }
}
