@extends('layouts.admin')

@section('content')
    @if(!empty($errors->all()))
        <ul style="padding-left: 30px;margin-top: 20px;">
            @foreach($errors->all() as $error)
                <li style="color:red">{{$error}}</li>
            @endforeach
        </ul>

    @endif
    <section class="sehife-create">
        <form action="{{route('sehifeler.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}
            <section class="form-group">
                <label for="ad" class="form-control-label">Ad:</label>
                <input required type="text" class="form-control" name="ad" id="ad" value="{{old('ad')}}" placeholder="Səhifənin adı">
            </section>

            <section class="form-group">
                <label for="link" class="form-control-label">Link:</label>
                <input required type="text" class="form-control" name="link" id="link" value="{{old('link')}}" placeholder="Link">
            </section>

            <section class="form-group">
                <label for="sehifebasliq" class="form-control-label">Başlıq:</label>
                <input required type="text" class="form-control" name="sehifebasliq" id="sehifebasliq" value="{{old('sehifebasliq')}}" placeholder="Başlıq">
            </section>

            <section class="form-group">
                <label for="qisamezmun" class="form-control-label">Qısa mezmun:</label>
                <input required type="text" class="form-control" name="qisamezmun" id="qisamezmun" value="{{old('qisamezmun')}}" placeholder="Qısa məzmun">
            </section>

            <!--Başlıq fon şəkli-->
            <section class="form-group" style="display: flex;align-items: center;">
                <label for="file2" style="margin-bottom: 0;margin-right: 8px;">Fon üçün şəkil:</label>
                <label class="custom-file">
                    <input type="file" id="file2"  class="custom-file-input" name="fon" required >
                    <span class="custom-file-control" data-before="Şəkil seçin"></span>
                </label>
            </section>

            <section class="form-group">
                <label for="content" class="form-control-label">Content:</label>
                <textarea required name="content" id="content" cols="30" rows="10">{{old('content')}}</textarea>
            </section>

            <button type="submit" class="btn btn-primary">Yarat</button>
        </form>
    </section>
@endsection

@section('elave-js-script')
    <script type="text/javascript" src="{{asset('src/ckeditor/ckeditor.js')}}"></script>

    <script type="text/javascript">
        //ckeditor daxiletme
        var content = CKEDITOR.replace('content');

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
        $('button').click(function () {
            var content=editor.getData();
            $('textarea').val(content);
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