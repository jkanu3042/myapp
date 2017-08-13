<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('database.default') !== 'sqlite'){
            DB::statement('SET FOREIGN_KEY_CHECKs=0');
        }
//      Laravel 5.2 이상은 알아서 시딩 할 때 알아서 자동으로 풀고 잠근다.
//      Model::unguard();

        App\User::truncate();
        $this->call(UsersTableSeeder::class);

        App\Article::truncate();
        $this->call(ArticlesTableSeeder::class);

//      Model::unguard();


        if(config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }


    }
}
