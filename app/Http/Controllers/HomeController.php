<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Invoice;
use App\User;
use App\Subscription;
use App\SubscriptionDetail;
use App\TargetPoint;
use App\Category;
use App\Withdrawal;
use Validator;
use DB;
use Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('welcome', compact('posts'));
    }

    public function show(Post $post)
    {
        if(!Auth::guest())
        {
            $reader = auth()->user();
            if($reader->payment_status > 0)
            {
                $subDetail = SubscriptionDetail::whereSubscriptionId($reader->current_sub_id)->wherePostId($post->id)->where('task', '=', 'read')->exists();
                if($subDetail) 
                {
                    $categories = Category::all();
                    $comments = Comment::where('post_id', $post->id)->orderBy('id', 'desc')->get();

                    return view('post', compact('post', 'comments', 'categories'));
                } else
                {
                    $target = TargetPoint::first();
                    SubscriptionDetail::create([
                        'subscription_id' => $reader->current_sub_id,
                        'post_id' => $post->id,
                        'point' => $target->read_task,
                        'task' => 'read'
                    ]);
                    $categories = Category::all();
                    $comments = Comment::where('post_id', $post->id)->orderBy('id', 'desc')->get();

                    return view('post', compact('post', 'comments', 'categories'));
                }
            }
            dd('i dont have an active payment, so i am just gonna read.');
        } else{
            
            dd('i am just a guest');
        }
    }

    public function comment_save(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);

        //Create Comment
        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $request->input('hidden_id');
        $comment->comment = $request->input('comment');
        $comment->comment_status = 'active';
        $comment->save();

        return redirect()->back()->with('success', 'Comment Created');
    }

    public function dashboard()
    {
        $reader = auth()->user();
        if($reader->payment_status > 0)
        {
            $subDetail = SubscriptionDetail::whereWhoSubId($reader->current_sub_id)->whereWhoId($reader->id)->where('task', '=', 'refer')->exists();
            if($subDetail) {
                $points_per_refer = SubscriptionDetail::whereWhoSubId($reader->current_sub_id)->whereWhoId($reader->id)->where('task', '=', 'refer')->sum('point');
            } else {
                $points_per_refer = 0;
            }

            $subDetail1 = SubscriptionDetail::whereSubscriptionId($reader->current_sub_id)->where('task', '=', 'read')->exists();
            if($subDetail1) {
                $points_per_post = SubscriptionDetail::whereSubscriptionId($reader->current_sub_id)->where('task', '=', 'read')->sum('point');
            } else {
                $points_per_post = 0;
            }

            $points_total = $points_per_post + $points_per_refer;
            $b = 10;

            $progress_point = $points_total / $b;
            $withdraw_point = TargetPoint::first();
            return view('home', compact('points_per_refer', 'points_per_post', 'points_total', 'progress_point', 'withdraw_point'));
        } else 
        {
            $points_per_post = 0;
            $points_per_refer = 0;
            $points_total = 0;
            $progress_point = 0;
            $withdraw_point = TargetPoint::first();
            return view('home', compact('points_per_refer', 'points_per_post', 'points_total', 'progress_point', 'withdraw_point'));
        }
        
    }

    public function upload_invoice(Request $request)
    {
        $this->validate($request, [
            'payment_invoice' => 'required|image|max:1999'
        ]);

        //Handle file upload
        // Get filename with the extension
        $filenameWithExt = $request->file('payment_invoice')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->file('payment_invoice')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload Image
        $path = $request->file('payment_invoice')->storeAs('public/invoices', $fileNameToStore);
        
        $var = 'ba';
        $name = Str::kebab(auth()->user()->name);
        $ticket = $var.'_'.$name.'_'.time();

        //Create Invoice
        $invoice = new Invoice;
        $invoice->invoice_file = $fileNameToStore;
        $invoice->user_id = auth()->user()->id;
        $invoice->invoice_status = 'unverified';
        $invoice->invoice_ticket = $ticket;
        $invoice->save();

        return redirect()->back()->with('success', 'File Uploaded, you will get a mail once verified.');
    }

    public function save_wallet(Request $request)
    {
        $this->validate($request, [
            'wallet' => 'required'
        ]);

        //Activate pending payment from user
        $form_data = array(
            'wallet_address'        =>  $request->wallet,
        );

        User::whereId(auth()->user()->id)->update($form_data);

        return redirect()->back()->with('success', 'Your wallet address has been saved successfully.');
    }

    public function withdraw()
    {
        $withdraw_point = TargetPoint::first();
        $reader = auth()->user();
        if($reader->payment_status > 0)
        {
            $subDetail = SubscriptionDetail::whereWhoSubId($reader->current_sub_id)->whereWhoId($reader->id)->where('task', '=', 'refer')->exists();
            if($subDetail) {
                $points_per_refer = SubscriptionDetail::whereWhoSubId($reader->current_sub_id)->whereWhoId($reader->id)->where('task', '=', 'refer')->sum('point');
            } else {
                $points_per_refer = 0;
            }

            $subDetail1 = SubscriptionDetail::whereSubscriptionId($reader->current_sub_id)->where('task', '=', 'read')->exists();
            if($subDetail1) {
                $points_per_post = SubscriptionDetail::whereSubscriptionId($reader->current_sub_id)->where('task', '=', 'read')->sum('point');
            } else {
                $points_per_post = 0;
            }

            $points_total = $points_per_post + $points_per_refer;
            $b = 10;

            $progress_point = $points_total / $b;
            if($points_total < $withdraw_point->target){
                return redirect()->back()->with('error', 'You have not reached withdrawal limit.'); 
            } else{
                
                $withdrawal = Withdrawal::where('user_id', '=', $reader->id)->where('sub_id', '=', $reader->current_sub_id)->whereWithdrawalStatus('unpaid')->orderBy('id', 'desc')->first();

                //$wallet_address = Wallet::where('user_id', '=', 1)->first();

                
                return view('withdraw', compact('withdraw_point', 'withdrawal'));
            }
        } else 
        {
            return redirect()->back()->with('error', 'You have no active subscription.');
        }
    }

    public function withdrawal(Request $request)
    {
        $var = 'ba';
        $name = Str::kebab(auth()->user()->name);
        $ticket = $var.'_'.$name.'_'.time();

        /*$withdraw = new Withdrawal;
        $withdraw->user_id = $request->input('hidden_id');
        $withdraw->withdrawal_status = 'unpaid';
        $withdraw->subscription_id = $request->input('hidden_subscription');
        $withdraw->withdrawal_ticket = $ticket;
        $withdraw->save();*/

        withdrawal::create([
            'user_id' => $request->input('hidden_id'),
            'withdrawal_status' => 'unpaid',
            'sub_id' => $request->input('hidden_subscription'),
            'withdrawal_ticket' => $ticket
        ]);

        //send mail to admin for withdraw request, after withdrawal restart cycle

        return redirect()->back()->with('success', 'You have a pending withdrawal. You will be notified upon approval');
    }


    public function adminHome()
    {
        $eID = auth()->user()->id;
        $posts = Post::whereUserId($eID)->orderBy('id', 'desc')->get();
        $invoices = Invoice::whereInvoiceStatus('unverified')->get();
        return view('admin.index', compact('posts', 'invoices'));
    }

    public function view_invoice(Invoice $invoice)
    {
        return view('admin.view_invoice', compact('invoice'));
    }

    public function activate_account(Request $request)
    {
        //Activate pending payment from user
        $form_data = array(
            'sub_status'        =>  '1'
        );

        Subscription::whereId($request->hidden_subscription)->update($form_data);

        if(SubscriptionDetail::whereSubscriptionId($request->hidden_subscription)->whereTask('refer')->exists())
        {
            $target = TargetPoint::first();
            $form_data = array(
                'point'        =>  $target->refer_task
            );

            SubscriptionDetail::whereSubscriptionId($request->hidden_subscription)->update($form_data);
        }

        $form_data = array(
            'invoice_status'        =>  'verified'
        );

        Invoice::whereId($request->hidden_invoice_id)->update($form_data);

        $form_data = array(
            'payment_status'        =>  '1'
        );

        User::whereId($request->hidden_user_id)->update($form_data);

        return redirect()->back()->with('success', 'Account activated.');
    }

}
