<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Job;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Order;
use App\Models\Shop;
use App\Models\Review;


use Auth;

class UserController extends Controller
{
    public function index() {
        $users = User::where('role_id', 2)->simplePaginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function user_detail($id) {

        $user          = User::find($id);
        $products      = Product::where('type', 'Product')->where('user_id', $id)->count();
        $services      = Product::where('type', 'Service')->where('user_id', $id)->count();
        $events        = Event::where('user_id', $id)->count();
        $jobs          = Job::where('user_id', $id)->count();
        $subscriptions = Subscription::where('user_id', $id)->count();
        $subs          = Subscription::where('user_id', $id)->first();
        $orders        = Order::where('user_id', $id)->count();
        $shop          = Shop::where('user_id', $id)->first();
        $reviews       = Review::with('owner')->where('tasker', $id)->paginate(10);
        $jobs_list     = Job::where('user_id', $id)->paginate(10);
        $events_list   = Event::where('user_id', $id)->paginate(10);

        if ($user == null) return abort(404);
        return view('admin.users.detail', compact('events_list', 'jobs_list', 'reviews', 'user', 'products', 'services', 'events', 'jobs', 'subscriptions', 'orders', 'shop', 'subs'));
    }

    public function user_wise_products($shop_id) {
        $products = Product::with('product_images')->where('shop_id', $shop_id)->get();
        return view('admin.users.products', compact('products'));
    }
}
