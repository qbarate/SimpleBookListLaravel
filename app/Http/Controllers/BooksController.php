<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Book;
use App\Author;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return Book::with('author')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bookName' => 'required|max:255',
            'authorName' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        // TODOQBA have a separate controller for authors & create authors there
        $bookName = $request->input('bookName');
        $authorName = $request->input('authorName');

        // This is a new book, we must create its author beforehand if it is new
        // Since the exercise does not specify what to do with duplicate authors, we choose the easy way :
        // We use an already existing author if we can. Othewise we create a new author.
        $author = Author::where('Name', $authorName)->first();

        if ($author === NULL) {
            $author = Author::create(['Name' => $authorName]);
        }

        Book::create(['Name' => $bookName, 'BooksAuthors' => $author->Id]);

        return redirect('/')->with('success', 'Book created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!is_numeric($id))
            return redirect('/');

        $book = Book::find($id);
        $author = Author::find($book->BooksAuthors);

        return view('books/edit', compact('book', 'author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TODOQBA See if this is really necessary
        if (!is_numeric($id))
            return redirect('/');

        $validator = Validator::make($request->all(), [
            'bookName' => 'required|max:255',
            'authorName' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        $bookName = $request->input('bookName');
        $authorName = $request->input('authorName');

        // If a book is specified, we update its data
        // First, save the book name
        $book = Book::find($id);
        $book->Name = $bookName;
        $book->save();

        // Then, save the author name.
        $author = Author::find($book->BooksAuthors);
        $author->Name = $authorName;
        $author->save();

        return redirect('/')->with('success', 'Book updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bookId' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        $bookId = $request->input('bookId');

        if (!Book::destroy($bookId))
            return back()->withErrors(['Error:', 'The Book could not be deleted.']);

            return redirect('/')->with('success', 'Book deleted!');
    }
}
