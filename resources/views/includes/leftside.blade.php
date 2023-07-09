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
            <li class="nav-item">
                <a href="{{ route('doctor.list') }}" class="nav-link {{ (request()->routeIs('doctor.list*'))  ? 'active' : '' }}">
                    <i class="fas fa-user-md nav-icon"></i>              
                    <p>Doctor list</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('room') }}" class="nav-link {{ (request()->routeIs('room*'))  ? 'active' : '' }}">
                    <!-- <i class="fas fa-bed nav-icon"></i> -->
                    <i class="fas fa-procedures nav-icon"></i>
                    <p>Room-seat</p>
                </a>
            </li>   
            <li class="nav-item">
                <a href="{{ route('payment') }}" class="nav-link {{ (request()->routeIs('payment*'))  ? 'active' : '' }}">
                    <i class="fas fa-money-check-alt nav-icon"></i>
                    <p>Payment system</p>
                </a>
            </li>            
        <!-- 2 = Doctor -->
        @elseif($role==2)
            <li>                
                <a href="">{{Auth::user()->name}}</a>
            </li>

        <!-- 3 = Patient -->
        @elseif($role==3)
            <li class="nav-item">
                <a href="{{ route('doctor.search') }}" class="nav-link {{ (request()->routeIs('doctor.search*'))  ? 'active' : '' }}">
                    <i class="fas fa-search nav-icon"></i>                    
                    <p>Search doctor</p>
                </a>
            </li>

            @if($favourite = \App\Models\FavouriteDoctor::where('patient_id', Auth::id())->count())            
                <li class="nav-item">
                    <a href="{{ route('favourite.list') }}" class="nav-link {{ (request()->routeIs('favourite.list*'))  ? 'active' : '' }}">
                        <i class="fas fa-heart nav-icon"></i>
                        <p>Favourite doctor ({{$favourite}})</p>
                    </a>
                </li>
            @endif
        @endif
        </ul>
    </nav>
</aside>
