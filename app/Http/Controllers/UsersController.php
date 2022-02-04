<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

// 4.1章：Laravel 的控制器命名规范统一使用驼峰式大小写和复数形式来命名
class UsersController extends Controller
{
    // 限制游客访问
    // 使用 Laravel 提供身份验证（Auth）中间件来过滤未登录用户的 edit, update 动作
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    // 4.1章 展示个人页面
    // Laravel 会自动解析定义在控制器方法（变量名匹配路由片段）中的 Eloquent 模型类型声明。
    // 在下面代码中，由于 show() 方法传参时声明了类型 —— Eloquent 模型 User，
    // 对应的变量名 $user 会匹配路由片段中的 {user}，
    // 这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例。
    // 『隐性路由模型绑定』
    // 1）路由声明时必须使用 Eloquent 模型的单数小写格式来作为 路由片段参数，User 对应 {user}
    // 2）控制器方法传参中必须包含对应的 Eloquent 模型类型 提示，并且是有序的
    public function show(User $user){
        return view('users.show',compact('user'));
        // 将用户对象变量 $user 通过 compact 方法转化为一个关联数组，
        // 并作为第二个参数传递给 view 方法，将变量数据传递到视图中。
    }

    // 4.2章 编辑个人资料
    public function edit(User $user){
        // 4.8章，添加授权
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    // 4.2章 更新个人资料
    // 4.4章 上传头像
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        // 4.8章，添加授权
        $this->authorize('update', $user);

        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

}
