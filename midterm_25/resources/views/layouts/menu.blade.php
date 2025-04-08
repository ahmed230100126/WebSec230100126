<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Basic Website</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
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
          <a class="nav-link" href="{{ route('products_list') }}">Products</a>
        </li>
        @auth
          <!-- Admin Links -->
          @if(auth()->user()->hasRole('Admin'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('create_employee') }}">Add Employee</a>
            </li>
          @endif

          <!-- Employee Links -->
          @if(auth()->user()->hasAnyRole(['Admin', 'Employee']))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('users.customers') }}">Customers</a>
            </li>
          @endif

          <!-- Customer Links -->
          @if(auth()->user()->hasRole('Customer'))
            <!-- Cart link removed -->
          @endif

          <!-- Orders Link (visible to all authenticated users) -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
          </li>

          @can('show_users')
          <li class="nav-item">
            <a class="nav-link" href="{{ route('users') }}">Users</a>
          </li>
          @endcan
        @endauth
      </ul>
      <ul class="navbar-nav ms-auto">
        @auth
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.profile') }}">{{ auth()->user()->name }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('do_logout') }}">Logout</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">Register</a>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
