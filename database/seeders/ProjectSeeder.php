<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = [
            [
                'name' => 'E-direct',
                'description' => 'A business directory website.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'EBNB Hotel',
                'description' => 'A hotel management software for all hotel types',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Essential News',
                'description' => 'A  news platform and blogging',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'E-Hotels',
                'description' => 'A hotels system management software',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'E-apartment',
                'description' => 'An oapartment booking website',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}