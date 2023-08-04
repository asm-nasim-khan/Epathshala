<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    //
    function index(){
        return "WELCOME to Product page";
    }
    function home(){
        $data = Product::all();

        return view('product',['products'=>$data]);
    }
    function detail($id){
        $data =  Product::find($id);
        return view('details',['product'=>$data]);
    }
    function search(Request $request){
        
        $query = $request->input('query');
        $data = Product::where('name', 'like', '%' . $query . '%')->get();
    
        return view('search',['products'=>$data]);
    }
}
