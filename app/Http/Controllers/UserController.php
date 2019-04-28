<?php

namespace OpenLibrary\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use OpenLibrary\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', User::class);

        $users = User::paginate(15);

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $this->validate($request, [
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|max:255',
            'role' => 'required'
        ]);

        $data = $request->only(['email', 'password', 'role']);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('show', $user);

        $user->profile;

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $role = $request->input('role');

        $user->email = $email;
        $user->password = $password;
        $user->role = $role;

        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('delete', $user);
        
        $user->delete();

        return response()->json([
            'message' => 'Registro removido.'
        ], 204);
    }
}
