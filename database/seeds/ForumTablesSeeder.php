<?php

use Illuminate\Database\Seeder;

class ForumTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->delete();

        \DB::table('categories')->insert([
            [
                'id' => 1,
                'order' => 1,
                'name' => 'Contact Moderators',
                'color' => '#dfb450',
                'slug' => 'contact-moderators',
                'created_at' => now()
            ],
            [
                'id' => 2,
                'order' => 2,
                'name' => 'Hytale Community',
                'color' => '#3498DB',
                'slug' => 'hypixel-community',
                'created_at' => now()
            ]
        ]);

        \DB::table('forums')->delete();

        \DB::table('forums')->insert([
            [
                'id' => 1,
                'order' => 1,
                'category_id' => 1,
                'parent_id' => null,
                'name' => 'Report Rule Breakers',
                'slug' => 'report-rule-breakers',
                'created_at' => now()
            ],
            [
                'id' => 2,
                'order' => 2,
                'category_id' => 1,
                'parent_id' => null,
                'name' => 'Ban Appeal',
                'slug' => 'ban-appeal',
                'created_at' => now()
            ],
            [
                'id' => 3,
                'order' => 3,
                'category_id' => 1,
                'parent_id' => null,
                'name' => 'Apply For Staff',
                'slug' => 'apply-for-staff',
                'created_at' => now()
            ],

            [
                'id' => 4,
                'order' => 1,
                'category_id' => 2,
                'parent_id' => null,
                'name' => 'Off Topic',
                'slug' => 'off-topic',
                'created_at' => now()
            ],
            [
                'id' => 5,
                'order' => 1,
                'category_id' => 2,
                'parent_id' => 4,
                'name' => 'Forum Games',
                'slug' => 'forum-games',
                'created_at' => now()
            ],
            [
                'id' => 6,
                'order' => 1,
                'category_id' => 2,
                'parent_id' => null,
                'name' => 'Introduce Yourself',
                'slug' => 'introduce-yourself',
                'created_at' => now()
            ],
            [
                'id' => 7,
                'order' => 1,
                'category_id' => 2,
                'parent_id' => 6,
                'name' => 'Redstone Room',
                'slug' => 'redstone-room',
                'created_at' => now()
            ],
            [
                'id' => 8,
                'order' => 2,
                'category_id' => 2,
                'parent_id' => 6,
                'name' => 'Code Help',
                'slug' => 'code-help',
                'created_at' => now()
            ]
        ]);

        \DB::table('threads')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'forum_id' => '1',
                'title' => 'Aenean bibendum at nulla a tincidunt',
                'slug' => 'aenean-bibendum-at-nulla-a-tincidunt',
                'promoted' => 1,
                'created_at' => now()
            ]
        ]);

        \DB::table('posts')->insert([
            [
                'id' => 1,
                'thread_id' => 1,
                'user_id' => 1,
                'body' => '"<h3>Tutorial</h3><p>Aliquam finibus <strong>orci neque</strong>, at dignissim dolor maximus efficitur.</p>"',
                'parent_id' => null,
                'created_at' => now()
            ],
            [
                'id' => 2,
                'thread_id' => 1,
                'user_id' => 1,
                'body' => '"<p>Muito bom! Amei <i>esse</i> tutorial</p>"',
                'parent_id' => null,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'thread_id' => 1,
                'user_id' => 1,
                'body' => '"<p>Eu tb gostei mt.</p>"',
                'parent_id' => 2,
                'created_at' => now()
            ]
        ]);
    }
}
