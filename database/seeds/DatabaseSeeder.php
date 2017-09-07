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

        App\Tag::truncate();
        DB::table('article_tag')->truncate();
        $tags = config('project.tags');

        foreach($tags as $slug => $name) {
            App\Tag::create([
                    'name' => $name,
                    'slug' => str_slug($slug) ]
            );
        }
        $this->command->info('Seeded: tags table');

        /* User */
        $this->call(UsersTableSeeder::class);

        /* 아티클 */
        $this->call(ArticlesTableSeeder::class);

        // 변수 선언
        $faker = app(Faker\Generator::class);
        $users = App\User::all();
        $articles = App\Article::all();
        $tags = App\Tag::all();

        // 아티클과 태그 연결
        foreach($articles as $article) {
            $article->tags()->sync(
                $faker->randomElements(
                    $tags->pluck('id')->toArray(),
                    rand(1, 3)
                )
            );
        }
        $this->command->info('Seeded: article_tag table');

        if(config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }


    }
}
