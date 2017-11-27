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
        <form action="{{route('sehifeler.update',['id'=>$id])}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <section class="form-group">
                <label for="ad" class="form-control-label">Ad:<button id="button-ad" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <input disabled required type="text" class="form-control" name="ad" id="ad" value="{{old('ad')?old('ad'):$sehife['ad']}}" placeholder="Səhifənin adı">
            </section>

            <section class="form-group">
                <label for="sehifebasliq" class="form-control-label">Başlıq:<button id="" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <input disabled required type="text" class="form-control" name="sehifebasliq" id="sehifebasliq" value="{{old('sehifebasliq')?old('sehifebasliq'):$sehife['sehifebasliq']}}" placeholder="Başlıq">
            </section>

            <section class="form-group">
                <label for="qisamezmun" class="form-control-label">Qısa mezmun:<button id="" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <input disabled required type="text" class="form-control" name="qisamezmun" id="qisamezmun" value="{{old('qisamezmun')?old('qisamezmun'):$sehife['qisamezmun']}}" placeholder="Qısa məzmun">
            </section>

            <section class="form-group">
                <label for="link" class="form-control-label">Link:<button id="button-link" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <input disabled required type="text" class="form-control" name="link" id="link" value="{{old('link')?old('link'):$sehife['link']}}" placeholder="Link">
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

            <section class="form-group">
                <label for="content" class="form-control-label">Content:<button id="button-content" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <section>
                    {!! $sehife['content'] !!}
                </section>
                <textarea disabled style="display: none" required name="content" id="content" cols="30" rows="10">{{old('content')?old('content'):$sehife['content']}}</textarea>
            </section>

            <button type="submit" class="btn btn-primary">Dəyişdir</button>
        </form>
    </section>
@endsection

@section('elave-js-script')
    <script type="text/javascript" src="{{asset('src/ckeditor/ckeditor.js')}}"></script>

    <script type="text/javascript">

        //linkin deyisdirilmesi
        $.fn.link_duzelt=function(){
            var replace_map={
                "ı":"i",
                "I":"i",
                "ə":"e",
                "Ə":"e",
                "ş":"sh",
                "Ş":"sh",
                "ö":"o",
                "Ö":"o",
                "ü":"u",
                "Ü":"u",
                "ç":"ch",
                "Ç":"ch",
                "ğ":"g",
                "Ğ":"g"
            };
            var yeni_link=$(this).val().trim().toLowerCase();
            yeni_link=$.map(yeni_link.split(''),function (str) {
                return replace_map[str] || str;
            }).join('');
            yeni_link=yeni_link.replace(/[^A-Za-z0-9 ]/g,'').replace(/\s/g,'_');
            return yeni_link;
        };

        //ad yazilanda avtomatik link duzeltsin
        $('#ad').keyup(function () {
            $('#link').val($(this).link_duzelt());
        });

        //link deyisdirilse yeniden duzeltsin
        $('#link').keyup(function () {
            $('#link').val($(this).link_duzelt());
        });

        //ckeditor daki metnin textarea ya yerlesdirilmesi
        $('button[type=submit]').click(function () {
            var content=editor.getData();
            $('textarea').val(content);
        });

        $('label').find('button:not(#button-content):not(#button-ad)').click(function () {
            $(this).parent('label').parent('section').find('input').prop('disabled',false);
            $(this).prop('disabled',true);
        });

        $('#button-ad').click(function () {
            $(this).parent('label').parent('section').find('input').prop('disabled',false);
            $(this).prop('disabled',true);
            $('#button-link').parent('label').parent('section').find('input').prop('disabled',false);
            $('#button-link').prop('disabled',true);
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

        $('#button-content').click(function () {
            $(this).parent('label').next('section').hide().next('textarea').prop('disabled',false);
            //ckeditor daxiletme
            var content = CKEDITOR.replace('content');
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