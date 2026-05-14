<style>
    /* Contenedor principal */
    .nav.flex-column {
        padding-right: 8px;
        /* ✅ Espacio para que se vea el border-radius derecho */
    }

    .navbar-item {
        white-space: normal;
        overflow: visible;
        text-overflow: unset;
        word-break: break-word;
        font-size: 0.75em;
        text-align: center;
        justify-content: center;
        padding: 8px 6px;
        text-decoration: none;
        color: white;

        border-radius: 0 8px 8px 0;
        transition:
            background-color 0.25s ease,
            transform 0.25s ease,
            color 0.25s ease;
    }

    .navbar-item:hover {
        color: white;
        background-color: #5d6d7e;
        transform: translateX(4px);
    }

    /* Flecha indicadora de submenú */
    .navbar-item .arrow {
        font-size: 10px;
        transition: transform 0.3s ease;
        margin-left: auto;
        /* ✅ Empuja la flecha al extremo derecho */
    }

    /* Submenú oculto por defecto */
    .submenu {
        list-style: none;
        padding-left: 0;
        padding-right: 0;
        /* ✅ Hereda el padding del padre */
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background-color: rgba(0, 0, 0, 0.15);
        border-radius: 0 0 5px 5px;
        /* ✅ Redondea la parte inferior del bloque */
    }

    .submenu.open {
        max-height: 500px;
    }

    /* Items del submenú con sangría */
    .submenu .navbar-item {
        padding: 6px;
        padding-left: 20px;
        font-size: 0.9em;
        opacity: 0.85;
        border-radius: 0 5px 5px 0;
        /* ✅ Mismo efecto en subitems */
    }

    .submenu .navbar-item:hover {
        opacity: 1;
        background-color: #4a5a6a;
        transform: translateX(4px);
    }

    /* Rotar flecha cuando está abierto */
    .nav-item.open>a .arrow {
        transform: rotate(90deg);
    }
</style>

<ul class="nav flex-column">
    @isset($navigation)
        @foreach ($navigation as $key_nav => $route_nav)
            <li class="nav-item {{ is_array($route_nav) ? 'has-submenu' : '' }}">
                @if (is_array($route_nav))
                    {{-- Tiene submenú --}}
                    <a class="nav-link navbar-item" href="#" data-toggle="submenu">
                        <span>{{ $key_nav }}</span>
                        <span class="arrow">&#9654;</span>
                    </a>
                    <ul class="submenu">
                        @foreach ($route_nav as $sub_key => $sub_route)
                            <li class="nav-item">
                                <a class="nav-link navbar-item" href="{{ $sub_route }}">
                                    {{ $sub_key }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{-- Enlace simple --}}
                    <a class="nav-link navbar-item" href="{{ $route_nav }}">
                        <span>{{ $key_nav }}</span>
                    </a>
                @endif
            </li>
        @endforeach
    @endisset
</ul>

<script>
    document.querySelectorAll('[data-toggle="submenu"]').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();

            const parentLi = this.closest('.nav-item');
            const submenu = parentLi.querySelector('.submenu');
            const isOpen = parentLi.classList.contains('open');

            // Cierra todos los submenús abiertos
            document.querySelectorAll('.nav-item.open').forEach(function(item) {
                item.classList.remove('open');
                item.querySelector('.submenu').classList.remove('open');
            });

            // Abre el actual si estaba cerrado
            if (!isOpen) {
                parentLi.classList.add('open');
                submenu.classList.add('open');
            }
        });
    });
</script>
