<aside class="main-sidebar sidebar-dark-primary elevation-4" >
   <div class="sidebar">
      <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">
            @php
                $role = Auth::user()->role;
            @endphp
            
            @if($role==1)
                <li>                
                    <a href="">{{Auth::user()->name}}</a>
                </li>
            @elseif($role==2)
                <li>                
                    <a href="">{{Auth::user()->name}}</a>
                </li>
            @elseif($role==3)
                <li>                
                    <a href="">{{Auth::user()->name}}</a>
                </li>
            @endif
         </ul>
      </nav>
   </div>
</aside>
