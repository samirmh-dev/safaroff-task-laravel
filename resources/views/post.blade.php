@extends('layouts.master')

@section('elave-head')
    <title>{{ucfirst(mb_strtolower($post_melumat['basliq']))}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('elave-css-file')
@endsection

@section('elave-css-style')
    <style type="text/css">
        .blur{
            filter:blur(5px);
        }
    </style>
@endsection

@section('elave-js-file')
@endsection

@section('elave-js-script')
    <script>
        $.ajaxSetup({
            beforeSend: function(){
                $('#rey').addClass('blur');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('button#reybildir').click(function () {
           if($('textarea[name=mesaj]').val()!=""){
               $.post('{{route('rey-bildir',['post_id'=>$id])}}',{rey:$('textarea[name=mesaj]').val()},function (data,status) {
                   if(status=="success"){
                       location.reload();
                   }

               }).done(function() {
                   $('textarea[name=mesaj]').parent().find('p').html('<hr><span style="color:#00a651">Rəyiniz əlavə edildi!</span>');
               }).fail(function() {
                   alert( "error" );
               }).always(function() {
                   $('#rey').removeClass('blur');

               });
           }else{
               $('textarea[name=mesaj]').parent().find('p').html('<hr>Rəy yazılmayıb');
           }
        })

    </script>
@endsection

@section('header')
    <header class="masthead" style="background: url('{{asset('src/images/'.$post_melumat["sekil"])}}') center no-repeat fixed; background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="post-heading">
                        <h1>{{ucfirst(mb_strtolower($post_melumat['basliq']))}}</h1>
                        <h2 class="subheading">{{ucfirst(mb_strtolower($post_melumat['qisa_mezmun']))}}</h2>
                        <span class="meta">Posted by
                <a href="#">{{ucfirst(mb_strtolower($post_melumat['yazan']))}}</a>
                on {{$post_melumat['tarix']}}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    {!! $post_melumat['metn'] !!}
                    <hr>
                    <div class="control-group">
                        <h1 style="    font-family: 'Helvetica Neue';margin-bottom: 20px;">Rəylər:</h1>
                        <hr>
                        @if(empty($post_melumat['reyler']))
                            <span style="margin-top:15px;display:block;width: 100%;text-align:center;font-weight: 800;">Rəy yoxdur</span>
                            <hr>
                        @else
                            @foreach($post_melumat['reyler'] as $index=>$rey)
                                <section style="width: 100%;display: flex;flex-direction: column;justify-content:flex-start;align-items:flex-start;">
                                    <section style="display: flex;justify-content:space-between;width: 100%">
                                        <span>#{{$index+1}} - by: <i style="text-decoration:underline;">{{ucfirst(mb_strtolower($rey['rey_yazan']))}}</i></span>
                                        <span><i style="margin-right:8px;" class="fa fa-clock-o" aria-hidden="true"></i>{{date('M j Y H:i', strtotime($rey['tarix']))}}</span>
                                    </section>
                                    <section style="width:100%;min-height: 100px;padding: 10px 15px">
                                        {!! htmlspecialchars_decode($rey['content']) !!}
                                    </section>
                                </section>
                                <hr>
                            @endforeach
                        @endif
                        @guest
                            <span style="margin-top:15px;display:block;width: 100%;text-align:center;">Rəy yazmaq üçün sistemə <a href="{{route('login')}}" style="color:#0085a1">daxil olun</a> və ya <a href="{{route('register')}}" style="color:#0085a1">qeydiyyatdan keçin</a></span>
                        @endguest
                        @auth
                            <section id="rey">
                                <div class="form-group floating-label-form-group controls">
                                    <label>Rəyiniz</label>
                                    <textarea name="mesaj" rows="5" class="form-control" placeholder="Rəyinizi yazın..." id="message" required data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group" style="margin-top: 15px;display: flex;justify-content:flex-end;">
                                    <button style="cursor:pointer" id="reybildir" type="submit" class="btn btn-secondary">RƏY BİLDİR</button>
                                </div>
                            </section>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection