<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_all_books()
    {
        $books = Book::factory(4)->create();
        $response = $this->getJson(route('books.index'));

        foreach ($books as $book){
            $response->assertJsonFragment([
                'title' => $book->title
            ]);
        }
    }

    /** @test */
    function can_get_one_book(){
        $book = Book::factory()->create();
        $this->getJson(route('books.show',$book))->assertJsonFragment([
            'title' => $book->title
        ]);
    }

    /** @test */
    function can_create_book(){

        $this->postJson(route('books.store'),[])
        ->assertJsonValidationErrorFor('title');

        $this->postJson(route('books.store'),[
            'title' => 'Mi nuevo Libro'
        ])->assertJsonFragment([
            'title' => 'Mi nuevo Libro'
        ]);

        $this->assertDatabaseHas('books',[
            'title' => 'Mi nuevo Libro'
        ]);
    }

    /** @test */
    function can_update_books(){
        $book = Book::factory()->create();

        $this->patchJson(route('books.update',$book),[])
            ->assertJsonValidationErrorFor('title');

        $this->patchJson(route('books.update',$book),[
            'title' => "Edited book"
        ])->assertJsonFragment([
            'title' => 'Edited book'
        ]);

        $this->assertDatabaseHas('books',[
            'title' => 'Edited book'
        ]);
    }

    /** @test */
    function can_delete_books(){
        $book = Book::factory()->create();
        $this->deleteJson(route('books.destroy',$book))->assertNoContent();
        $this->assertDatabaseCount('books', 0);
    }
}
