<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use RealRashid\SweetAlert\Facades\Alert;
use Image;
use App\Products;
use DB;
use Session;
use Auth;
use App\User;

class ProductsController extends Controller
{
    public function addProduct(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            $product = new Products;
            $product->name = $data['name'];
            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->price = $data['price'];

            //Upload image
            if($request->hasfile('image')){
                echo $img_tmp = Input::file('image');
                if($img_tmp->isValid()){

                //image path code
                $extension = $img_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $img_path = 'uploads/products/'.$filename;

                //image resize
                Image::make($img_tmp)->resize(500,500)->save($img_path);

                $product->image = $filename;
            }
            }
            $product->save();
            return redirect('/admin/view-products')->with('flash_message_success','Product has been added successfully!!');

        }
        
        return view('admin.products.add_product');
    }
    public function viewProducts(){
        $products = Products::get();
        return view('admin.products.view_products')->with(compact('products'));
    }
    public function editProduct(Request $request,$id=null){
        if($request->isMethod('post')){
             $data = $request->all();
             //Upload image
            if($request->hasfile('image')){
                echo $img_tmp = Input::file('image');
                if($img_tmp->isValid()){

                //image path code
                $extension = $img_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $img_path = 'uploads/products/'.$filename;

                //image resize
                Image::make($img_tmp)->resize(500,500)->save($img_path);

            }
            }else{
                $filename = $data['current_image'];
            }
            
            Products::where(['id'=>$id])->update(['name'=>$data['name'],
           'title'=>$data['title'],'description'=>$data['description'],
           'price'=>$data['price'],
            'image'=>$filename]);
            return redirect('/admin/view-products')->with('flash_message_success','Product has been updated!!');
        }
        $productDetails = Products::where(['id'=>$id])->first();

        return view('admin.products.edit_product')->with(compact('productDetails'));
    }
    public function deleteProduct($id=null){
        Products::where(['id'=>$id])->delete();
        Alert::success('Deleted Successfully', 'Success Message');
        return redirect()->back()->with('flash_message_error','Product Deleted');
    }

}
