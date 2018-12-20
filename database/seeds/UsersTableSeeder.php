<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // 头像假数据
        $avatars = [
            'https://qiniu.phpbest.cn/images/avatars/1.jpg',
            'https://qiniu.phpbest.cn/images/avatars/2.jpg',
            'https://qiniu.phpbest.cn/images/avatars/3.jpg',
            'https://qiniu.phpbest.cn/images/avatars/4.jpg',
            'https://qiniu.phpbest.cn/images/avatars/5.jpg',
            'https://qiniu.phpbest.cn/images/avatars/6.jpg',
            'https://qiniu.phpbest.cn/images/avatars/7.jpg',
            'https://qiniu.phpbest.cn/images/avatars/8.jpg',
            'https://qiniu.phpbest.cn/images/avatars/9.jpg',
            'https://qiniu.phpbest.cn/images/avatars/10.jpg',
        ];

        // 生成数据集合
        $users = factory(User::class)
                        ->times(10)
                        ->make()
                        ->each(function ($user) use ($faker, $avatars) {
                            // 从头像数组中随机取出一个并赋值
                            $user->avatar = $faker->randomElement($avatars);
                        });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'Luke';
        $user->email = 'luke_44@foxmail.com';
        $user->avatar = 'https://qiniu.phpbest.cn/images/avatars/1.jpg';
        // 初始化用户角色，将 1 号用户指派为『站长』
        $user->assignRole('Founder');
        $user->save();

        // 将 2 号用户指派为『管理员』
        $user = User::find(2);
        $user->assignRole('Maintainer');
    }
}
