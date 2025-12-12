@extends('template.index')
@section('title', "Đăng nhập")

@section('content')
<div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">
    <form action="{{ route('login.post') }}" method="POST">
        @csrf
      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
        <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-strong">ĐĂNG NHẬP</span></div>
        <div class="tx-center mg-b-30">Vui lòng đăng nhập để tiếp tục</div>
        
        @if (session('success'))
            <div class="alert alert-success">
                <p class="mb-0 text-center">{{ session('success') }}</p>
            </div>
        @endif

        <div class="form-group">
          <input type="text" id="email_address" class="form-control{{ $errors->has('email') ? ' border-danger' : '' }}" name="email" placeholder="Email" autofocus>
          @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
        @endif
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' border-danger' : '' }}" name="password" placeholder="Mật khẩu">
          <!-- <a href="" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a> -->
          @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
        </div><!-- form-group -->
        <button type="submit" class="btn btn-info btn-block">Đăng nhập</button>

        <!-- <div class="mg-t-60 tx-center">Not yet a member? <a href="" class="tx-info">Sign Up</a></div> -->
      </div><!-- login-wrapper -->
      </form>
    </div><!-- d-flex -->
@endsection