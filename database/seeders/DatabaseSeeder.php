<?php
namespace Database\Seeders;
use App\Models\User; use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email'=>'admin@example.com'],['full_name'=>'System Administrator','name'=>'admin','password'=>'password']);
    }
}
