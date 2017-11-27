<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">Start Bootstrap</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>
                @foreach(App\Sehifeler::sehifeler() as $sehife)
                    <li class="nav-item">
                        <a class="nav-link" href="{{env('APP_URL')}}/{{$sehife['link']}}">{{$sehife['ad']}}</a>
                    </li>
                @endforeach
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('register')}}">Register</a>
                    </li>
                @endguest
                @auth

                    <li class="nav-item">
                        <a class="nav-link" >Salam, {{Auth::user()->name}}!</a>
                    </li>
                    @if(Auth::user()->isadmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.index')}}" >Admin Panel</a>
                        </li>
                    @endif()
                    <li class="nav-item">
                        <a class="nav-link" href="" onclick="event.preventDefault();$(this).next('form').submit();">Logout</a>
                        <form action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>