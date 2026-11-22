<nav class="user-navbar">

    <a href="{{ route('user.products.index') }}"
       class="{{ request()->routeIs('user.products.*') ? 'active' : '' }}">
        Katalog
    </a>

    <a href="{{ route('user.cart.index') }}"
       class="{{ request()->routeIs('user.cart.*') ? 'active' : '' }}">
        Keranjang
    </a>

    <a href="{{ route('user.orders.index') }}"
       class="{{ request()->routeIs('user.orders.*') ? 'active' : '' }}">
        Riwayat Pesanan
    </a>

    <a href="{{ route('user.account') }}"
       class="{{ request()->routeIs('user.account') ? 'active' : '' }}">
        Akun Saya
    </a>

    <form action="{{ route('user.logout') }}" method="POST">
        @csrf

        <button type="submit" class="user-nav-logout">
            Logout
        </button>
    </form>

</nav>
