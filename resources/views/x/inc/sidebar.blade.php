<div class="app-sidebar">
    <div class="main-sidemenu">
        <ul class="side-menu">
            <li>
                <a class="side-menu__item has-link" href="{{ route('x.wp') }}">
                    <i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Workplace</span>
                </a>
            </li>
            <li class="sub-category">
                <h3>Route</h3>
            </li>
            <li>
                <a class="side-menu__item has-link" href="{{ route('x.app.index') }}">
                    <i class="side-menu__icon fe fe-airplay"></i><span class="side-menu__label">App</span>
                </a>
            </li>
            <li>
                <a class="side-menu__item has-link" href="{{ route('x.flow.index') }}">
                    <i class="side-menu__icon fe fe-compass"></i><span class="side-menu__label">Web</span>
                </a>
            </li>
            <li>
                <a class="side-menu__item has-link" href="{{ route('x.flow.api') }}">
                    <i class="side-menu__icon fe fe-codepen"></i><span class="side-menu__label">Api</span>
                </a>
            </li>

            <li class="sub-category">
                <h3>Command</h3>
            </li>
            <li>
                <a class="side-menu__item has-link" href="{{ route('x.command.index') }}">
                    <i class="side-menu__icon fe fe-cpu"></i><span class="side-menu__label">Act</span>
                </a>
            </li>
            <li>
                <a class="side-menu__item has-link" href="{{ route('x.command.ui') }}">
                    <i class="side-menu__icon fe fe-layers"></i><span class="side-menu__label">UI</span>
                </a>
            </li>


            <li class="sub-category">
                <h3>Storage</h3>
            </li>
            <li>
                <a class="side-menu__item has-link" href="{{ route('x.schema.index') }}">
                    <i class="side-menu__icon fe fe-package"></i><span class="side-menu__label">Schema</span>
                </a>
            </li>
            <li class="slide is-expanded">

                <a class="side-menu__item active" data-bs-toggle="slide" href="javascript:void(0)">
                    <i class="side-menu__icon fe fe-hard-drive"></i><span class="side-menu__label">Simple</span>
                    <i class="angle fe fe-chevron-right"></i></a>
                <ul class="slide-menu open">
                    <li class="side-menu-label1"><a href="javascript:void(0)">Simple</a></li>
                    <li><a href="{{ route('x.simple.index') }}" class="slide-item"> Label </a></li>
                    <li><a href="{{ route('x.simple.media') }}" class="slide-item"> Media </a></li>
                    <li><a href="{{ route('x.simple.content') }}" class="slide-item"> Content </a></li>
                </ul>
            </li>

            <li class="sub-category">
                <h3>Authentication</h3>
            </li>
            <li>
                <a class="side-menu__item has-link" href="{{ route('x.user.index') }}">
                    <i class="side-menu__icon fe fe-users"></i><span class="side-menu__label">User</span>
                </a>
            </li>

            <li>
                <a class="side-menu__item has-link" href="{{ route('x.role.index') }}">
                    <i class="side-menu__icon fe fe-lock"></i><span class="side-menu__label">Role</span>
                </a>
            </li>
        </ul>
    </div>
</div>
