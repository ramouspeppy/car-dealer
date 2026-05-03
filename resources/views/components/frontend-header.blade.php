<header id="header" class="header dark-background d-flex flex-column justify-content-center">
        <i class="header-toggle d-xl-none bi bi-list"></i>

        <div class="header-container d-flex flex-column align-items-start">
            <div class="logo-img">
                <img src="{{ asset(config(" settings.site_logo")) }}" alt="{{ config('settings.site_name') }}"
                    class="img-fluid rounded-circle">
            </div>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/') }}" class="active"><i class="bi bi-house navicon"></i>Home</a></li>
                    <li><a href="{{ route('post.index') }}"><i class="bi bi-person navicon"></i> Berita</a></li>
                    <li><a href="{{ route('testdrive.show') }}"><i class="bi bi-person navicon"></i> TestDrive</a></li>
                    {{-- <li><a href="#resume"><i class="bi bi-file-earmark-text navicon"></i> Resume</a></li>
                    <li><a href="#portfolio"><i class="bi bi-images navicon"></i> Portfolio</a></li> --}}
                    {{-- <li><a href="#services"><i class="bi bi-hdd-stack navicon"></i> Services</a></li>
                    <li class="dropdown"><a href="#"><i class="bi bi-menu-button navicon"></i> <span>Dropdown</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Dropdown 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                        class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="#">Deep Dropdown 1</a></li>
                                    <li><a href="#">Deep Dropdown 2</a></li>
                                    <li><a href="#">Deep Dropdown 3</a></li>
                                    <li><a href="#">Deep Dropdown 4</a></li>
                                    <li><a href="#">Deep Dropdown 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Dropdown 2</a></li>
                            <li><a href="#">Dropdown 3</a></li>
                            <li><a href="#">Dropdown 4</a></li>
                        </ul>
                    </li>
                    <li><a href="#contact"><i class="bi bi-envelope navicon"></i> Contact</a></li> --}}
                </ul>
            </nav>
            <div class="social-links text-center">
                <a target="_blank" href="{{ $profile->wa_url }}"><i class="bi bi-whatsapp"></i></a>
                <a target="_blank" href="{{ $profile->ig_url }}"><i class="bi bi-instagram"></i></a>
                <a target="_blank" href="{{ $profile->fb_url }}"><i class="bi bi-facebook"></i></a>
                <a target="_blank" href="{{ $profile->yt_url }}"><i class="bi bi-youtube"></i></a>
                <a target="_blank" href="{{ $profile->x_url }}"><i class="bi bi-twitter-x"></i></a>
                <a target="_blank" href="{{ $profile->phone_url }}"><i class="bi bi-phone"></i></a>
            </div>
        </div>
    </header>