<h2>Hi {{$user->name}}</h2>
<p>Login: {{$user->email}}</p>
<p>Password: {{$password}}</p>
<p>Login by clicking <a href="{{route('login')}}">Here</a> or following link</p>
<a href="{{route('login')}}">{{route('login')}}</a>