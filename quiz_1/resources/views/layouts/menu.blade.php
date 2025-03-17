<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
    <ul class="navbar-nav">
    <li class="nav-item">
    
    <a class="nav-link" href="./">Home</a>
    </li>
    @auth
        <li class="nav-item">
            <a class="nav-link" href="{{ route('books.index') }}">Books</a>
        </li>
    @endauth  
    </ul>
        <ul class="navbar-nav ml-auto">
            @auth
                
                <li class="nav-item"><a class="nav-link" href="{{ route('doLogout') }}">Logout</a></li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
            @endauth
        </ul>
    </div>
    </nav>