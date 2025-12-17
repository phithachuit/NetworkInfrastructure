@extends('template.index')

@section('title', 'Cấu hình mail')

@extends('template.panelLeft')
@extends('template.panelHead')

@section('content')

<!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="">Mail</a>
          <span class="breadcrumb-item active">Cấu hình mail</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Cấu hình mail</h4>
        <!-- <p class="mg-b-0">Forms are used to collect user information with different element types of input, select, checkboxes, radios and more.</p> -->
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
            <form action="{{ route('mail.store') }}" method="POST">
                @csrf
                <div class="form-layout form-layout-1">
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">SMTP host: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="smtphost" id="smtphost" placeholder="SMTP host">
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">SMTP port: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="number" name="smtpport" id="smtpport" placeholder="SMTP port">
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Tài khoản: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="username" id="username" placeholder="Tài khoản">
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Mật khẩu: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="Mật khẩu">
                            </div>
                        </div><!-- col-4 -->
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Gửi tới: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="email" name="mailto" id="mailto" placeholder="Gửi tới">
                            </div>
                        </div><!-- col-4 -->

                        @if ($errors->any())
                            <div class="col-lg-12 alert alert-danger">
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
              <!-- <a class="btn btn-success" href="">Reset mật khẩu</a> -->
              <!-- <a class="btn btn-danger" href="">Xoá</a> -->
            </div><!-- form-layout-footer -->
          </div><!-- form-layout -->
        </div>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

@endsection