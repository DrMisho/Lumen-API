<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function index()
    {
        return response()->json(Author::all());
    }
    public function show($id)
    {
        $author = Author::query()->find($id);
        return response()->json($author);
    }
    public function create()
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'email' => 'required|unique:authors',
            'location' => 'required'
        ]);
        $author = Author::create(request()->all());

        return response()->json($author, 201);
    }
    public function update($id)
    {
        $author = Author::query()->find($id);

        $author->update(request()->all());

        return response()->json($author);
    }
    public function destroy($id)
    {
        $author = Author::query()->find($id);
        $author->delete();
        return response()->json('Deleted Successfully', 200);
    }
}
