<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class motivation_tags_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allStaticTags = [
            'Divorce',
            'Absentee',
            'Out-Of-State',
            'Trust-Owned',
            'Vacant',
            'Pre-Foreclosure',
            'Tax Delinquent',
            'Multiple Properties',
            'Eviction',
            'Probate',
            'Bankruptcy',
        ];
        foreach($allStaticTags as $staticTag) {
            DB::table('motivation_tags')->insert([
                'userid'   => 1,
                'tag_name' => $staticTag,
                'tag_type' => 'admin',
            ]);
        }



    }
}
