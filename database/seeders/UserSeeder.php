<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        $json = File::get("database/data/seedUsers.json");
        $user = json_decode($json);
        $users = [];
        $user_id = 1;

        foreach($user as $key => $value) {
            $users[$user_id] = [
                "id" => $value->id,
                "name" => $value->name,
                "email" => $value->email,
                "role" => $value->role,
                "email_verified_at" => $value->email_verified_at,
                "password" => Hash::make($value->password),
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,

            ];
            $user_id++;
        };
        $chunks = array_chunk($users, 4);

        foreach($chunks as $chunk) {
            User::insert($chunk);
        }
        $this->command->info('User seeding complete!');
    }
}
