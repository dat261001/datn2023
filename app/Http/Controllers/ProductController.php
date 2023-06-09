<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\product_img;
use App\Models\product_infor;
use App\Models\tskt;
use App\Components\cate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
class ProductController extends Controller
{
    private $htmlSlelect = '';

    public function __construct(){
        $this->htmlSlelect ='';
        $this->middleware('CheckLoginAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::latest()->paginate(10);
        return view('admin.product.index',['data'=>$data]);
    }
    public function index1()
    {
        //$data = Product::latest()->get();
        $data = Product::latest()->all();
        dd($data);
    }
    /**
     *
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = category::all();
        $cate = new cate($data);
        $htmlSlelect = $cate->cate('',0,'');
        return view('admin.product.add',['html'=>$htmlSlelect]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        str_replace(" ","_",$request->name);
        Product::create([
            "name" => $request->name,
            "name_file" => $request->name_file,
            "title" => $request->title,
            "hot" => $request->hot,
            "keywords" => $request->keywords,
            "sale_product" => $request->sale_product,
            "des" => $request->des,
            "main_img" => $request->file->getClientOriginalName(),
            "category_id" => $request->parent_id,
            "quantity" => $request->quantity,
            "type" => $request->type,
            "price" => $request->price,
            "review" => $request->review,
            "user_id" => Auth::user()->id
        ]);
        $request->file->move('assets/upload',$request->file->getClientOriginalName());
        $first = Product::latest()->take(1)->get();
        $id = 0;
        foreach($first as $getid){
            $id = $getid->id;
            foreach($request->infor as $value){
                product_infor::create([
                    "name" => $value,
                    "product_id" => $id,
                ]);
            }
        }
        Discount::create([
            'sale'=>$request->discount,
            'sale_time'=>$request->sale_time,
            'product_id'=>$id,
        ]);
        $data = DB::table('product_infor')->where('product_id',$id)->get();
        $option ="";
        foreach($data as $value){
            $option.="<option value='".$value->id."'>".$value->name."</option>";
        }
        foreach($request->file('files') as $value){
            $value->move('assets/upload',$value->getClientOriginalName());
            product_img::create([
                "url_img" => $value->getClientOriginalName(),
                "product_id" => $id,
            ]);
        }
        return view('admin.product.next')->with('option',$option);
    }
    public function nextPost(Request $request){
        for ($i = 0; $i < count($request->name); $i++) {
            tskt::create([
                "name" => $request->name[$i],
                "value" => $request->value[$i],
                "infor_product_id" => $request->id[$i],
            ]);
        }
        return redirect('admin/product')->with('mess','da them')->with('title','Product');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show1()
    {
        return view('admin.product.next');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id)->load("category");
            // dd($product);
            $data = category::all();
            $cate = new cate($data);
            $htmlSelect = $cate->cate($product->category->id ,0,'');

            return view("admin.product.edit", [
                "data" => $product ,
                "html" => $htmlSelect
            ]);
        } catch(Exception $e){

            return redirect('admin/product')->with(["mess"=>"Sản phẩm không tồn tại".$e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            if($request->file('file')) {
                $request->file('file')->move('assets/upload',$request->file('file')->getClientOriginalName());
                product_img::create([
                    "url_img" => $request->file('file')->getClientOriginalName(),
                    "product_id" => $id,
                ]);
                $product = Product::findOrFail($id)->update([
                    "name" => $request->name,
                    "name_file" => $request->name_file,
                    "title" => $request->title,
                    "hot" => $request->hot,
                    "keywords" => $request->keywords,
                    "sale_product" => $request->sale_product,
                    "des" => $request->des,
                    "main_img" => $request->file->getClientOriginalName(),
                    "category_id" => $request->parent_id,
                    "quantity" => $request->quantity,
                    "type" => $request->type,
                    "price" => $request->price,
                    "review" => $request->review,
                    "user_id" => Auth::user()->id
                ]);
            }
            else {
                $product = Product::findOrFail($id)->update([
                    "name" => $request->name,
                    "name_file" => $request->name_file,
                    "title" => $request->title,
                    "hot" => $request->hot,
                    "keywords" => $request->keywords,
                    "sale_product" => $request->sale_product,
                    "des" => $request->des,
                    "category_id" => $request->parent_id,
                    "quantity" => $request->quantity,
                    "type" => $request->type,
                    "price" => $request->price,
                    "review" => $request->review,
                    "user_id" => Auth::user()->id
                ]);
            }
            DB::commit();

            return redirect('admin/product')->with(["mess"=>"Cập nhật thành công !"]);
        } catch(Exception $e){
            DB::rollBack();

            return redirect('admin/product')->with(["mess"=>"Cập nhật không thành công !"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Schema::disableForeignKeyConstraints();
        try {
            $data = Product::findOrFail($request->id);
            Product::findOrFail($request->id)->delete();
            return response()->json([
                'code'=>200,
                'mess'=>'Delete success '.$data->name,
            ],200);
            //return redirect('categories')->with('mess',"Đã Xóa ".$data->name);
        } catch(Exception $e){
            // Log::error($e->getMessage().'line : '.$e->getLine());
            return response()->json([
                'code'=>500,
                'mess'=>'Delete fail '.$e->getMessage().'line : '.$e->getLine(),
            ],500);
        }
    }
}
