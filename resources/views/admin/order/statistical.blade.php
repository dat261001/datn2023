

@extends('extends.dashboard')

@section('title')
<title>Thống kê đơn hàng</title>
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

        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-blue order-card">
                    <div class="card-body">
                        <h6 class="text-white">Tổng đơn hàng</h6>
                        <h2 class="text-end text-white"><i class="feather icon-shopping-cart float-start"></i><span>{{ $count_all_orders }}</span></h2>
                        <p class="m-b-0">Tháng này<span class="float-end">{{ $count_all_orders_this_month }}</span></p>
                    </div>
                </div>
            </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card bg-c-green order-card">
                        <div class="card-body">
                            <h6 class="text-white">Đơn đang giao</h6>
                            <h2 class="text-end text-white"><i class="feather icon-tag float-start"></i><span>{{ $count_all_orders_ship }}</span>
                            </h2>
                            <p class="m-b-0">Tháng này<span class="float-end">{{ $count_all_orders_ship_this_month }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card bg-c-yellow order-card">
                        <div class="card-body">
                            <h6 class="text-white">Đơn đã nhận</h6>
                            <h2 class="text-end text-white"><i class="feather icon-repeat float-start"></i><span>{{ $count_all_orders_done }}</span></h2>
                            <p class="m-b-0">Tháng này<span class="float-end">{{ $count_all_orders_done_this_month }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card bg-c-red order-card">
                        <div class="card-body">
                            <h6 class="text-white">Tiền đã thanh toán</h6>
                            <h2 class="text-end text-white"><i class="feather icon-award float-start"></i><span>{{ $money }}</span></h2>
                            <p class="m-b-0">Tháng này<span class="float-end">{{ $money_this_month }} VNĐ</span></p>
                        </div>
                    </div>
            </div>
        </div>
        {{--  --}}
        <div class="col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <h5>Danh sách các đơn đã nhận</h5>
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
                        {{--  --}}

<div class="table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên khách hàng</th>
                                        <th>Số điện thoại</th>
                                        <th>Ngày lập</th>
                                        <th>Nhận lúc</th>
                                        <th>Tiền</th>
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
                                            {{$value->name}}
                                        </td>
                                         <td>
                                            {{$value->phone_number}}
                                        </td>
                                        <td>
                                            {{$value->created_at}}
                                        </td>
                                        <td>
                                            {{$value->updated_at}}
                                        </td>
                                        <td>{{$value->money}} VNĐ</td>
                                        <td>
                                            <a href="{{route('order.show',['id'=>$value->id])}}">
                                                <i class="fas fa-eye"></i> Xem chi tiết
                                            </a>
                                        </td>
                                    </tr>
@endforeach
                                </tbody>
                            </table>

                        </div>
                        {{--  --}}
                    </div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 345px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 237px;"></div></div></div>
                </div>
            </div>
            {{--  --}}
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
