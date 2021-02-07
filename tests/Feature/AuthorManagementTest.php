<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->createAuthor();

        $authors = Author::all();

        $this->assertCount(1, $authors);
        $this->assertInstanceOf(Carbon::class, $authors->first()->birthday);
    }

    protected function createAuthor($name = 'Franck Thilliez', $birthday = '1973-10-15')
    {
        return $this->post('/api/authors', [
            'name' => $name,
            'birthday' => $birthday,
        ]);
    }
}
