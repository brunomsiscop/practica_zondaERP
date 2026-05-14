<?php

namespace Database\Seeders;

use App\Models\UserLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicianHasNewApp extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user_location = UserLocation::select('user_id', 'created_at')
            ->groupBy('user_id', 'created_at')
            ->get();
            
        foreach ($user_location as $i => $location) {
            echo "| Nombre: $location->user->name | Actualizado: $location->created_at |" . PHP_EOL;
        }
    }
}
