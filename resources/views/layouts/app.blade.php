<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- 2.6章：app()->getLocale() 获取的是 config/app.php 中的 locale 选项，
  因为我们在前面章节中设置了 'locale' => 'zh_CN',
  所以在此处使用 str_replace() 函数将 _ 替换为 -，最终输出的值为 zh-CN。 --}}
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  {{-- 2.6章：csrf-token 标签是为了方便前端的 JavaScript 脚本获取 CSRF 令牌。 --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- 2.6章：继承此模板的页面，如果没有定制 title 区域的话，
    就会自动使用第二个参数 LaraBBS 作为标题前缀。 --}}
  {{-- <title>@yield('title', 'LaraBBS') - Laravel 进阶教程</title>
  <meta name="description" content="@yield('description', 'LaraBBS 爱好者社区')" /> --}}

    {{-- 8.7章 页面 SEO 信息 --}}
  <title>@yield('title', 'LaraBBS') - {{ setting('site_name', 'Laravel 进阶教程') }}</title>
  <meta name="description" content="@yield('description', setting('seo_description', 'LaraBBS 爱好者社区。'))" />
  <meta name="keywords" content="@yield('keyword', setting('seo_keyword', 'LaraBBS,社区,论坛,开发者论坛'))" />

  <!-- Styles -->
  {{-- 2.6章：mix('css/app.css') 会根据 webpack.mix.js 的逻辑来生成 CSS 文件链接。 --}}
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  {{-- 6.2章：主要布局文件中种下锚点 styles 和 scripts --}}
  @yield('styles')

</head>

<body>
  <div id="app" class="{{ route_class() }}-page">
    {{-- 2.6章：加载顶部导航区块的子模板。 --}}
    @include('layouts._header')

    <div class="container">

      @include('shared._messages')
      {{-- 2.6章：占位符声明，允许继承此模板的页面注入内容。 --}}
      @yield('content')

    </div>
    {{-- 2.6章：加载页面尾部导航区块的子模板。 --}}
    @include('layouts._footer')
  </div>

  {{-- 8.2章  站点权限--}}
  @if (app()->isLocal())
    @include('sudosu::user-selector')
  @endif

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
  {{-- 6.2章：主要布局文件中种下锚点 styles 和 scripts --}}
   @yield('scripts')
</body>

</html>
