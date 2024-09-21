<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::truncate();
        DB::table('comment_post')->truncate();

        $json = File::get("database/data/seedComments.json");
        $comment = json_decode($json);
        $comments = [];
        $comment_id = 1;

        foreach($comment as $key => $value) {
            $comments[$comment_id] = [
                "id" => $value->id,
                "username" => $value->username,
                "body" => $value->body,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,
            ];
            $comment_id++;
        };
        $chunks = array_chunk($comments, 40);

        foreach ($chunks as $chunk) {
            Comment::insert($chunk);
        }

        $loop_counter = 1;
        $post_number = 1;
        for ($i=1; $i <= 40; $i++) {
            DB::table('comment_post')->insert([
                ['comment_id'=>$comments[$i]['id'], 'post_id'=>$post_number]
            ]);

            $loop_counter++;

            if ($loop_counter == 6) {
                $loop_counter = 1;
                $post_number++;
            }
        }

        $this->command->info('Comment seeding complete!');
    }
}
