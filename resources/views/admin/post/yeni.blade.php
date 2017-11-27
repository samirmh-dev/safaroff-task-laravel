@extends('layouts.admin')


@section('content')
    @if(!empty($errors->all()))
        <ul style="padding-left: 30px;margin-top: 20px;">
        @foreach($errors->all() as $error)
            <li style="color:red">{{$error}}</li>
        @endforeach
        </ul>

    @endif
    <section id="post-yeni">
        <form action="{{route('post.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}
            <!--Basliq-->
            <section class="form-group">
                <label for="basliq1" class="form-control-label">Başlıq:</label>
                <input type="text" id="basliq1" class="form-control" placeholder="Başlıq yazın" name="basliq1" required value="{{ old('basliq1') }}">
            </section>
            <!--Basliq2-->
            <section class="form-group">
                <label for="basliq2" class="form-control-label">Qısa məzmun:</label>
                <input type="text" id="basliq2" class="form-control" placeholder="Qısa məzmun yazın"  name="basliq2" required value="{{ old('basliq2') }}">
            </section>
            <!--Link-->
            <section class="form-group">
                <label for="link" class="form-control-label">Link:</label>
                <div class="input-group mb-2 mb-sm-0">
                    <div class="input-group-addon">{{env('APP_URL')}}/</div>
                    <input type="text" id="link" class="form-control" placeholder="Post üçün link" name="link" required value="{{ old('link') }}">
                </div>
            </section>

            <!--Başlıq fon şəkli-->
            <section class="form-group" style="display: flex;align-items: center;">
                <label for="file2" style="margin-bottom: 0;margin-right: 8px;">Fon üçün şəkil:</label>
                <label class="custom-file">
                    <input type="file" id="file2"  class="custom-file-input" name="fon" required >
                    <span class="custom-file-control" data-before="Şəkil seçin"></span>
                </label>
            </section>

            <!--Mənt-->
            <section class="form-group">
                <label for="metn" class="form-control-label">Mətn:</label>
                <textarea name="metn" id="metn" placeholder="Postun mətni" required >{{ old('metn') }}</textarea>
                <span style="color:red"></span>
            </section>

            <button type="submit" class="btn btn-primary">PAYLAŞ</button>
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

        //basliq yazilanda avtomatik link duzeltsin
        $('#basliq1').keyup(function () {
            $('#link').val($(this).link_duzelt());
        });

        //link deyisdirilse yeniden duzeltsin
        $('#link').keyup(function () {
            $('#link').val($(this).link_duzelt());
        });

        //ckeditor daxiletme
        var editor=CKEDITOR.replace('metn');

        $('button').click(function () {
            var metn=editor.getData();
            $('textarea').val(metn);
        });

        $('#file2').on('change',function () {
            $(this).next('span').attr('data-before',$(this).prop('files')[0]['name']);
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