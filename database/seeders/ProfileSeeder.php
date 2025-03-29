<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::factory()->create([
            'type' => 'admin master',
            'active' => true,
        ]);
        
        Profile::factory()->create([
            'type' => 'admin restaurant',
            'active' => true,
        ]);

        Profile::factory()->create([
            'type' => 'user',
            'active' => true,
        ]);

        Profile::factory()->create([
            'type' => 'user restaurant',
            'active' => true,
        ]);
    }
}
