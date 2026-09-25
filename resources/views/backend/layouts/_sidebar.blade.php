<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ url('/') }}" target="_blank">{{ config('settings.site_name') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/') }}">St</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>

        <li class="{{ request()->routeIs('backend.home') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('backend.home') }}">
                <i class="far fa-dot-circle"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('backend.profile.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('backend.profile.index') }}">
                <i class="far fa-dot-circle"></i>
                <span>Profile</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('backend.landing-page.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('backend.landing-page.index') }}">
                <i class="fas fa-bullhorn"></i>
                <span>Landing Page (Ads)</span>
            </a>
        </li>
        {{-- Page --}}
        <li class="nav-item dropdown {{ request()->routeIs('backend.header.*', 'backend.testimony.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-th-large"></i>
                <span>Page</span>
            </a>
            <ul class="dropdown-menu">
                <li class="{{ request()->routeIs('backend.header.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.header.index') }}">
                        <i class="far fa-dot-circle ml-0 mr-1"></i>
                        <span>Header</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('backend.testimony.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.testimony.index') }}">
                        <i class="far fa-dot-circle ml-0 mr-1"></i>
                        <span>Testimony</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="{{ request()->routeIs('backend.promo.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('backend.promo.index') }}">
                <i class="far fa-dot-circle"></i>
                <span>Promo</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('backend.service.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('backend.service.index') }}">
                <i class="far fa-dot-circle"></i>
                <span>Layanan</span>
            </a>
        </li>
        {{-- Product --}}
        <li class="nav-item dropdown {{ request()->routeIs('backend.product*', 'backend.product-category.*', 'backend.product-type.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-th-large"></i>
                <span>Product</span>
            </a>
            <ul class="dropdown-menu">
                <li class="{{ request()->routeIs('backend.product-category.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.product-category.index') }}">
                        <i class="far fa-dot-circle ml-0 mr-1"></i>
                        <span>Product Category</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('backend.product.index', 'backend.product.create', 'backend.product.edit', 'backend.product.show') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.product.index') }}">
                        <i class="far fa-dot-circle ml-0 mr-1"></i>
                        <span>Product</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('backend.product-type.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.product-type.index') }}">
                        <i class="far fa-dot-circle ml-0 mr-1"></i>
                        <span>Product Type</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Media Gallery --}}
        <li class="nav-item dropdown {{ request()->routeIs('backend.photo-delivery.*', 'backend.gallery.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-th-large"></i>
                <span>Media Gallery</span>
            </a>
            <ul class="dropdown-menu">
                <li class="{{ request()->routeIs('backend.photo-delivery.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.photo-delivery.index') }}">
                        <i class="far fa-dot-circle"></i>
                        <span>Photo Delivery</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('backend.gallery.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.gallery.index') }}">
                        <i class="far fa-dot-circle"></i>
                        <span>Gallery</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Formulir --}}
        <li class="nav-item dropdown {{ request()->routeIs('backend.testdrive.*', 'backend.contact.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-th-large"></i>
                <span>Formulir</span>
            </a>
            <ul class="dropdown-menu">
                <li class="{{ request()->routeIs('backend.consultation.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.consultation.index') }}">
                        <i class="far fa-dot-circle"></i>
                        <span>Konsultasi</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('backend.testdrive.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.testdrive.index') }}">
                        <i class="far fa-dot-circle"></i>
                        <span>Testdrive</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('backend.contact.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.contact.index') }}">
                        <i class="far fa-dot-circle"></i>
                        <span>Contact</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Post --}}
        <li class="nav-item dropdown {{ request()->routeIs('backend.post.*', 'backend.post-category.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-th-large"></i>
                <span>Post</span>
            </a>
            <ul class="dropdown-menu">
                <li class="{{ request()->routeIs('backend.post-category.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.post-category.index') }}">Post Category</a>
                </li>
                <li class="{{ request()->routeIs('backend.post.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('backend.post.index') }}">Post</a>
                </li>
            </ul>
        </li>

        <li class="{{ request()->routeIs('backend.user.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('backend.user.index') }}">
                <i class="far fa-dot-circle"></i>
                <span>User</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('backend.setting.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('backend.setting.web') }}">
                <i class="far fa-dot-circle"></i>
                <span>Web Setting</span>
            </a>
        </li>
    </ul>
</aside>
