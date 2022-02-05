<?php

namespace Database\Seeders;

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
        // 生成数据集合
        User::factory()->count(10)->create();

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'lizhixin';
        $user->email = '173612205@qq.com';
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->password = bcrypt('12345678');
        $user->save();

        $user = User::find(2);
        $user->name = 'zhixin';
        $user->email = 'tftlig@sina.com';
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->password = bcrypt('12345678');
        $user->save();

        $user = User::find(3);
        $user->name = 'ceshihao';
        $user->email = 'pian266@126.com';
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->password = bcrypt('12345678');
        $user->save();
    }
}
