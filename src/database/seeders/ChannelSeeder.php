<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->insert([
            ['content' => '自社サイト'],
            ['content' => '検索エンジン'],
            ['content' => 'SNS'],
            ['content' => 'テレビ・新聞'],
            ['content' => '友人・知人']
        ]);
    }
}
