<?php
class UserTableSeeder extends Seeder
{

public function run()
{
    DB::table('users')->delete();
    User::create(array(
        'name'     => 'Jawad Hassan',
        'username' => 'jawad',
        'email'    => 'jawadjee0519@gmail.com',
        'password' => Hash::make('jawadjee'),
    ));
}

}

?>