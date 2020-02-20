<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // TODOQBA May delete later
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
        return view('BooksCreateUpdate'); //TODOQBA Update view names
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODOQBA Old code, rewrite asap
        $validator = Validator::make($request->all(), [
            'bookName' => 'required|max:255',
            'authorName' => 'required|max:255',
            'bookId' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        $bookName = $request->input('bookName');
        $authorName = $request->input('authorName');

        $bookId = $request->input('bookId');

        // If a book is specified, we update its data
        if (isSet($bookId)) {
            // First, save the book name
            $book = Book::find($bookId);
            $book->Name = $bookName;
            $book->save();

            // Then, save the author name.
            $author = Author::find($book->BooksAuthors);
            $author->Name = $authorName;
            $author->save();
        }
        // This is a new book, we must create its author beforehand if it is new
        else {
            // Since the exercise does not specify what to do with duplicate authors, we choose the easy way :
            // We use an already existing author if we can. Othewise we create a new author.
            $author = Author::where('Name', $authorName)->first();

            if ($author === NULL) {
                $author = Author::create(['Name' => $authorName]);
            }
    
            Book::create(['Name' => $bookName, 'BooksAuthors' => $author->Id]);
        }
        
        return redirect('/');
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
        //
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
        //
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

        return redirect('/'); // TODOQBA Implement a confirmation message when getting back to the main page
    }
}
