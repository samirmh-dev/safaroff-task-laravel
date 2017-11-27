@extends('layouts.admin')

@section('content')
    <section class="sehife-bax">
        {{--yeni sehife yaratmaq ucun link--}}
        <a href="{{route('sehifeler.create')}}">
            <button>
                <i class="fa fa-plus" aria-hidden="true"></i> Yeni səhifə
            </button>
        </a>
        <table class="table">
            <thead class="thead-default">
            <tr>
                <th>#</th>
                <th>Ad</th>
                <th>Link</th>
                <th>Yaradilib</th>
                <th>Bax</th>
                <th>Dəyişdir</th>
                <th>Sil</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sehifeler as $sehife)
                <tr>
                    <td>{{$sehife['id']}}</td>
                    <td>{{$sehife['ad']}}</td>
                    <td>{{$sehife['link']}}</td>
                    <td>{{date('M j Y g:i A', strtotime($sehife['created_at']))}}</td>
                    <td>
                        <a href="{{env('APP_URL')}}/{{$sehife['link']}}" target="_blank">
                            <button id="goster">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>
                    </td>
                    <td>
                        <a href="{{route('sehifeler.edit',['id'=>$sehife['id']])}}">
                            <button id="deyisdir">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </button>
                        </a>
                    </td>
                    <td>
                        <a href="#" onclick="$(this).find('form').submit()">
                            <button id="sil">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            <form action="{{route('sehifeler.destroy',['id'=>$sehife['id']])}}" method="POST" style="display: none;">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection