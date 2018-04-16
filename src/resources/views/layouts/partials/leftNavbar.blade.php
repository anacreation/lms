<!-- Left Side Of Navbar -->
 <ul class="navbar-nav mr-auto">
    @auth()
		 <li><a class="nav-link {{ Request::is('lessons/catalogue')?'active':''}}"
		        href="{{route('catalogue')}}">@lang('lms::lms.Catalogue')</a></li>
		
		 @authorized("index_user")
		 <li><a class="nav-link {{Request::is('admin/users*')?'active':''}}"
		        href="{{route('users.index')}}">@lang('lms::lms.Users')</a></li>
		 @endauthorized
		
		 @authorized("index_curriculum")
		 <li><a class="nav-link {{Request::is('admin/curricula*')?'active':''}}"
		        href="{{route('curricula.index')}}">@lang('lms::lms.Curricula')</a></li>
		 @endauthorized
		
		
		 @if(Auth::user()->isRole('instructor'))
			 <li class="nav-item dropdown">
			 <a id="navbarDropdown"
			    class="nav-link dropdown-toggle" href="#"
			    role="button" data-toggle="dropdown"
			    aria-haspopup="true" aria-expanded="false">
				 @lang('lms::lms.Instructor')<span class="caret"></span>
			 </a>
 
			 <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			 
			    @authorized("index_lesson")
				 <a class="nav-link {{ Request::is('admin/lessons*')?'active':''}}"
				    href="{{route('lessons.index')}}">@lang('lms::lms.Courses')</a>
				 @endauthorized
				
				 @authorized("index_test")
				 <a class="nav-link {{Request::is('admin/tests*')?'active':''}}"
				    href="{{route('tests.index')}}">@lang('lms::lms.Tests')</a>
				 @endauthorized
			 </div>
        </li>
		 @endif
		
		
		 @if(Auth::user()->hasSubordinates())
			 <li><a class="nav-link {{Request::is('subordinates')?'active':''}}"
			        href="{{route('subordinates')}}">@lang('lms::lms.Subordinates')</a></li>
		 @endif
	 @endauth
 </ul>