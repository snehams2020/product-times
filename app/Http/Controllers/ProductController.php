<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Validator;
class ProductController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $products = Product::orderBy('id','desc')->get();
        return view('product.index', compact('products'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('product.create');
    }
    public function storeData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title'=>'required'
           ]);
           if($validation->passes())
           {

            $insert=Product::create([
                'title'=>$request->title,
                'description'=>$request->description
                ]);
            $id=$insert->id;
            $image = $request->file('main_image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
            $imageUpdate=Product::where('id',$id)
            ->update(['main_image'=>$new_name]);
            if(!empty($request->addMoreInputFields)){
                foreach($request->addMoreInputFields as $var){
                    Variant::create(['title'=>$var['name'],
                    'value'=>$var['value'],
                    'product_id'=>$id
                ]);
                }
            }
            return response()->json([
             'message'   => 'Product added Successfully',
             'status'=>true,
             'status_code'=>200,
             'class_name'  => 'alert-success'
            ]);
        } else
        {
         return response()->json([
          'message'   => $validation->errors()->all(),
          'status'=>false,
          'status_code'=>500,
          'class_name'  => 'alert-danger'
         ]);
        }
}
public function updateData(Request $request)
{
    $validation = Validator::make($request->all(), [
        'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'title'=>'required',
        'id'=>'required'
       ]);
       if($validation->passes())
       {

        $insert=Product::where('id',$request->id)->update([
            'title'=>$request->title,
            'description'=>$request->description
            ]);
        $id=$request->id;
        if($request->hasFile('main_image')){
            $image = $request->file('main_image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
            $imageUpdate=Product::where('id',$id)
            ->update(['main_image'=>$new_name]);
        }
        $delall=Variant::where('product_id',$id)->delete();
        if(!empty($request->addMoreInputFields)){
            foreach($request->addMoreInputFields as $var){
                if(isset($var['name'])){
                Variant::create(['title'=>$var['name'],
                'value'=>$var['value'],
                'product_id'=>$id
            ]);
                }
            }
        }
        return response()->json([
         'message'   => 'Product updated Successfully',
         'status'=>true,
         'status_code'=>200,
         'class_name'  => 'alert-success'
        ]);
    } else
    {
     return response()->json([
      'message'   => $validation->errors()->all(),
      'status'=>false,
      'status_code'=>500,
      'class_name'  => 'alert-danger'
     ]);
    }
}
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function show(Company $company)
    {
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Product  $product
    * @return \Illuminate\Http\Response
    */
    public function edit(Product $product)
    {
        $id= $product->id;
        $products=Product::with('variants')->where('id',$id)->first();
        return view('product.edit',compact('products'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Company $company)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required',
        //     'address' => 'required',
        // ]);

        // $company->fill($request->post())->save();

        // return redirect()->route('products.index')->with('success','Company Has Been updated successfully');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function destroy(Product $product)
    {
        $variant=Variant::where('product_id',$product->id)->delete();
        $Product=Product::where('id',$product->id)->delete();
        return redirect()->route('products.index')->with('success','Product has been deleted successfully');
    }
}
