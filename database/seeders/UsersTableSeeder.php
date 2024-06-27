<?php
// UsersTableSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
 use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'f_name' => "Admin",
            'l_name' => "Flex",
            'image' => "user.jpg",
            'email' => 'admin@flex.com',
            'password' => bcrypt('123456'),
        ]);


    }
}
