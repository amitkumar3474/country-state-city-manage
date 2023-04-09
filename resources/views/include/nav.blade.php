<nav>
    <div class="banner-image">
        <img src="{{ Auth::user()->getFirstMediaUrl('banner_image') }}">
        <div class="user-image">
            <img src="{{ Auth::user()->getFirstMediaUrl('profile_image') }}">
            <h3>{{Auth::user()->name}}</h3>
            <h4>{{Auth::user()->email}}</h4>
        </div>
    </div>
    
    <hr>
    <ul>
        <li><a href="{{route('dashboard')}}"><i class="fa-sharp fa-solid fa-house"></i>Dashboard</a></li>
        @can('user_list')
        <li><a href="#"><i class="fa-solid fa-calendar-days"></i>Events</a></li>
        @endcan
        @can('user_list')
        <li><a href="#"><i class="fa-regular fa-message"></i>Messages</a></li>
        @endcan
        @can('user_list')
        <li><a href="{{route('user.index')}}"><i class="fa fa-user-group"></i>Users</a></li>
        @endcan
        @can('country_list')
            <li><a href="{{ route('country.index')}}"><i class="fa-solid fa-globe"></i>Country</a></li>
        @endcan
        @can('state_list')
            <li><a href="{{ route('state.index')}}"><i class="fa-solid fa-globe"></i>State</a></li>
        @endcan
        @can('city_list')
            <li><a href="{{ route('city.index') }}"><i class="fa-solid fa-globe"></i>City</a></li>
        @endcan
        @can('permission_list')
        <li><a href="{{ route('permissions.index') }}"><i class="fa fa-user-group"></i>Permission</a></li>
        @endcan
        @can('role_list')
        <li><a href="{{ route('roles.index') }}"><i class="fa fa-user-group"></i>Role</a></li>
        @endcan
    </ul>
    <span><a href="{{route('logout')}}"><i class="fa-solid fa-right-from-bracket"></i>Log Out</a></span>
</nav>