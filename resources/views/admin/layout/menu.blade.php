    <div class="leftpanelinner" style="">
        <div class="leftpanel-userinfo collapse" id="loguserinfo" aria-expanded="false" style="height: 10px;">
            <h5 class="sidebar-title">Contacto</h5>
            <ul class="list-group">
                <li class="list-group-item">
                    <label class="pull-left"><i class="fa fa-envelope-o"></i></label>
                    <span class="pull-right">{{ substr(Auth::user()->email, 0, 30) }}</span>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="mainmenu">
                <ul class="nav nav-pills nav-stacked nav-quirk">
                    
                    @if(Auth::user()->hasRole('admin'))
                        @can('editar_usuarios')
                        <li class="{{ Request::is('usuarios')  || Request::is('usuarios/*')  ? 'active' : '' }}">
                            <a href="{{ url('usuarios') }}">
                            <i class="fa-solid fa-user"></i> <span>Usuarios</span>
                            </a>
                        </li>             
                        @endcan             
                        @can('editar_roles')
                        <li class="{{ Request::is('roles')  || Request::is('roles/*')  ? 'active' : '' }}">
                            <a href="{{ url('roles') }}">
                            <i class="fa-solid fa-users"></i><span>Grupos</span>
                            </a>
                        </li>               
                        @endcan   

                        @can('editar_permisos')
                        <li class="{{ Request::is('permisos')  || Request::is('permisos/*')  ? 'active' : '' }}">
                            <a href="{{ url('permisos') }}">
                            <i class="fa-solid fa-users"></i><span>Permisos</span>
                            </a>
                        </li>               
                        @endcan   
                        
                        <li class="{{ Request::is('logs') ? 'active' : '' }}">
                            <a href="{{ url('logs') }}">
                            <i class="fa-solid fa-file-contract"></i> <span>Logs</span>
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>

    </div>
</div>