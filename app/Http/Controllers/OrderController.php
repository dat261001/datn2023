<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\orders;
use App\Models\Shiper;
use DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('CheckLoginAdmin');
    }
    public function index()
    {
        $shipers = Shiper::all();
        $data= orders::where('status_id','!=','4')
                ->where('status_id','!=','3')
                ->where('status_id','!=','5')
                ->with('shiper')
                ->latest()->paginate(20);
                // dd($data);
        return view('admin.order.index',['data'=>$data, "shipers" => $shipers]);
    }
    public function cancel()
    {
        $data= orders::where('status_id','=','4')->latest()->paginate(20);
        return view('admin.order.cancel',['data'=>$data]);
    }
    public function check($id)
    {
        orders::find($id)->update([
            'status_id'=>3,
        ]);
        $data= orders::where('status_id','=','3')->latest()->paginate(20);
        return redirect('admin/order/ship')->with(['mess'=>'Đã duyệt đơn ']);
    }

    public function ship()
    {
        $data= orders::where('status_id','=','3')->latest()->paginate(20);
        return view('admin.order.ship',['data'=>$data]);
    }

    public function change_ship(Request $request)
    {
        // return $request->ship_id;
        try {
        // $data = orders::find($request->id);
        $data = orders::find($request->id)->update(["shiper_id" => $request->ship_id]);
        // return $data;
        return response()->json([
                'code'=>200,
                'mess'=>'Đã cập nhật đơn vị vận chuyển',
            ],200);
        } catch(Exception $e){
            Log::error($e->getMessage().'line : '.$e->getLine());
            return response()->json([
                'code'=>500,
                'mess'=>'fail '.$e->getMessage().'line : '.$e->getLine(),
            ],500);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data= orders::where('id','=',$id)->with(['p',"status","shiper"])->first();
        // dd($data);
        // return $data;
        return view('admin.order.show',['data'=>$data]);
    }

    public function count_data()
    {
        $data= orders::where('status_id','!=','4')->where('status_id','!=','3')->count();
        //dd($data);
        // return $data;
        return $data;
    }

    public function statistical()
    {
        $data = orders::where('status_id','=','5')->latest()->paginate(10);

        return view("admin.order.statistical", [
            "count_all_orders" => orders::count(),
            "count_all_orders_this_month" => orders::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', date('Y'))->count(),
            "count_all_orders_ship" => orders::where('status_id','=','3')->count(),
            "count_all_orders_ship_this_month" => orders::where('status_id','=','3')->whereMonth('updated_at', Carbon::now()->month)->whereYear('updated_at', date('Y'))->count(),
            "count_all_orders_done" => orders::where('status_id','=','5')->count(),
            "count_all_orders_done_this_month" => orders::where('status_id','=','5')->whereMonth('updated_at', Carbon::now()->month)->whereYear('updated_at', date('Y'))->count(),
            "money" => $this->formatMoney(orders::where('status_id','=','5')->sum("money")* 1000000),
            "money_this_month" => $this->formatMoney(orders::where('status_id','=','5')->whereMonth('updated_at', Carbon::now()->month)->whereYear('updated_at', date('Y'))->sum("money")* 1000000),
            "data" => $data,
        ]);
    }

    private function formatMoney($number, $fractional=false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function done($id)
    {
        orders::find($id)->update([
            'status_id'=>5,
        ]);
        return redirect()->route("order.statistical")->with(["mess" => "Đơn hàng đã được giao"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            orders::findOrFail($id)->update([
                'status_id'=>4,
            ]);
            return response()->json([
                'code'=>200,
                'mess'=>'Đã hủy đơn thành công ',
            ],200);
            //return redirect('categories')->with('mess',"Đã Xóa ".$data->name);
        } catch(Exception $e){
            Log::error($e->getMessage().'line : '.$e->getLine());
            return response()->json([
                'code'=>500,
                'mess'=>'Delete fail '.$e->getMessage().'line : '.$e->getLine(),
            ],500);
        }
    }
}
