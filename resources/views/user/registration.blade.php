@extends('template.index')

@section('title', 'Tạo tài khoản')

@extends('template.panelLeft')
@extends('template.panelHead')

@section('content')

<!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.html">Danh sách tài khoản</a>
          <span class="breadcrumb-item active">Tạo tài khoản</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Tạo tài khoản</h4>
        <!-- <p class="mg-b-0">Forms are used to collect user information with different element types of input, select, checkboxes, radios and more.</p> -->
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="form-layout form-layout-1">
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Họ tên: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Họ tên">
                            </div>
                        </div><!-- col-4 -->
                        {{--<div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Lastname: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="lastname" placeholder="Enter lastname">
                            </div>
                        </div><!-- col-4 --> --}} 
                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" id="email" name="email" placeholder="Enter email address">
                            </div>
                        </div><!-- col-4 -->
                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Mật khẩu: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Mật khẩu">
                            </div>
                        </div><!-- col-4 -->
                        <div class="col-lg-8">
                            <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Địa chỉ: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="address" placeholder="Địa chỉ">
                            </div>
                        </div><!-- col-8 -->
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Quyền: <span class="tx-danger">*</span></label>
                            <select class="form-control select2" data-placeholder="Choose country" name="permission">
                                <option label="Choose country"></option>
                                <option value="USA">United States of America</option>
                                <option value="UK">United Kingdom</option>
                                <option value="China">China</option>
                                <option value="Japan">Japan</option>
                            </select>
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
              <button class="btn btn-info">Submit Form</button>
              <button class="btn btn-secondary">Cancel</button>
            </div><!-- form-layout-footer -->
          </div><!-- form-layout -->
        </div>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

@endsection