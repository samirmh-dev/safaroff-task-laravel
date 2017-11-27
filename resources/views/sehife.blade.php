@extends('layouts.master')

@section('elave-head')
    <title>{{ucfirst(mb_strtolower($sehife['sehifebasliq']))}}</title>
@endsection

@section('elave-css-file')
@endsection

@section('elave-css-style')
@endsection

@section('elave-js-file')
@endsection

@section('elave-js-script')
@endsection

@section('header')
    <header class="masthead" style="background-image: url('src/images/{{$sehife['sekil']}}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="page-heading">
                        <h1>{{ucfirst(mb_strtolower($sehife['sehifebasliq']))}}</h1>
                        <span class="subheading">{{ucfirst(mb_strtolower($sehife['qisamezmun']))}}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <section class="container">
        <section class="row">
            <section class="col-lg-8 col-md-10 mx-auto">
                {!! $sehife['content'] !!}
                @if($status = Session::get('status'))
                    <div class="alert alert-info" role="alert">
                        Mesajınız göndərilmişdir! Ən qısa zamanda sizinlə əlaqə qurulacaq.
                    </div>
                @endif
                @if($contact)
                    <form action="{{route('mail')}}" method="POST" name="sentMessage" id="contactForm">
                        {{csrf_field()}}
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Name</label>
                                <input name="ad" type="text" class="form-control" placeholder="Name" id="name" required data-validation-required-message="Please enter your name.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Email Address</label>
                                <input name="email" type="email" class="form-control" placeholder="Email Address" id="email" required data-validation-required-message="Please enter your email address.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Phone Number</label>
                                <input name=telefon type="tel" class="form-control" placeholder="Phone Number" id="phone" required data-validation-required-message="Please enter your phone number.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Message</label>
                                <textarea name="mesaj" rows="5" class="form-control" placeholder="Message" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <br>
                        <div id="success"></div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary" id="sendMessageButton">Göndər</button>
                        </div>
                    </form>
                @endif
            </section>
        </section>
    </section>
@endsection