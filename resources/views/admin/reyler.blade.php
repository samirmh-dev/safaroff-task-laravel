@extends('layouts.admin')

@section('content')
    <section id="reyler">
        <table class="table" style="font-size:13px">
            <thead class="thead-default table-responsive">
            <tr>
                <th>#</th>
                <th>Rəy</th>
                <th>Yazan</th>
                <th>Yazılma tarixi</th>
                <th>Posta keç</th>
                <th>Sil</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reyler as $rey)
                <tr>
                    <td>{{$rey->id}}</td>
                    <td>{{substr($rey->content->rey,0,25)}}..</td>
                    <td>{!! $rey->rey_yazan->name !!}</td>
                    <td>{{date('M j Y H:i', strtotime($rey->created_at))}}</td>
                    <td>
                        <a href="{{route('postakec',['id'=>$rey->post->link->link])}}" target="_blank">
                            <button id="goster"> <i class="fa fa-eye" aria-hidden="true"></i></button>
                        </a>
                    </td>
                    <td>
                        <a href="#" onclick="$(this).find('form').submit()">
                            <button id="sil">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            <form action="{{route('reyler-sil',['id'=>$rey->id])}}" method="POST" style="display: none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <section style="width: 100%;display: flex;justify-content:center;align-items:center;">
            {{$reyler->links('vendor.pagination.bootstrap-4')}}
        </section>
    </section>
@endsection