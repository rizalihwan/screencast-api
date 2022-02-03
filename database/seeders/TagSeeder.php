<?php

namespace Database\Seeders;

use App\Models\Screencast\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $data = [
        'Javascript',
        'PHP',
        'Tailwind Css',
        'Golang',
        'Ruby',
        'Dart'
    ];
    public function run()
    {
        \DB::table('tags')->delete();

        $tags = collect($this->data);
        $tags->each(function ($tag) {
            Tag::create([
                'name' => $tag,
                'slug' => \Str::slug($tag)
            ]);
        });
    }
}
