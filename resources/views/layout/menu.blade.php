<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item menu-open">
        <a href="{{ route('inicio') }}" class="nav-link active">
            <i class="nav-icon fa-solid fa-house"></i>
            <p>
                Inicio
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-folder-open"></i>
            <p>
                Gestão de Clientes
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('lista_cliente') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Clientes
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Cadastros
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('lista_locais') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Locais</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>
