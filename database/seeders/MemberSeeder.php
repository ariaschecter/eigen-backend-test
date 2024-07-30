<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $members = [
            [
                'code' => "M001",
                'name' => "Angga",
            ],
            [
                'code' => "M002",
                'name' => "Ferry",
            ],
            [
                'code' => "M003",
                'name' => "Putri",
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
