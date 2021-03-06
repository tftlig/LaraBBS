<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Auth;
use App\Models\User;
use App\Models\Link;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	// public function index(Request $request, Topic $topic)
	// {
    //     // 5.6章：方法 with() 提前加载了我们后面需要用到的关联属性 user 和 category，并做了缓存。
    //     // 后面即使是在遍历数据时使用到这两个关联属性，
    //     // 数据已经被预加载并缓存，因此不会再产生多余的 SQL 查询

    //     // 5.8章 控制器中调用排序
    //     $topics = $topic->withOrder($request->order)->with('user', 'category')->paginate(30);
	// 	return view('topics.index', compact('topics'));
	// }

    // 我们尝试打印从缓存里读取出来的数据
    public function index(Request $request, Topic $topic, User $user, Link $link)
    {
        $topics = $topic->withOrder($request->order)
                        ->with('user', 'category')  // 预加载防止 N+1 问题
                        ->paginate(20);
        $active_users = $user->getActiveUsers();
        // dd($active_users);  这行是测试打印用户用户的

        $links = $link->getAllCached();
        return view('topics.index', compact('topics', 'active_users', 'links'));
    }

    public function show(Request $request,Topic $topic)
    {

        // 6.8章 URL 矫正
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

	// 6.1章：将所有的分类读取赋值给变量 $categories ，并传入模板中
    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('categories','topic'));
    }

	// 6.1章 提交帖子
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

        return redirect()->to($topic->link())->with('success', '成功创建话题！');
    }

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('message', '更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', '成功删除！');
	}
}
