<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'OnSale') }}</title>
    <!-- 引入Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- 引入FontAwesome（用于图标） -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- 自定义样式 -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- 导航栏 -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">OnSale</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        
                        <li class="nav-item"><a class="nav-link" href="/dashboard">HomePage</a></li>
                        @if (Auth::user()->role == 'user')
                        <li class="nav-item"><a class="nav-link" href="{{route ('cart')}}"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                        @endif
                        <!-- 如果用户已登录，显示用户名和退出按钮 -->
                        
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard') }}">{{ Auth::user()->name }}</a></li>
                        <!-- 如果用户没有商铺，显示注册商铺按钮 -->
                        @if (Auth::user()->shop == null && Auth::user()->role == 'user')
                            <li class="nav-item"><a class="nav-link" href="{{ route('shop.register') }}">Register a shop</a></li>
                        @endif
                        @if (Auth::user()->role == 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.users') }}">All Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.shops') }}">All Shops</a></li>
                            
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a></li>

                        <!-- 添加一个表单用于退出 -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        
                    @else
                        <!-- 如果用户未登录，显示登录和注册按钮 -->
                        <li class="nav-item"><a class="nav-link" href="/">HomePage</a></li>
                        <li class="nav-item"><a class="nav-link" href="/login">Log in</a></li>
                        <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- 主体内容 -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- 页脚 -->
    <footer class="bg-light text-center py-3 mt-4">
        <p>© 2024 OnSale | <a href="#">Connect Us</a></p>
    </footer>

    <!-- 引入Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
