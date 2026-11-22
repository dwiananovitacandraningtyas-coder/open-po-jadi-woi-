<nav class="admin-navbar">

    <a href="{{ route('products.index') }}"
       class="{{ request()->routeIs('products.index', 'products.edit') ? 'active' : '' }}">
        Daftar Produk
    </a>

    <a href="{{ route('admin.orders.index') }}"
       class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        Daftar Order
    </a>

    <a href="{{ route('admin.reviews.index') }}"
       class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
        Review
    </a>

    <a href="{{ route('admin.account.index') }}"
       class="{{ request()->routeIs('admin.account.*') ? 'active' : '' }}">
        Akun Admin
    </a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit" class="admin-nav-logout">
            Logout
        </button>
    </form>

</nav>