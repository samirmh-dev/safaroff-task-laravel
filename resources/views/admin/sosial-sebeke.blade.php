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
        <form action="{{route('sosial-sebeke-update')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}

            <section class="form-group">
                <label for="facebook" class="form-control-label">Facebook:<button id="" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <div class="input-group mb-2 mb-sm-0">
                    <div class="input-group-addon" style="min-width: 135px;">facebook.com/</div>
                    <input disabled required type="text" class="form-control" name="facebook" id="facebook" value="{{old('facebook')?old('facebook'):App\SosialSebeke::fb()}}" placeholder="Facebook ünvanı">
                </div>
            </section>

            <section class="form-group">
                <label for="twitter" class="form-control-label">Twitter:<button id="" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <div class="input-group mb-2 mb-sm-0">
                    <div class="input-group-addon" style="min-width: 135px;">twitter.com/</div>
                    <input disabled required type="text" class="form-control" name="twitter" id="twitter" value="{{old('twitter')?old('twitter'):App\SosialSebeke::twitter()}}" placeholder="twitter ünvanı">
                </div>
            </section>

            <section class="form-group">
                <label for="github" class="form-control-label">Github:<button id="" type="button" title="Dəyişdirmək üçün klikləyin"><i class="fa fa-pencil" aria-hidden="true" ></i></button></label>
                <div class="input-group mb-2 mb-sm-0">
                    <div class="input-group-addon" style="min-width: 135px;">github.com/</div>
                    <input disabled required type="text" class="form-control" name="github" id="github" value="{{old('github')?old('gihub'):App\SosialSebeke::github()}}" placeholder="Github ünvanı">
                </div>
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
    </script>
@endsection

