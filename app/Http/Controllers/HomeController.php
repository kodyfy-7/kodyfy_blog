<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use Request;
use Validator;
use DB;
use Auth;

use App\Post;
use App\Comment;
use App\Invoice;
use App\User;
use App\Subscription;
use App\SubscriptionDetail;
use App\TargetPoint;
use App\Category;
use App\Withdrawal;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'search', 'category']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('welcome', compact('posts', 'categories'));
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
                $categories = Category::all();
                $comments = Comment::where('post_id', $post->id)->orderBy('id', 'desc')->get();

                return view('post', compact('post', 'comments', 'categories'));
        } else{
            
            $categories = Category::all();
            $comments = Comment::where('post_id', $post->id)->orderBy('id', 'desc')->get();

            return view('post', compact('post', 'comments', 'categories'));
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
        $comment->post_id = Request::input('hidden_id');
        $comment->comment = Request::input('comment');
        $comment->comment_status = 'active';
        $comment->save();

        return redirect()->back()->with('success', 'Comment Created');
    }

    public function search()
    {
        $categories = Category::all();
        $search = Request::input('search');
        $details = Post::where('post_title', 'LIKE', '%'.$search.'%')->orWhere('post_content', 'LIKE', '%'.$search.'%')->paginate(10);
        return view('search', compact('details', 'categories', 'search'));
    }

    public function show_category(Category $category)
    {   
        $categories = Category::all();
        $category = Category::findOrFail($category->id);
        $posts = Post::where('category_id', '=', $category->id)->orderBy('created_at', 'desc')->paginate(10);
        
        return view('category', compact('posts', 'categories', 'category'));
    }

    public function dashboard()
    {
        $reader = auth()->user();
        if($reader->payment_status > 0)
        {
            $subDetail = SubscriptionDetail::whereWhoId($reader->current_sub_id)->whereWhoId($reader->id)->where('task', '=', 'refer')->exists();
            if($subDetail) {
                $points_per_refer = SubscriptionDetail::whereWhoId($reader->current_sub_id)->whereWhoId($reader->id)->where('task', '=', 'refer')->sum('point');
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
            return view('user.dashboard', compact('points_per_refer', 'points_per_post', 'points_total', 'progress_point', 'withdraw_point'));
        } else 
        {
            $points_per_post = 0;
            $points_per_refer = 0;
            $points_total = 0;
            $progress_point = 0;
            $withdraw_point = TargetPoint::first();
            return view('user.dashboard', compact('points_per_refer', 'points_per_post', 'points_total', 'progress_point', 'withdraw_point'));
        }
        
    }

    public function upload_invoice(Request $request)
    {
        $data = Request::validate([
            'payment_invoice' => 'required|image|max:1999'
        ]);

        //Handle file upload
        // Get filename with the extension
        $filenameWithExt = Request::file('payment_invoice')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = Request::file('payment_invoice')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload Image
        $path = Request::file('payment_invoice')->storeAs('public/images/invoices', $fileNameToStore);
        
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
        $data = Request::validate([
            'wallet' => 'required'
        ]);

        //Activate pending payment from user
        $form_data = array(
            'wallet_address'        =>  Request::input('wallet'),
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
            $subDetail = SubscriptionDetail::whereWhoId($reader->current_sub_id)->whereWhoId($reader->id)->where('task', '=', 'refer')->exists();
            if($subDetail) {
                $points_per_refer = SubscriptionDetail::whereWhoId($reader->current_sub_id)->whereWhoId($reader->id)->where('task', '=', 'refer')->sum('point');
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
                
                return view('user.withdraw', compact('withdraw_point', 'withdrawal'));
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

        $withdraw = new Withdrawal;
        $withdraw->user_id = Request::input('hidden_id');
        $withdraw->withdrawal_status = 'unpaid';
        $withdraw->sub_id = Request::input('hidden_subscription');
        $withdraw->withdrawal_ticket = $ticket;
        $withdraw->save();

        //send mail to admin for withdraw request, after withdrawal restart cycle

        return redirect()->back()->with('success', 'You have a pending withdrawal. You will be notified upon approval');
    }


    public function adminHome()
    {
        $eID = auth()->user()->id;
        $posts = Post::whereUserId($eID)->orderBy('id', 'desc')->get();
        $invoices = Invoice::whereInvoiceStatus('unverified')->get();
        $withdrawals = Withdrawal::whereWithdrawalStatus('unpaid')->get();

        $tposts = Post::all();

        return view('admin.index', compact('posts', 'invoices', 'withdrawals', 'tposts'));
    }

    public function view_invoice(Invoice $invoice)
    {
        return view('admin.view_invoice', compact('invoice'));
    }

    public function activate_account(Request $request)
    {
        $acct = Request::input('hidden_user_id');
        $subscription = Subscription::whereUserId($acct)->whereEndAt(null)->first();
        if($subscription){
            //Activate pending payment from user
            $form_data = array(
                'sub_status'        =>  '1'
            );

            Subscription::whereId(Request::input('hidden_subscription'))->update($form_data);

            if(SubscriptionDetail::whereSubscriptionId(Request::input('hidden_subscription'))->whereTask('refer')->exists())
            {
                $target = TargetPoint::first();
                $form_data = array(
                    'point'        =>  $target->refer_task
                );

                SubscriptionDetail::whereSubscriptionId(Request::input('hidden_subscription'))->update($form_data);
            }

            $form_data = array(
                'invoice_status'        =>  'verified'
            );

            Invoice::whereId(Request::input('hidden_invoice_id'))->update($form_data);

            $form_data = array(
                'payment_status'        =>  '1'
            );

            User::whereId(Request::input('hidden_user_id'))->update($form_data);

            return redirect()->back()->with('success', 'Account activated.');

        } else {
            $subsCreate = Subscription::create([
                'user_id' => Request::input('hidden_user_id'),
                'sub_status' => '1'
            ]);

            $form_data = array(
                'invoice_status'        =>  'verified'
            );

            Invoice::whereId(Request::input('hidden_invoice_id'))->update($form_data);

            $form_data = array(
                'payment_status'        =>  '1',
                'current_sub_id' => $subsCreate->id
            );

            User::whereId(Request::input('hidden_user_id'))->update($form_data);

            return redirect()->back()->with('success', 'Account activated.');
        }
        
    }

    public function confirm_payment(Request $request)
    {
        //Activate pending payment from user
        $form_data = array(
            'withdrawal_status'        =>  'paid'
        );

        Withdrawal::whereId(Request::input('hidden_withdrawal'))->update($form_data);

        //reset user cycle
        $form_data = array(
            'sub_status' => 0,
            'end_at' => time()
        );

        Subscription::whereUserId(Request::input('hidden_user'))->whereEndAt(null)->update($form_data);

        $form_data = array(
            'current_sub_id' => null,
            'payment_status' => 0
        );

        User::whereId(Request::input('hidden_user'))->update($form_data);

        //send mail to user
        $data = array(
            'username' => Request::input('hidden_username')
        );
        //Mail::to($request->hidden_email)->send(new SendMailActivateAccountToUser($data));

        return redirect()->back()->with('success', 'Withdrawal confirmed.');
    }

}
