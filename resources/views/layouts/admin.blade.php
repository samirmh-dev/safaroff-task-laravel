<!DOCTYPE html>
<html lang="az">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Paneli</title>
        <!--Bootstrap 4 beta1 CSS-->
        <link rel="stylesheet" href="{{asset('src/css/bootstrap.min.css')}}">
        <!--Font Awesome CSS-->
        <link rel="stylesheet" href="{{asset('src/font-awesome/css/font-awesome.css')}}">

        <link rel="stylesheet" href="{{asset('src/css/admin.css')}}">


        @yield('elave-css-style')
    </head>
    <body>
       <section id="solpanel">
            <section id="logo">
                <a href="{{route('admin.index')}}">Admin Paneli</a>
                <section id="hamburgermenyusu">
                    <span></span>
                    <span></span>
                    <span></span>
                </section>
            </section>
           <ul id="menyu">
               <li><a href="{{route('esas-sehife-melumatlari.index')}}"><i class="fa fa-home " aria-hidden="true"></i>Əsas səhifə məlumatları</a></li>
               <li><a href="{{route('sehifeler.index')}}"><i class="fa fa-list-alt " aria-hidden="true"></i>Səhifələr</a></li>
               <li><a href="{{route('post.bax')}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Postlar</a></li>
               <li><a href="{{route('reyler-baxis')}}"><i class="fa fa-comments" aria-hidden="true"></i>Rəylər</a></li>
               <li><a href="{{route('sosial-sebeke-edit')}}"><i class="fa fa-facebook-official" aria-hidden="true"></i>Sosial şəbəkə</a></li>
               <li><a href="{{route('istifadeciler.index')}}"><i class="fa fa-user" aria-hidden="true"></i>İstifadəçilər</a></li>
           </ul>
       </section>
        <section id="sagpanel">
            <section id="basliq">
                <section style="display: flex; align-items:center;">
                    <a href="#"><i class="fa fa-user-circle-o" aria-hidden="true"></i>Salam, {{ucfirst(mb_strtolower(Auth::user()->name))}}!</a>
                    <a href="{{route('home')}}" style="margin-left: 25px;"><i class="fa fa-home " aria-hidden="true"></i> Səhifəyə qayıt</a>
                </section>
                <a onclick="event.preventDefault();$(this).next('form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i>Çıxış</a>
                <form action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </section>
            @yield('content')
        </section>
       <!--JQuery kitabxanasi-->
       <script type="text/javascript" src="{{asset('src/js/jquery.min.js')}}"></script>
       <!--Popper JS (bootstrap ucun)-->
       <script type="text/javascript" src="{{asset('src/js/popper.min.js')}}"></script>
       <!--Bootstarp 4 beta1 JS-->
       <script type="text/javascript" src="{{asset('src/js/bootstrap.min.js')}}"></script>
       <script type="text/javascript">
           $("#hamburgermenyusu").click(function () {
              $('#menyu').slideToggle();
           });
       </script>
        @yield('elave-js-script')
    </body>
</html>