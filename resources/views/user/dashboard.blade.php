@extends('layouts.dashboard_app')

@section('title')
    Dashboard | BlogApp 
@endsection

@section('page_title')
    Dashboard
@endsection

@section('content')

  @if ( Auth::user()->payment_status > 0 )
    <!-- top tiles -->
    <div class="row top_tiles">
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-external-link"></i>
          </div>
          <div class="count">&NonBreakingSpace;</div>

          <h3>Referral Link</h3>
          <p>{{ Auth::user()->referral_link }}</p>
        </div>
      </div>
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-user"></i>
          </div>
          <div class="count">&NonBreakingSpace;</div>

          <h3>Referrer</h3>
          <p>{{ Auth::user()->referrer->name ?? 'Not Specified' }}</p>
        </div>
      </div>
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-sort-amount-desc"></i>
          </div>
          <div class="count">{{count(Auth::user()->referrals) ?? '0'}}</div>

          <h3>New Sign ups</h3>
          <p>&NonBreakingSpace;</p>
        </div>
      </div>
    </div>

    <div class="row top_tiles">
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-sitemap"></i>
          </div>
          <div class="count">{{ $points_per_refer }}</div>

          <h3>Referral Points</h3>
          <p>&NonBreakingSpace;</p>
        </div>
      </div>
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-tasks"></i>
          </div>
          <div class="count">{{ $points_per_post }}</div>

          <h3>Task Points</h3>
          <p>&NonBreakingSpace;</p>
        </div>
      </div>
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-trophy"></i>
          </div>
          <div class="count">{{ $points_total }}</div>

          <h3>Total Points</h3>
          <p>&NonBreakingSpace;</p>
        </div>
      </div>
    </div>
    <!-- /top tiles -->

    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel tile fixed_height_320">
          <div class="x_title">
            <h2>My Profile</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="profile-tab" role="tab" data-toggle="tab" aria-expanded="true">Profile</a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="wallet" data-toggle="tab" aria-expanded="false">Wallet Address</a>
                </li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="profile-tab">
                  <p>
                    Username: {{auth()->user()->username}}
                    <br>
                    Email Address: {{auth()->user()->email}}
                  </p>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="wallet">
                  <p>
                    @if (is_null(auth()->user()->wallet_address))
                      {!! Form::open(['action' => ['HomeController@save_wallet',Auth::user()->id], 'id' => 'payment_data_form', 'method' =>'POST', 'class' => 'form-horizontal form-label-left']) !!}
                          <div class="form-group">
                            {{Form::label('wallet', 'Input your Etherum wallet address', ['class' => 'col-sm-3 control-label'])}}
                            <div class="col-sm-9">
                              <div class="input-group">
                                {{Form::text('wallet', '', ['id' => 'wallet', 'class' => 'form-control', 'placeholder' => ''])}}  
                                <span class="input-group-btn">
                                  {{Form::submit('Save', ['id' => 'payment_action_button', 'class' => 'btn btn-success btn-block'])}}
                                </span>
                              </div>
                            </div>
                          </div> 
                      {!! Form::close() !!}    
                    @else
                        Wallet Address: {{auth()->user()->wallet_address}}
                    @endif
                  </p>
                </div>
              </div>
            </div>
  
  
          </div>
        </div>
      </div>

      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel tile fixed_height_320">
          <div class="x_title">
            <h2>My track</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <h4>When points reach {{$withdraw_point->target}}, you would be awarded your coins.</h4>

            <div class="widget_summary">
              <div class="w_left w_25">
                
              </div>
              <div class="w_center w_55">
  
                <div class="progress">
                  <div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ $progress_point }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progress_point }}%;">
                    <span class="sr-only">{{$points_total}}</span>
                  </div>
                </div>
              </div>
              <div class="w_right w_20">
                <span>{{$points_total}}</span>
              </div>
              <div class="clearfix"></div>
            </div>
  
            <div class="widget_summary">
              <div class="w_left w_25">
  
              </div>
              <div class="w_center w_55">
                @if ($points_total >= $withdraw_point->target)
                  @if (is_null(auth()->user()->wallet_address))
                    <a href="" class="btn btn-warning">You have not saved a wallet address</a>
                  @else
                    <a href="{{route('dashboard.withdraw')}}" class="btn btn-success">Process withdrawal</a>
                  @endif
                @endif
              </div>
              <div class="w_right w_20">
                
                
              </div>
              <div class="clearfix"></div>
            </div>
  
          </div>
        </div>
      </div>
    </div>

  @else
    <div class="bs-example" data-example-id="simple-jumbotron">
      <div class="jumbotron">
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <strong>Oops!!!</strong> You do not have an active subscription. Use the button below to get started.
        </div>

        <div class="row">
          <div class="col-md-8 offset-md-2">
            @php
            $array = array(array('metaname' => 'color', 'metavalue' => 'blue'),
                            array('metaname' => 'size', 'metavalue' => 'big'));
            @endphp
            <form method="POST" action="{{ route('pay') }}" id="paymentForm">
                {{ csrf_field() }}
                <input type="hidden" name="amount" value="1500" /> <!-- Replace the value with your transaction amount -->
                <input type="hidden" name="payment_method" value="both" /> <!-- Can be card, account, both -->
                <input type="hidden" name="description" value="Subscription" /> <!-- Replace the value with your transaction description -->
                <input type="hidden" name="country" value="NG" /> <!-- Replace the value with your transaction country -->
                <input type="hidden" name="currency" value="NGN" /> <!-- Replace the value with your transaction currency -->
                <input type="hidden" name="email" value="{{ auth()->user()->email }}" /> <!-- Replace the value with your customer email -->
                <input type="hidden" name="firstname" value="{{ auth()->user()->name }}" /> <!-- Replace the value with your customer firstname -->
                <input type="hidden" name="lastname" value="Adebiyi" /> <!-- Replace the value with your customer lastname -->
                <input type="hidden" name="metadata" value="{{ json_encode($array) }}" > <!-- Meta data that might be needed to be passed to the Rave Payment Gateway -->
                <input type="hidden" name="phonenumber" value="090929992892" /> <!-- Replace the value with your customer phonenumber -->
                {{-- <input type="hidden" name="paymentplan" value="362" /> <!-- Ucomment and Replace the value with the payment plan id --> --}}
                {{-- <input type="hidden" name="ref" value="MY_NAME_5uwh2a2a7f270ac98" /> <!-- Ucomment and  Replace the value with your transaction reference. It must be unique per transaction. You can delete this line if you want one to be generated for you. --> --}}
                {{-- <input type="hidden" name="logo" value="https://pbs.twimg.com/profile_images/915859962554929153/jnVxGxVj.jpg" /> <!-- Replace the value with your logo url (Optional, present in .env)--> --}}
                {{-- <input type="hidden" name="title" value="Flamez Co" /> <!-- Replace the value with your transaction title (Optional, present in .env) --> --}}
                <input type="submit" value="Pay"  />
            </form>

            {!! Form::open(['action' => ['HomeController@upload_invoice',Auth::user()->id], 'id' => 'payment_data_form', 'method' =>'POST', 'enctype' => 'multipart/form-data']) !!}
              <div class="form-group">
                {{Form::file('payment_invoice')}}                     
              </div> 
              <div class="col-md-12">
                {{Form::hidden('payment_hidden_id',  Auth::user()->id , ['id' => 'payment_hidden_id', 'class' => 'form-control'])}}
                {{Form::submit('Upload', ['id' => 'payment_action_button', 'class' => 'btn btn-success'])}}
              </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  @endif    

@endsection
