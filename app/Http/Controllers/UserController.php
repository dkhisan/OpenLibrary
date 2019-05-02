<?php

namespace OpenLibrary\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use OpenLibrary\Models\User;
use OpenLibrary\Models\UserProfile;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('index', User::class);

        $users = new User();

        if ($request->name) {
            $users = User::where('name', 'like', "%{$request->name}%");
        }

        $users = $users->paginate(10);

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
            'cpf' => 'max:255',
            'password' => 'required|max:255',
            'role' => 'required',
            'name' => 'required|max:255',
            'avatar' => 'required|max:255',
            'address' => 'max:255',
            'phone' => 'max:255',
        ]);

        $email = $request->input('email');
        $cpf = $request->input('cpf');
        $password = Hash::make($request->input('password'));
        $role = $request->input('role');
        $name = $request->input('name');
        $avatar = $request->input('avatar');
        $address = $request->input('address');
        $phone = $request->input('phone');

        $data = [
            'email' => $email,
            'cpf' => $cpf,
            'password' => $password,
            'role' => $role,
            'name' => $name,
            'avatar' => $avatar,
            'address' => $address,
            'phone' => $phone
        ];

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
        $this->validate($request, [
            // 'email' => 'required|email|max:255',
            'cpf' => 'max:255',
            'password' => 'required|max:255',
            'role' => 'required',
            'name' => 'required|max:255',
            'avatar' => 'required|max:255',
            'address' => 'max:255',
            'phone' => 'max:255',
        ]);

        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        // $email = $request->input('email');
        $cpf = $request->input('cpf');
        $password = Hash::make($request->input('password'));
        $role = $request->input('role');
        $name = $request->input('name');
        $avatar = $request->input('avatar');
        $address = $request->input('address');
        $phone = $request->input('phone');

        // $user->email = $email;
        $user->cpf = $cpf;
        $user->password = $password;
        $user->role = $role;
        $user->name = $name;
        $user->avatar = $avatar;
        $user->address = $address;
        $user->phone = $phone;
        
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
