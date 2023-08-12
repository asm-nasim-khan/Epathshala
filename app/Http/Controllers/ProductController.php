<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\cart;
use App\Models\friend;
use App\Models\bookmark;
use App\Models\Order;
use App\Models\MyCourses;
use App\Models\Coupon;
use App\Models\Offer;





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
        $courses = MyCourses::where('user_id', $data['id'])->get();
        return view('profile',['profile_data'=>$data,'course'=>$courses]);
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
        $orderAll = cart::where('user_id',$userId)->first();
        if (isset($orderAll)) {
            $total= $products= DB::table('saved_tale')
         ->join('products','saved_tale.product_id','=','products.id')
         ->where('saved_tale.user_id',$userId)
         ->sum('products.price');
 
         return view('ordernow',['total'=>$total]);
        } else {
            return redirect('/');
        }
        
        
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

// function myCourse(){
//     if (Session::has('user'))  {
//         $user = session('user'); // Get the logged-in user
//         $userId = $user['id'];
//         $data = MyCourses::where('user_id', $userId)->get();
//         return view('mycourses',['mycourses'=>$data]);
// }
// else{
//     return "Login First....";
// }
// }

function paynow(){
    return view('payment');
}

function offer_push(){
    return view('offer_push');
}

function payment(Request $request){
    // HERE
    $userId=Session::get('user')['id'];
    $allOrder= Order::where('user_id',$userId)->get();
         foreach($allOrder as $cart)
         {
             $order= new MyCourses();
             $order->product_id=$cart['product_id'];
             $order->user_id=$cart['user_id'];
             $order->save();
         }

    
    $request->input();
    return redirect('/complete_payment');
}


function publish_offer(Request $request){
    // HERE
    $order= new Offer();
    $order->coupon_code=$request->input('coupon');
    $order->amount=$request->input('amount');
    $order->save();

    return redirect('/');
}

function voucher(){
    return view('voucher');

}
function complete_payment(){
    return view('complete_payment');

}
function showpdf(){
    return view('billing_invoice');

}

function addvoucher(Request $request){
    // HERE
    $userId=Session::get('user')['id'];
    $order= new Coupon();
    $order->coupon_code=$request->input('coupon');
    $order->user_id=$userId;
    $order->save();
    return redirect('/');

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

function orderplace(Request $request)
    {
        $userId=Session::get('user')['id'];
        $allCart= cart::where('user_id',$userId)->get();
         foreach($allCart as $cart)
         {
             $order= new Order();
             $order->product_id=$cart['product_id'];
             $order->user_id=$cart['user_id'];
             $order->status="pending";
             $order->payment_method=$request->payment;
             $order->payment_status="pending";
             $order->address=$request->address;
             $order->save();
             cart::where('user_id',$userId)->delete(); 
         }
         $request->input();
         return redirect('/paynow');
    }


    function myOrders()
    {
        $userId=Session::get('user')['id'];
        $orders= DB::table('orders')
         ->join('products','orders.product_id','=','products.id')
         ->where('orders.user_id',$userId)
         ->get();
 
         return view('myorders',['orders'=>$orders]);
    }

    function myCourse(){
        
        $userId=Session::get('user')['id'];
        $products= DB::table('my_course')
        ->join('products','my_course.product_id','=','products.id')
        ->where('my_course.user_id',$userId)
        ->select('products.*','my_course.id as cart_id')
        ->get();

        return view('mycourses',['products'=>$products]);
    }
    function voucher_list(){
        
        $allOffer_list= Offer::all();

        return view('voucher_list',['voucher_list'=>$allOffer_list]);
    }
    
}
