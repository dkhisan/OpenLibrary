<?php

namespace OpenLibrary\Http\Controllers;

use Illuminate\Http\Request;
use OpenLibrary\Models\UserProfile;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', UserProfile::class);

        $profiles = UserProfile::paginate(15);

        return response()->json($profiles);
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
        $this->authorize('create', UserProfile::class);
        $this->validate($request, [
            'name' => 'required|max:255',
            'address' => 'max:255',
            'phone' => 'max:255',
            'cpf' => 'max:255'
        ]);

        $data = $request->only(['user_id', 'name', 'avatar', 'address', 'phone', 'cpf']);
        if (!$data['user_id']) $data['user_id'] = auth()->user()->id;

        $profile = UserProfile::create($data);

        return response()->json($profile, 201);
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
        $profile = UserProfile::findOrFail($id);

        $this->authorize('show', $profile);
        
        return response()->json($profile);
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
        $profile = UserProfile::findOrFail($id);

        $this->authorize('update', $profile);

        $name = $request->input('name');
        $avatar = $request->input('avatar');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $cpf = $request->input('cpf');

        $profile->name = $name;
        $profile->avatar = $avatar;
        $profile->address = $address;
        $profile->phone = $phone;
        $profile->cpf = $cpf;

        $profile->save();

        return response()->json($profile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $profile = UserProfile::findOrFail($id);
        
        $this->authorize('update', $profile);

        $profile->delete();

        return response()->json([
            'message' => 'Registro removido.'
        ], 204);
    }
}
