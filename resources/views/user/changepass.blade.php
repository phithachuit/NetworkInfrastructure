@extends('template.index')

@section('title', 'Đổi mật khẩu người dùng')

@extends('template.panelLeft')
@extends('template.panelHead')

@section('content')

<!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="{{ route('user.index') }}">Người dùng</a>
          <span class="breadcrumb-item active">Đổi mật khẩu người dùng</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Đổi mật khẩu người dùng</h4>
        <!-- <p class="mg-b-0">Forms are used to collect user information with different element types of input, select, checkboxes, radios and more.</p> -->
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
            <form action="{{ route('user.changePass', $user['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-layout form-layout-1">
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="email" id="email" value="{{ $user['email'] ?? old('email') }}" placeholder="Email" readonly>
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Họ tên: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="name" value="{{ $user['name'] ?? old('name') }}" placeholder="Họ tên" readonly>
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Mật khẩu: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="password" name="password" value="{{ $user['password'] ?? old('password') }}" placeholder="Mật khẩu">
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Nhập lại mật khẩu: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="password" name="password_confirmation" value="{{ $user['password'] ?? old('password') }}" placeholder="Nhập lại mật khẩu">
                            </div>
                        </div><!-- col-4 -->

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div><!-- row -->
                </form>

            <div class="form-layout-footer">
              <button class="btn btn-primary">Sửa</button>
            </div><!-- form-layout-footer -->
          </div><!-- form-layout -->
        </div>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

@endsection