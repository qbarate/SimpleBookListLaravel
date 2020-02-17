<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DB;
use App\Book;
use App\Author;

class BooksController extends Controller
{
    /**
     * Gets the main application view.
     */
    public function index(Request $request) {
        return view('BooksList');
    }

    /**
     * Returns the selected list of books.
     */
    public function list(Request $request) {
        $books = DB::table('Books')
            ->join('Authors', 'Books.BooksAuthors', '=', 'Authors.Id')
            ->select(
                'Books.Id as BookId',
                'Books.Name as BookName',
                'Authors.Id as AuthorId',
                'Authors.Name as AuthorName')
            ->get();
        return $books;
    }

    public function create() {
        return view('BooksCreateUpdate');
    }

    public function update($id) {
        if (!is_numeric($id))
            return redirect()->action('BooksController@index');

        $book = Book::find($id);
        $author = Author::find($book->BooksAuthors);

        return view('BooksCreateUpdate', compact('book', 'author'));
    }

    /**
     * Delete the Book with the selected id
     */
    public function delete(Request $request) {
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

        return redirect()->action('BooksController@index');
    }

    public function submit(Request $request) {
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
        
        return redirect()->action('BooksController@index');
    }
}
