@extends('layouts.admin')

@section('content')
    @if(!empty($errors->all()))
        <ul style="padding-left: 30px;margin-top: 20px;">
            @foreach($errors->all() as $error)
                <li style="color:red">{{$error}}</li>
            @endforeach
        </ul>
    @endif
    <section class="sehife-edit">
        <form action="{{route('esas-sehife-melumatlari.deyisdir')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}

            <section class="form-group">
                <label for="title" class="form-control-label">Title:<button id="" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <input disabled required type="text" class="form-control" name="title" id="title" value="{{old('title')?old('title'):$sehife['title']}}" placeholder="Səhifə üçün title">
            </section>

            <section class="form-group">
                <label for="sehifebasliq" class="form-control-label">Başlıq:<button id="" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <input disabled required type="text" class="form-control" name="sehifebasliq" id="sehifebasliq" value="{{old('sehifebasliq')?old('sehifebasliq'):$sehife['basliq']}}" placeholder="Səhifə üçün başlıq">
            </section>

            <section class="form-group">
                <label for="qisamezmun" class="form-control-label">Qısa mezmun:<button id="" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <input disabled required type="text" class="form-control" name="qisamezmun" id="qisamezmun" value="{{old('qisamezmun')?old('qisamezmun'):$sehife['qisamezmun']}}" placeholder="Qısa məzmun">
            </section>

            <!--Başlıq fon şəkli-->
            <section class="form-group" style="display: flex;flex-direction: column;justify-content:center;">
                <label for="file2" style="margin-bottom: 0;margin-right: 8px;">Fon üçün şəkil:<button id="file" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true"></i></button></label>
                <img style="width: 300px;height: auto;margin-top:15px;" src="{{asset('src/images/'.$sehife['sekil'])}}" alt="Fon üçün şəkil">
                <label class="custom-file" style="display: none;">
                    <input type="file" id="file2"  class="custom-file-input" name="fon" required disabled>
                    <span class="custom-file-control" data-before="Şəkil seçin"></span>
                </label>
            </section>

            <button type="submit" class="btn btn-primary">Dəyişdir</button>
        </form>
    </section>
@endsection

@section('elave-js-script')

    <script type="text/javascript">

        $('label').find('button').click(function () {
            $(this).parent('label').parent('section').find('input').prop('disabled',false);
            $(this).prop('disabled',true);
        });

        $('#file2').on('change',function () {
            $(this).next('span').attr('data-before',$(this).prop('files')[0]['name']);
        });

        $('#file').click(function () {

            $(this).parent('label').parent('section').css({
                'flex-direction':'row',
                'justify-content':'flex-start',
                'align-items':'center'
            });

            $(this).parent('label')
                .next('img').fadeOut()
                .next('label').show()
                .find('input').prop('disabled',false);

            $(this).prop('disabled',true);
        });
    </script>
@endsection

@section('elave-css-style')
    <style type="text/css">

        /* File secilenden sonra faylin adinin span da yazilmasi ucun */
        .custom-file-control:lang(az):empty::after {
            content: attr(data-before);
            width: 213px;
            height: 20px;
            display: block;
            overflow: hidden;
        }
    </style>
@endsection