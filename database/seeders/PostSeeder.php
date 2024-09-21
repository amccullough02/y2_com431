<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::truncate();

        $json = File::get("database/data/seedPosts.json");
        $post = json_decode($json);
        $posts = [];
        $post_id = 1;

        foreach($post as $key => $value) {
            $posts[$post_id] = [
                "id" => $value->id,
                "title" => $value->title,
                "image_path" => $value->image_path,
                "cost" => $value->cost,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,
            ];
            $post_id++;
        };
        $chunks = array_chunk($posts, 8);

        foreach ($chunks as $chunk) {
            Post::insert($chunk);
        }
        $this->command->info('Post seeding complete!');
    }
}
