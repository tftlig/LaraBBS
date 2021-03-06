{{-- 4.1章  用户个人中心视图--}}
@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

<div class="row">

  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card ">
      <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}">
      <div class="card-body">
            <h5><strong>个人简介</strong></h5>
            {{-- 4.3章 显示个人简介 --}}
            <p>{{ $user->introduction }}</p>
            <hr>
            <h5><strong>注册于</strong></h5>
            {{-- 4.3章 时间戳友好的输出。 --}}
            {{-- Carbon 是 PHP 知名的日期和时间操作扩展，Laravel 框架中使用此扩展来处理时间、日期相关的操作。
              diffForHumans 是 Carbon 对象提供的方法，提供了可读性更佳的日期展示形式。 --}}
            <p>{{$user->created_at->diffForHumans()}}</p>
            {{-- 9.4章  在 『注册于』 区块下新增 『最后活跃』--}}
            <hr>
            <h5><strong>最后活跃</strong></h5>
            <p title="{{  $user->last_actived_at }}">{{ $user->last_actived_at->diffForHumans() }}</p>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card ">
      <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
      </div>
    </div>
    <hr>

    {{-- 用户发布的内容 --}}
    <div class="card ">
      <div class="card-body">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}" href="{{ route('users.show', $user->id) }}">
              Ta 的话题
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">
              Ta 的回复
            </a>
          </li>
        </ul>
        @if (if_query('tab', 'replies'))
          @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(5)])
        @else
          @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
        @endif
      </div>
    </div>

  </div>
</div>
@stop
