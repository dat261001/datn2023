

@extends('extends.dashboard')

@section('title')
<title>Danh sách ảnh nền</title>
@endsection

@section('meta')
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="" />
<meta name="keywords" content="">
<meta name="author" content="Codedthemes" />

<link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@endsection

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Danh sách ảnh nền</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Danh sách ảnh nền</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <h5>Danh sách ảnh nền</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-end">
                                <li class="dropdown-item full-card"><a href="#"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                <li class="dropdown-item reload-card"><a href="#"><i class="feather icon-refresh-cw"></i> reload</a></li>
                                <li class="dropdown-item close-card"><a href="#"><i class="feather icon-trash"></i> remove</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ảnh</th>
                                        <th>Tiêu đề</th>
                                        <th>Vị trí hiện</th>
                                        <th>Tính năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $gt=1;
                                    @endphp
@foreach($data as $value)
                                    <tr>
                                        <td>{{$gt++}}</td>
                                        <td>
                                            <div class="img-table">
                                                <a target="_blank" href="{{$value->url}}">
                                                    <img class="img-n" style="width:62px" src="{{asset('assets/banner/'.$value->img)}}">
                                                </a>
                                            </div>
                                        </td>
                                        <td>
{{$value->title}}
                                        </td>

                                        <td>
                                            <div>
                                                {{$value->position}}
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{route('banner.edit',['id'=>$value->id])}}">
                                                <i class="icon feather icon-edit f-16  text-c-green"></i>
                                            </a>
                                            <a href="#" data-url="{{route('banner.delete',['id'=>$value->id])}}" class="action_delete_banner">
                                                <i class="feather icon-trash-2 ms-3 f-16 text-c-red"></i>
                                            </a>
                                        </td>
                                    </tr>
@endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 345px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 237px;"></div></div></div>
                </div>
            </div>

        </div>
    </div>

    @endsection


@section('script')

@if(session('mess'))
    <script type="text/javascript">
        console.log('da them')
        alertDone("{{session('title')}}","{{session('mess')}}");
    </script>
@endif

@endsection
