<?php

namespace OpenLibrary\Http\Controllers;

use Illuminate\Http\Request;
use OpenLibrary\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $per_page = 10;
        $books = new Book();

        if ($request->title) {
            $books = $books->where('title', 'like', "%{$request->title}%");
        }

        if ($request->per_page) {
            $per_page = (int) $request->per_page;
        }

        if ($request->is_available === 'true') {
            $books = $books->isAvailable();
        }
        else if ($request->my_reserves === 'true') {
            $books = $user->books()->isReserved();

        }
        else if ($request->my_rents === 'true') {
            $books = $user->books()->isRented();
        }
        else {
            $books = $books->selectRaw('books.*, ifnull(state, "disponível") state')->withState();
        }

        $books = $books->orderBy('title')->paginate($per_page);

        return response()->json($books);
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
        $this->authorize('create', Book::class);
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'cover' => 'required'
        ]);

        $data = $request->only(['title', 'description', 'year', 'author', 'publisher', 'cover']);

        $book = Book::create($data);

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        $book->rent;

        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', Book::class);

        $book = Book::findOrFail($id);
        $title = $request->input('title');
        $description = $request->input('description');
        $year = $request->input('year');
        $author = $request->input('author');
        $publisher = $request->input('publisher');
        $cover = $request->input('cover');

        $book->title = $title;
        $book->description = $description;
        $book->year = $year;
        $book->author = $author;
        $book->publisher = $publisher;
        $book->cover = $cover;

        $book->save();

        return response()->json($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function destroy($id)
    {
        $this->authorize('delete', Book::class);

        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'message' => 'Registro removido.'
        ], 204);
    }
}
