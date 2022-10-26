<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'admin', 'display_name' => 'Quản trị mạng hệ thống'],
            ['name' => 'guest', 'display_name' => 'Khách hàng'],
            ['name' => 'developer', 'display_name' => 'Nhà phát triển'],
            ['name' => 'content', 'display_name' => 'Chỉnh sửa nội dung'],
        ]);
    }
}
