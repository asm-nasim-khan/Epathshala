<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\cart;
use App\Models\friend;
use App\Models\bookmark;

use App\Models\User;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


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

    function profile($id){
        $data =  User::find($id);
        return view('profile',['profile'=>$data]);
    }
    function userProfile($id){
        $data =  User::find($id);
        return view('userProfile',['userProfile'=>$data]);
    }
    function search(Request $request){
        
        $query = $request->input('query');
        $data = Product::where('name', 'like', '%' . $query . '%')->get();
    
        return view('search',['products'=>$data]);
    }

    function cartList(){
        
        $userId=Session::get('user')['id'];
        $products= DB::table('saved_tale')
        ->join('products','saved_tale.product_id','=','products.id')
        ->where('saved_tale.user_id',$userId)
        ->select('products.*','saved_tale.id as cart_id')
        ->get();

        return view('cart',['products'=>$products]);
    }

    function bookmark(){
        
        $userId=Session::get('user')['id'];
        $products= DB::table('bookmark')
        ->join('products','bookmark.product_id','=','products.id')
        ->where('bookmark.user_id',$userId)
        ->select('products.*','bookmark.id as cart_id')
        ->get();

        return view('bookmark',['products'=>$products]);
    }
    function removeCart($id)
    {
        cart::destroy($id);
        return redirect('cartlist');
    }
    function removefriend($id)
    {
        friend::destroy($id);
        return redirect('friends');
    }
    function removebookmark($id)
    {
        bookmark::destroy($id);
        return redirect('bookmark');
    }

    function orderNow()
    {
        $userId=Session::get('user')['id'];
        $total= $products= DB::table('cart')
         ->join('products','cart.product_id','=','products.id')
         ->where('cart.user_id',$userId)
         ->sum('products.price');
 
         return view('ordernow',['total'=>$total]);
    }
    
    
    

    function Addcart(Request $request){
        if($request->session()->has('user')){
            $cart = new cart();
            $cart->user_id = $request->session()->get('user')['id'];
            $cart->product_id = $request->input('product_id');
            $cart->save();

            return redirect('/');
        }
        else{
            return redirect('/login');
        }
    
        
    }
    function Addbookmark(Request $request){
        if($request->session()->has('user')){
            $cart = new bookmark();
            $cart->user_id = $request->session()->get('user')['id'];
            $cart->product_id = $request->input('product_id');
            $cart->save();

            return redirect('/');
        }
        else{
            return redirect('/login');
        }
    
        
    }

    public static function cart_item($userId) {
        $cartItemCount = cart::where('user_id', $userId)->count();
        return $cartItemCount;
    }
    
    function friends(){
        if (Session::has('user'))  {
            $user = session('user'); // Get the logged-in user
            $userId = $user['id'];
            $data = friend::where('user_id', $userId)->get();
            return view('friend_list',['friend_list'=>$data]);
    }
    else{
        return "Login First....";
    }
}

function Addfriend(Request $request){
    if($request->session()->has('user')){
        $friend = new friend();
        $friend->user_id = $request->session()->get('user')['id'];
        $friend->email = $request->input('email');
        $friend->save();

        return redirect('/');
    }
    else{
        return redirect('/login');
    }

    
}
function searchFriends(Request $request){
        
    $query = $request->input('query');
    $data = User::where('email', 'like', '%' . $query . '%')->get();

    return view('searchFriend',['searchFriend'=>$data]);
}
    
}
