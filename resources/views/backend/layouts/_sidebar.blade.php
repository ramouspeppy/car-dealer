<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ url('/') }}" target="_blank">{{ config('settings.site_name') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/') }}">St</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li>
            <a class="nav-link" href="{{ route('backend.home') }}"><i class="far fa-dot-circle"></i> <span>Dashboard</span></a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('backend.profile.index') }}"><i class="far fa-dot-circle"></i>
                <span>Profile</span></a>
        </li>
        <li class="nav-item dropdown ">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i>
                <span>Page</span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="nav-link" href="{{ route('backend.header.index') }}"><i class="far fa-dot-circle  ml-0 mr-1"></i>
                        <span>Header</span></a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('backend.testimony.index') }}"><i
                            class="far fa-dot-circle ml-0 mr-1"></i>
                        <span>Testimony</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown ">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i>
                <span>Product</span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="nav-link" href="{{ route('backend.product-category.index') }}"><i
                            class="far fa-dot-circle ml-0 mr-1"></i>
                        <span>Product Category</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('backend.product.index') }}"><i class="far fa-dot-circle ml-0 mr-1"></i>
                        <span>Product</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('backend.product-type.index') }}"><i
                            class="far fa-dot-circle ml-0 mr-1"></i>
                        <span>Product Type</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="nav-link" href="{{ route('backend.promo.index') }}"><i class="far fa-dot-circle"></i>
                <span>Promo</span>
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('backend.photo-delivery.index') }}"><i class="far fa-dot-circle"></i>
                <span>Photo Delivery</span>
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('backend.testdrive.index') }}"><i class="far fa-dot-circle"></i>
                <span>Testdrive</span>
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('backend.gallery.index') }}"><i class="far fa-dot-circle"></i>
                <span>Gallery</span>
            </a>
        </li>
        <li class="nav-item dropdown ">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i>
                <span>Post</span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="nav-link" href="{{ route('backend.post-category.index') }}">Post Category</a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('backend.post.index') }}">Post</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="nav-link" href="{{ route('backend.contact.index') }}"><i class="far fa-dot-circle"></i>
                <span>Contact</span>
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('backend.user.index') }}"><i class="far fa-dot-circle"></i>
                <span>User</span>
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('backend.setting.web') }}"><i class="far fa-dot-circle"></i>
                <span>Web Setting</span>
            </a>
        </li>
    </ul>
</aside>