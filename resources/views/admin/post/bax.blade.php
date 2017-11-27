@extends('layouts.admin')

@section('content')
    <section id="post-bax">
        <a href="{{route('post.yeni')}}">
            <button>
                <i class="fa fa-plus" aria-hidden="true"></i> Yeni post
            </button>
        </a>
        <table class="table">
            <thead class="thead-default">
            <tr>
                <th>#</th>
                <th>Basliq</th>
                <th>Yazan</th>
                <th>Link</th>
                <th>Yazılıb</th>
                <th>Dəyişdirilib</th>
                <th>Bax</th>
                <th>Dəyişdir</th>
                <th>Sil</th>
            </tr>
            </thead>
            <tbody>
                @foreach($postlar as $post)
                    <tr>
                        <td>{{$post['id']}}</td>
                        <td>{{$post['basliq']}}</td>
                        <td>{{$post['yazan']}}</td>
                        <td>/{{$post['link']}}</td>
                        <td>{{date('M j Y g:i A', strtotime($post['created_at']))}}</td>
                        <td>{{date('M j Y g:i A', strtotime($post['updated_at']))}}</td>
                        <td>
                            <a href="{{route('post.goster',['id'=>$post['link']])}}" target="_blank">
                                <button id="goster">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('post.edit',['id'=>$post['id']])}}">
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
                                <form action="{{route('post.sil',['id'=>$post['id']])}}" method="POST" style="display: none;">
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