@extends('layouts.admin')

@section('content')
    @if(!empty($errors->all()))
        <ul style="padding-left: 30px;margin-top: 20px;">
            @foreach($errors->all() as $error)
                <li style="color:red">{{$error}}</li>
            @endforeach
        </ul>

    @endif
    <section id="post-edit">
        <form action="{{route('post.update',['id'=>$id])}}" method="POST" class="form-horizontal" enctype="multipart/form-data" >
            <input type="hidden" name="_method" value="PUT">
            {{csrf_field()}}
            <!--Basliq-->
            <section class="form-group">
                <label for="basliq1" class="form-control-label">Başlıq:<button id="button-basliq" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <input type="text" id="basliq1" class="form-control" placeholder="Başlıq yazın" name="basliq1" required value="{{ $post_melumat['basliq'] }}" disabled>
            </section>

            <!--Basliq2-->
            <section class="form-group">
                <label for="basliq2" class="form-control-label">Qısa məzmun:<button type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <input type="text" id="basliq2" class="form-control" placeholder="Qısa məzmun yazın"  name="basliq2" required value="{{ $post_melumat['qisa_mezmun'] }}" disabled>
            </section>

            <!--Link-->
            <section class="form-group">
                <label for="link" class="form-control-label">Link:<button id="button-link" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true"></i></button></label>
                <div class="input-group mb-2 mb-sm-0">
                    <div class="input-group-addon">{{env('APP_URL')}}/</div>
                    <input type="text" id="link" class="form-control" placeholder="Post üçün link" name="link" required value="{{ $post_melumat['link'] }}" disabled>
                </div>
            </section>

            <!--Başlıq fon şəkli-->
            <section class="form-group" style="display: flex;flex-direction: column;justify-content:center;">
                <label for="file2" style="margin-bottom: 0;margin-right: 8px;">Fon üçün şəkil:<button id="file" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true"></i></button></label>
                <img style="width: 300px;height: auto;margin-top:15px;" src="{{asset('src/images/'.$post_melumat['sekil'])}}" alt="Fon üçün şəkil">
                <label class="custom-file" style="display: none;">
                    <input type="file" id="file2"  class="custom-file-input" name="fon" required disabled>
                    <span class="custom-file-control" data-before="Şəkil seçin"></span>
                </label>
            </section>

            <!--Mətn-->
            <section class="form-group">
                <label for="metn" class="form-control-label">Mətn:<button id="button-metn" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true"></i></button></label>
                <section>
                    {!! htmlspecialchars_decode($post_melumat['metn']) !!}
                </section>
                <textarea name="metn" id="metn" placeholder="Postun mətni" required disabled style="display: none"></textarea>
                <span style="color:red"></span>
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

        //basliq yazilanda avtomatik link duzeltsin
        $('#basliq1').keyup(function () {
            $('#link').val($(this).link_duzelt());
        });

        //link deyisdirilse yeniden duzeltsin
        $('#link').keyup(function () {
            $('#link').val($(this).link_duzelt());
        });

        $('#file2').on('change',function () {
            $(this).next('span').attr('data-before',$(this).prop('files')[0]['name']);
        });

        $('label').find('button:not(#button-metn):not(#file)').click(function () {
            $(this).parent('label').parent('section').find('input').prop('disabled',false);
            $(this).prop('disabled',true);
        });

        $('#button-basliq').click(function () {
            $('input[name=link]').prop('disabled',false);
            $('#button-link').prop('disabled',true);
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

        $('#button-metn').click(function () {
            $(this).parent('label')
                .next('section').hide()
                .next('textarea').prop('disabled',false).text('{!! trim(preg_replace('/\s+/', ' ',htmlspecialchars_decode($post_melumat['metn']))) !!}');
            var editor=CKEDITOR.replace('metn');
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