<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use DB;
use App\Book;
use App\Author;

class BookTest extends TestCase
{
    /**
     * Test whether an author can be created, even as a duplicate.
     * 
     * @return void
     */
    public function testCanCreateAuthor() {
        $author = Author::create(['Name' => 'TestAuthor']);

        $authorInDatabase = Author::find($author->Id);
        $this->AssertTrue(isSet($authorInDatabase));
        Author::destroy($author->Id);
    }

    /**
     * Test whether an author can be removed.
     *
     * @return void
     */
    public function testCanRemoveAuthor() {
        $author = Author::create(['Name' => 'TestAuthor']);

        $this->AssertTrue(Author::destroy($author->Id) == 1);
    }

    /**
     * Test whether an author can be updated.
     * 
     * @return void
     */
    public function testCanUpdateAuthor() {
        $author = Author::create(['Name' => 'TestAuthor']);

        $newAuthorName = 'ChangedTestAuthor';

        $author->Name = $newAuthorName;
        $author->save();

        $authorInDatabase = Author::find($author->Id);

        $this->AssertTrue($authorInDatabase->Name == $newAuthorName);
        
        Author::destroy($author->Id);
    }

    /**
     * Test whether a book can be created.
     *
     * @return void
     */
    public function testCanCreateBook()
    {
        $author = Author::create(['Name' => 'TestAuthor']);
        $book = Book::create(['Name' => 'TestBook', 'BooksAuthors' => $author->Id]);

        $bookInDatabase = Book::find($book->Id);
        $this->AssertTrue(isSet($bookInDatabase));
        Book::destroy($book->Id);
        Author::destroy($author->Id);
    }

    /**
     * Test whether a book can be removed.
     *
     * @return void
     */
    public function testCanRemoveBook()
    {
        $author = Author::create(['Name' => 'TestAuthor']);
        $book = Book::create(['Name' => 'TestBook', 'BooksAuthors' => $author->Id]);

        $this->AssertTrue(Book::destroy($book->Id) == 1);
        Book::destroy($book->Id);
        Author::destroy($author->Id);
    }

    /**
     * Test whether an author can be updated.
     * 
     * @return void
     */
    public function testCanUpdateBook() {
        $author = Author::create(['Name' => 'TestAuthor']);
        $book = Book::create(['Name' => 'TestBook', 'BooksAuthors' => $author->Id]);

        $newBookName = 'ChangedTestBook';

        $book->Name = $newBookName;
        $book->save();

        $bookInDatabase = Book::find($book->Id);

        $this->AssertTrue($bookInDatabase->Name == $newBookName);
        
        Book::destroy($book->Id);
        Author::destroy($author->Id);
    }
}
