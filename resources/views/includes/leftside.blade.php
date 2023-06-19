<aside class="main-sidebar sidebar-dark-primary elevation-4">   
    <nav class="m-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @php
            $role = Auth::user()->role;
        @endphp

        <!-- 1 = Admin -->
        @if($role==1)            
            <li class="nav-item">
                <a href="{{ route('doctor.registration') }}" class="nav-link {{ (request()->routeIs('doctor.registration*'))  ? 'active' : '' }}">
                    <i class="fas fa-briefcase-medical nav-icon"></i>                    
                    <p>Add doctor</p>
                </a>
            </li>
            
        <!-- 2 = Doctor -->
        @elseif($role==2)
            <li>                
                <a href="">{{Auth::user()->name}}</a>
            </li>

        <!-- 3 = Patient -->
        @elseif($role==3)
            <li>                
                <a href="">{{Auth::user()->name}}</a>
            </li>
        @endif
        </ul>
    </nav>
</aside>
