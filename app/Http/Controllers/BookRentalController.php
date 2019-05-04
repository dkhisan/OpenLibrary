<?php

namespace OpenLibrary\Http\Controllers;

use Illuminate\Http\Request;
use OpenLibrary\Models\BookRental;

class BookRentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', BookRental::class);

        $rents = BookRental::paginate(15);

        foreach($rents as $rent) {
            $rent->profile;
            $rent->book;
        }

        return response()->json($rents);
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
        // $this->authorize('create', BookRental::class);
        $this->validate($request, [
            'user_id' => 'required',
            'book_id' => 'required',
            'state' => 'required'
        ]);

        $data = $request->only(['user_id', 'book_id', 'time', 'state', 'rent_at']);

        $rent = BookRental::create($data);
        $rent->book;

        return response()->json($rent, 201);
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
        $rent = BookRental::findOrFail($id);

        $this->authorize('show', $rent);

        $rent->profile;
        $rent->book;

        return response()->json($rent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', BookRental::class);

        $rent = BookRental::findOrFail($id);
        $profile_id = $request->input('profile_id');
        $book_id = $request->input('book_id');
        $time = $request->input('time');
        $state = $request->input('state');
        $rent_at = $request->input('rent_at');

        $rent->profile_id = $profile_id;
        $rent->book_id = $book_id;
        $rent->time = $time;
        $rent->state = $state;
        $rent->rent_at = $rent_at;

        $rent->save();

        return response()->json($rent);
    }
}
