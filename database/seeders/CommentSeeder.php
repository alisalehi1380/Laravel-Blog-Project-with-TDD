<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Post::factory()->hasTags(10)->hasCategories(3)->hasComments(20)->create();
    }
    
    private function createReplyaComment($mainCommentId, $user2, $post, \Faker\Generator $f, $user3): void
    {
        Comment::query()->where('id', $mainCommentId)->create([
            'user_id'  => $user2,
            'post_id'  => $post->id,
            'reply_id' => $mainCommentId,
            'show'     => true,
            'text'     => 'Reply Comment Id ' . $mainCommentId . ' = ' . $f->text(60)
        ]);
        
        Comment::query()->where('id', $mainCommentId)->create([
            'user_id'  => $user3,
            'post_id'  => $post->id,
            'reply_id' => $mainCommentId,
            'show'     => true,
            'text'     => 'Reply Comment Id ' . $mainCommentId . ' = ' . $f->text(60)
        ]);
    }
    
    private function createUsers(): array
    {
        $user1 = User::factory()->count(1)->user()->create()[0]['id'];
        $user2 = User::factory()->count(1)->user()->create()[0]['id'];
        $user3 = User::factory()->count(1)->user()->create()[0]['id'];
        return array($user1, $user2, $user3);
    }
    
    private function createPost(\Faker\Generator $f, $user1, $post, $mainCommentId): array
    {
        Post::factory()->create()->each(function ($p) use ($f, $user1, &$post, &$mainCommentId) {
            $post = $p;
            $mainCommentId = $p->comments()
                ->create([
                    'user_id' => $user1,
                    'show'    => true,
                    'text'    => 'Main Comment ' . $f->text(60)
                ])->id;
        });
        return array($post, $mainCommentId);
    }
}
