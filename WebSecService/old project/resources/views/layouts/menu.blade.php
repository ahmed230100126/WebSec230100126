<nav class="navbar navbar-expand-sm bg-light">
<div class="container-fluid">
<ul class="navbar-nav">
<li class="nav-item">

<a class="nav-link" href="./">Home</a>
</li>
<li class="nav-item">
<a class="nav-link" href="./even">Even Numbers</a>
</li>
<li class="nav-item">
<a class="nav-link" href="./prime">Prime Numbers</a>
</li>
<li class="nav-item">
<a class="nav-link" href="./multable">Multiplication Table</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="./transcript">transcript</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="./test">test</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="./products">products</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('users.index') }}">Users</a>
</li>
@auth
    <li class="nav-item">
        <a class="nav-link" href="{{ route('books.index') }}">Books</a>
    </li>
@endauth
<li class="nav-item">
    <a class="nav-link" href="{{ route('grades.index') }}">Grades</a>
</li>
</ul>   
    <ul class="navbar-nav ml-auto">
        @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">{{ auth()->user()->name }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('doLogout') }}">Logout</a></li>
        @else
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        @endauth
    </ul>
</div>
</nav>