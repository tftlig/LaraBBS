<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

use App\Models\User;

use App\Models\Link;

// 5.7章 分类下的话题列表
class CategoriesController extends Controller
{
    // // 5.8章 分类话题列表排序
    // public function show(Category $category, Request $request, Topic $topic)
    // {
    //     // 读取分类 ID 关联的话题，并按每 20 条分页
    //     $topics = $topic->withOrder($request->order)
    //                     ->where('category_id', $category->id)
    //                     ->with('user', 'category')   // 预加载防止 N+1 问题
    //                     ->paginate(20);

    //     // 传参变量话题和分类到模板中
    //     return view('topics.index', compact('topics', 'category'));
    // }


    // 9.1 边栏活跃用户
    public function show(Category $category, Request $request, Topic $topic, User $user, Link $link)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = $topic->withOrder($request->order)
                        ->where('category_id', $category->id)
                        ->with('user', 'category')   // 预加载防止 N+1 问题
                        ->paginate(20);
        // 活跃用户列表
        $active_users = $user->getActiveUsers();

        // 资源链接
        $links = $link->getAllCached();

        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category', 'active_users', 'links'));
    }
}

