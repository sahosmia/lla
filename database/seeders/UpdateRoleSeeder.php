<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::with('profile')->get();
        foreach ($users as $user) {
            if ($user->hasRole('admin')) {
                $user->default_role = 'admin';
            } else {
                $user->default_role = $user->profile?->tagline ? 'tutor' : 'student';
            }

            $user->save();
        }
    }
}
