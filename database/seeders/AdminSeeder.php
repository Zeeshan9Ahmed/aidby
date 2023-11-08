<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Admin::truncate();
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@aidby.com',
            'password' => Hash::make('Abcd@1234')
        ]);
    }
}
