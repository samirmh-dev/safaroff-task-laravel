@extends('layouts.admin')

@section('content')
    <section id="istifadeciler">
        <table class="table">
            <thead class="thead-default table-responsive">
            <tr>
                <th>#</th>
                <th>Ad</th>
                <th>Statusu</th>
                <th>E-mail</th>
                <th>Qeydiyyat tarixi</th>
                <th>Adminlik</th>
                <th>Sil</th>
            </tr>
            </thead>
            <tbody>
            @foreach($istifadeciler as $istifadeci)
                <tr>
                    <td>{{$istifadeci['id']}}</td>
                    <td>{{$istifadeci['name']}}</td>
                    <td>{{$istifadeci['isAdmin']?'admin':'istifadeci'}}</td>
                    <td>{{$istifadeci['email']}}</td>
                    <td>{{date('M j Y g:i A', strtotime($istifadeci['created_at']))}}</td>
                    <td>
                        <a href="#" onclick="$(this).find('form').submit()">
                            <button id="deyisdir">
                                {{$istifadeci['isAdmin']?'İstifadəçi et':'Admin et'}}
                            </button>
                            <form action="{{route('istifadeciler.update',['id'=>$istifadeci['id']])}}" method="POST" style="display: none;">
                                {{csrf_field()}}
                                {{method_field('PUT')}}
                                <input type="hidden" name="update" value="{{$istifadeci['isAdmin']?0:1}}">
                            </form>
                        </a>
                    </td>
                    <td>
                        <a href="#" onclick="$(this).find('form').submit()">
                            <button id="sil">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            <form action="{{route('istifadeciler.destroy',['id'=>$istifadeci['id']])}}" method="POST" style="display: none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection