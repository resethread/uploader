<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        //$this->call(VideosTableSeeder::class);
    }
}

class UsersTableSeeder extends Seeder 
{
    public function run() 
    {
        DB::table('users')->insert([
           'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'status' => 'admin',
            'description' => 'toto',
            'avatar' => 'toto',
            'ip' => '01'
        ]);
    }
}

class VideosTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $limit = 220;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('videos')->insert([
                'public_id' => str_random(10),
                'title' => $title = $faker->sentence($nbWords = 6, $variableNbWords = true),
                'slug' => str_slug($title),
                'duration' => $faker->time($format = 'H:i:s', $max = 'now'),
                'user_id' => 1,
                'path' => ''
            ]);
        }
    }
}

class MessagesTableSeeder extends Seeder 
{
    public function run()
    {

        $faker = Faker\Factory::create();
        $limit = 33;

         for ($i = 0; $i < $limit; $i++) {
            DB::table('messages')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'subject' => $faker->title,
                'text' => $faker->realText($faker->numberBetween(10,20)),
                'ip' => $faker->ipv4
            ]);
        }
    }
}

class PagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pages')->insert([
           'name' => 'conditions',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, similique facere. Rem aliquam consequuntur quasi aspernatur laboriosam nulla, similique minus labore, odit ut aperiam, omnis incidunt quaerat sint adipisci. Soluta.'
        ]);
    }
}
