<!-- Right side Of Navbar -->
 <ul class="navbar-nav ml-auto">
    <!-- Authentication Links -->
	 @guest
		 <li><a class="nav-link"
		        href="{{ route('login') }}">@lang("lms::lms.Login")</a></li>
		 <li><a class="nav-link"
		        href="{{ route('register') }}">>@lang("lms::lms.Register")</a></li>
	 @else
		 <li class="nav-item dropdown">
            <a id="navbarDropdown"
               class="nav-link dropdown-toggle" href="#"
               role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }} <span
			            class="caret"></span>
            </a>
        
            <div class="dropdown-menu"
                 aria-labelledby="navbarDropdown">
                <a href="{{route('my.info')}}"
                   class="dropdown-item">@lang("lms::lms.Profile")</a>
                <a href="{{route('my.courses')}}"
                   class="dropdown-item">@lang("lms::lms.My_Courses")</a>
                <a class="dropdown-item"
                   href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                @lang("lms::lms.Logout")
                </a>
            
                <form id="logout-form"
                      action="{{ route('logout') }}"
                      method="POST" style="display: none;">
            {{csrf_field()}}
            </form>
            </div>
        </li>
	 @endguest
</ul>