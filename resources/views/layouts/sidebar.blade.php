<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/dashboard" class="app-brand-link">
            <span class="app-brand-logo demo me-1">
                <span style="color: var(--bs-primary)">
                    <img src="{{ asset('dalam.png') }}" alt="Logo Lab" width="30" height="30">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12.3002 1.25469L56.655 28.6432C59.0349 30.1128 60.4839 32.711 60.4839 35.5089V160.63C60.4839 163.468 58.9941 166.097 56.5603 167.553L12.2055 194.107C8.3836 196.395 3.43136 195.15 1.14435 191.327C0.395485 190.075 0 188.643 0 187.184V8.12039C0 3.66447 3.61061 0.0522461 8.06452 0.0522461C9.56056 0.0522461 11.0271 0.468577 12.3002 1.25469Z"
                        fill="currentColor" />
                    <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 65.2656L60.4839 99.9629V133.979L0 65.2656Z" fill="black" />
                    <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 65.2656L60.4839 99.0795V119.859L0 65.2656Z" fill="black" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M237.71 1.22393L193.355 28.5207C190.97 29.9889 189.516 32.5905 189.516 35.3927V160.631C189.516 163.469 191.006 166.098 193.44 167.555L237.794 194.108C241.616 196.396 246.569 195.151 248.856 191.328C249.605 190.076 250 188.644 250 187.185V8.09597C250 3.64006 246.389 0.027832 241.935 0.027832C240.444 0.027832 238.981 0.441882 237.71 1.22393Z"
                        fill="currentColor" />
                    <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                        d="M250 65.2656L189.516 99.8897V135.006L250 65.2656Z" fill="black" />
                    <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                        d="M250 65.2656L189.516 99.0497V120.886L250 65.2656Z" fill="black" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z"
                        fill="currentColor" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z"
                        fill="white" fill-opacity="0.15" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z"
                        fill="currentColor" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z"
                        fill="white" fill-opacity="0.3" />
                    </svg>
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2" style="font-size: 14px;">Lancar
                Manunggal</span>
        </a>
        {{-- <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="menu-toggle-icon d-xl-block align-middle"></i>
        </a> --}}
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ri-home-smile-line"></i>
                <div data-i18n="Dashboards">Dashboards</div>
                <div class="badge bg-danger rounded-pill ms-auto">5</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/dashboard" class="menu-link">
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/transaksi" class="menu-link">
                        <div data-i18n="CRM">Transaksi</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/produk" class="menu-link">
                        <div data-i18n="CRM">Produk</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/penerimaan" class="menu-link">
                        <div data-i18n="CRM">Penerimaan</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Hanya admin yang bisa melihat menu Master Data --}}
        @if(Auth::user()->role === 'admin')
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ri-layout-2-line"></i>
                <div data-i18n="Layouts">Master Data</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/kategori" class="menu-link">
                        <div data-i18n="Without menu">Kategori</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/produk" class="menu-link">
                        <div data-i18n="Without navbar">Produk</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/supliyer" class="menu-link">
                        <div data-i18n="Container">Supliyer</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/penerimaan" class="menu-link">
                        <div data-i18n="Fluid">Penerimaan</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Manajemen User hanya untuk admin --}}
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ri-shield-keyhole-line"></i>
                <div data-i18n="Front Pages">Manajemen User</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/users" class="menu-link">
                        <div data-i18n="Pricing">Tambah User</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/menus" class="menu-link" target="_blank">
                        <div data-i18n="Payment">Manajemen Menu</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header mt-7">
            <span class="menu-header-text">Apps &amp; Pages</span>
        </li>
        {{-- Log Riwayat hanya untuk admin --}}
        <li class="menu-item">
            <a href="/logs" class="menu-link">
                <i class="menu-icon tf-icons ri-box-3-line"></i>
                <div data-i18n="Email">Log Riwayat</div>
            </a>
        </li>

        {{-- Account Settings hanya untuk admin --}}
        <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ri-layout-left-line"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="pages-account-settings-account.html" class="menu-link">
                        <div data-i18n="Account">Account</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-account-settings-notifications.html" class="menu-link">
                        <div data-i18n="Notifications">Notifications</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-account-settings-connections.html" class="menu-link">
                        <div data-i18n="Connections">Connections</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
    </ul>

</aside>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    let currentUrl = window.location.pathname;
    let menuItems = document.querySelectorAll(".menu-item a");

    menuItems.forEach(function (menuItem) {
        if (menuItem.getAttribute("href") === currentUrl) {
            menuItem.parentElement.classList.add("active");
            let parentMenu = menuItem.closest(".menu-item.open");
            if (parentMenu) {
                parentMenu.classList.add("active", "open");
            }
        }
    });
});

</script>