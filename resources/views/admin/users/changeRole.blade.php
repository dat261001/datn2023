

@extends('extends.dashboard')

@section('title')
<title>Sửa tài khoản</title>
@endsection

@section('meta')
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="" />
<meta name="keywords" content="">
<meta name="author" content="Codedthemes" />

<link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@endsection

@section('content')
<section class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Sửa tài khoản</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            {{-- <li class="breadcrumb-item"><a href="#">Form Components</a></li> --}}
                            <li class="breadcrumb-item"><a href="{{ route('users.changeRole', ['id' => $data->id]) }}">Sửa tài khoản</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Tài khoản</h5>
                </div>
                <div class="card-body">
                    <div class="col-md-6">
                        <hr>
                        <form action="{{route('users.changeRole', ['id' => $data->id])}}" method="post">
                            @csrf
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Họ và Tên</label>
                                <div class="col-sm-9">
                                    <input type="text" name='name' class="form-control" id="inputEmail3" value="{{ $data->name }}">
                                </div>
                            </div>
                            @if($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name='email' class="form-control" id="inputEmail3" value="{{ $data->email }}">
                                </div>
                            </div>
                            @if($errors->has('email'))
                                <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Quyền</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="role">
                                        @php
                                            $v = 0;
                                        @endphp
                                        @foreach($data->roles as $role)
                                            @if($role->id == 1)
                                                {{$v = 0}}
                                            @elseif($role->id == 2)
                                                {{$v = 1}}
                                            @else
                                                {{$v = 2}}
                                            @endif
                                        @endforeach
                                        <option value="1" @if($v == 0){{"selected"}}@endif>Admin</option>
                                        <option value="3" @if($v == 2){{"selected"}}@endif>Manager</option>
                                        <option value="2" @if($v == 1){{"selected"}}@endif>User</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Xác nhận sửa</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- <div class="card-body">
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
            <div id="liveToast" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="{{asset('assets/images/favicon.ico')}}" class="img-fluid m-r-5" alt="images" style="width:17px;">
                    <strong class="me-auto">Dashboardkit</strong>
                    <small>11 mins ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Hello, world! This is a toast message.
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>
    </div> --}}


    <div class="card-body">


</div>
    </div>



</section>
@endsection
@section('script')
@if(session('mess'))
    <script type="text/javascript">
        console.log('da them')
        alertDone("{{session('title')}}","{{session('mess')}}");
    </script>
@endif
@endsection
