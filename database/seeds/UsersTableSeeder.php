<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => Str::random(10),
        //     'email' => Str::random(10).'@gmail.com',
        //     'password' => bcrypt('secret'),
        //     'remember_token' => Str::random(60),
        //     'role' => 'user'
        // ]);

        
        // $userData =  $factory->defineAs(User::class, 'admin', function (Faker\Generator $faker) {
        //     return [
        //         'name' => $faker->name,
        //         'email' => $faker->email,
        //         'password' =>  Hash::make('User@123'),
        //         'role' => 'user'
        //     ];
        // });

        // $user = User::where('id', $userData->id)->first();

        // $user = User::find($user->id);

        // $user->roles()->attach([2]);

        //$userObj = new User();
        $users = factory(App\User::class, 50)->create();
        $id = Role::where('name', 'user')
                    ->first();
        
        foreach($users as $user){
            $userResult = User::find($user->id);

            $userResult->roles()->attach($id);
        }            
        
        
    }
}
