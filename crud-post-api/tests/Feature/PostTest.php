<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;
use Database\Factories\PostFactory;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    //Test for the create functionality
    public function testCreatePost()
    {
        $requestData = [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'author' => '1',
        ];

        $response = $this->postJson('/api/post/', $requestData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'Post created successfully',
                'data' => [
                    'title' => 'Test Post',
                    'content' => 'This is a test post.',
                    'author' => '1',
                ],
            ]);

        $this->assertDatabaseHas('posts', $requestData);
    }

    //Test for the read functionality
    public function testReadPost()
    {
        $post = Post::factory()->create([
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'author' => '1',
        ]);

        $response = $this->getJson('/api/post/' . $post->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                 [
                    'title' => 'Test Post',
                    'content' => 'This is a test post.',
                    'author' => '1',
                ],
            );
    }

    //Test for the update functionality
    public function testUpdatePost()
    {
        $post = Post::factory()->create([
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'author' => '1',
        ]);
        $updatedData = [
            'title' => 'Updated Test Post',
            'content' => 'This is the updated content.',
            'author' => '1',
        ];

        $response = $this->putJson('/api/post/' . $post->id, $updatedData);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Post updated successfully',
                'data' => [
                    'title' => 'Updated Test Post',
                    'content' => 'This is the updated content.',
                    'author' => '1', 
                ],
            ]);

        $this->assertDatabaseHas('posts', $updatedData);
        $this->assertDatabaseMissing('posts', $post->toArray());
    }

    //Test for the delete functionality
    public function testDeletePost()
    {
        $post = Post::factory()->create([
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'author' => '1',
        ]);

        $response = $this->deleteJson('/api/post/' . $post->id);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
