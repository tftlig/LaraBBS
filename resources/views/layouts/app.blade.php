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
  <title>@yield('title', 'LaraBBS') - Laravel 进阶教程</title>

  <!-- Styles -->
  {{-- 2.6章：mix('css/app.css') 会根据 webpack.mix.js 的逻辑来生成 CSS 文件链接。 --}}
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

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

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
