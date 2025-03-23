<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">WebSecService</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/transcript">Transcript</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/calculator">Calculator</a>
          </li>
          @auth
        <li class="nav-item">
          <a class="nav-link" href="{{ route('grades.index') }}">Grades</a>
        </li>
        @endauth
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
          <a class="nav-link" href="{{route('products_list')}}">Products</a>
        </li>
        @can('show_users')
        <li class="nav-item">
          <a class="nav-link" href="{{route('users')}}">Users</a>
        </li>
        @endcan
      </ul>
      <ul class="navbar-nav ms-auto">
        @auth
        <li class="nav-item">
          <a class="nav-link" href="{{route('profile')}}">{{auth()->user()->name}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('do_logout')}}">Logout</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="{{route('login')}}">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('register')}}">Register</a>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
