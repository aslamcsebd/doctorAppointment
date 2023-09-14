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
                    <a href="{{ route('patient.list') }}" class="nav-link {{ (request()->routeIs('patient.list'))  ? 'active' : '' }}">
                        <i class="fas fa-user-injured nav-icon"></i>                   
                        <p>Patient list</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('room') }}" class="nav-link {{ (request()->routeIs('room*'))  ? 'active' : '' }}">
                        <i class="fas fa-procedures nav-icon"></i>
                        <p>Room-seat</p>
                    </a>
                </li> 

                <li class="nav-item">
                    <a href="{{ route('new.booking') }}" class="nav-link {{ (request()->routeIs('new.booking*'))  ? 'active' : '' }}">
                        <i class="fas fa-plus-square nav-icon"></i>
                        <p>Add new booking</p>
                    </a>
                </li>   

                <li class="nav-item {{ (request()->routeIs('cabin*'))  ? 'menu-open' : '' }} {{ (request()->routeIs('ward*'))  ? 'menu-open' : '' }}"">
                    <a href="#" class="nav-link {{ (request()->routeIs('cabin*'))  ? 'active' : '' }} {{ (request()->routeIs('ward*'))  ? 'active' : '' }}">
                        <i class="fas fa-bed nav-icon"></i>
                        <p>Booking list<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview pl-3">                       
                        <li class="nav-item">
                            <a href="{{ route('cabin.booking') }}" class="nav-link {{ (request()->routeIs('cabin.booking*'))  ? 'active' : '' }}">
                                <p>Cabin booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ward.booking') }}" class="nav-link {{ (request()->routeIs('ward.booking*'))  ? 'active' : '' }}">
                                <p>Ward booking</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('payment') }}" class="nav-link {{ (request()->routeIs('payment*'))  ? 'active' : '' }}">
                        <i class="fas fa-money-check-alt nav-icon"></i>
                        <p>Payment system</p>
                    </a>
                </li>                
                <li class="nav-item">
                    <a href="{{ route('hospitalInfo') }}" class="nav-link {{ (request()->routeIs('hospitalInfo*'))  ? 'active' : '' }}">
                        <i class="fas fa-user-cog nav-icon"></i>
                        <p>Settings</p>
                    </a>
                </li>

            <!-- 2 = Doctor -->
            @elseif($role==2)

                <li class="nav-item">
                    <a href="{{ route('appointment.request') }}" class="nav-link {{ (request()->routeIs('appointment.request*'))  ? 'active' : '' }}">
                        <i class="fas fa-calendar-check nav-icon"></i>
                        <p>Appointment list</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('patientList') }}" class="nav-link {{ (request()->routeIs('patientList*'))  ? 'active' : '' }}">
                        <i class="fas fa-user-injured nav-icon"></i>
                        <p>Patient list</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('doctorInfo') }}" class="nav-link {{ (request()->routeIs('doctorInfo*'))  ? 'active' : '' }}">
                        <i class="fas fa-user-cog nav-icon"></i>
                        <p>Doctor profile</p>
                    </a>
                </li>  

            <!-- 3 = Patient -->
            @elseif($role==3)

                @if(Auth::user()->password != null)
                    <li class="nav-item">
                        <a href="{{ route('doctor.search') }}" class="nav-link {{ (request()->routeIs('doctor.search*'))  ? 'active' : '' }}">
                            <i class="fas fa-search nav-icon"></i>                    
                            <p>Search doctor</p>
                        </a>
                    </li>                          
                    <li class="nav-item">
                        <a href="{{ route('favourite.list') }}" class="nav-link {{ (request()->routeIs('favourite.list*'))  ? 'active' : '' }}">
                            <i class="fas fa-heart nav-icon"></i>
                            <p>Favourite doctor</p>
                        </a>
                    </li>         
                    <li class="nav-item">
                        <a href="{{ route('appointment.list') }}" class="nav-link {{ (request()->routeIs('appointment.list*'))  ? 'active' : '' }}">
                            <i class="fas fa-calendar-check nav-icon"></i>
                            <p>Appointment list</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('booking') }}" class="nav-link {{ (request()->routeIs('booking*'))  ? 'active' : '' }}">
                            <i class="fas fa-procedures nav-icon"></i>                 
                            <p>Bed booking</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('booked') }}" class="nav-link {{ (request()->routeIs('booked*'))  ? 'active' : '' }}">
                            <i class="fas fa-stream nav-icon"></i>              
                            <p>Booking list</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('report.list') }}" class="nav-link {{ (request()->routeIs('report.list*'))  ? 'active' : '' }}">
                            <i class="fas fa-list-alt nav-icon"></i>                   
                            <p>My all report</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('patientInfo') }}" class="nav-link {{ (request()->routeIs('patientInfo*'))  ? 'active' : '' }}">
                            <i class="fas fa-user-cog nav-icon"></i>
                            <p>Patient profile</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('setPassword') }}" class="nav-link bg-warning {{ (request()->routeIs('setPassword*'))  ? 'active' : '' }}">
                            <i class="fas fa-unlock nav-icon"></i>                    
                            <p>Set password</p>
                        </a>
                    </li>
                @endif

            @endif
        </ul>
    </nav>
</aside>
