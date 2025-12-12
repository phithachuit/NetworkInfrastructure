@extends('template.index')

@section('title', 'Sửa người dùng')

@extends('template.panelLeft')
@extends('template.panelHead')

@section('content')

<!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="{{ route('user.index') }}">Người dùng</a>
          <span class="breadcrumb-item active">Sửa người dùng</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Sửa người dùng</h4>
        <!-- <p class="mg-b-0">Forms are used to collect user information with different element types of input, select, checkboxes, radios and more.</p> -->
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
            <form action="{{ route('user.update', $user['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-layout form-layout-1">
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="email" id="email" value="{{ $user['email'] ?? old('email') }}" placeholder="Email">
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Họ tên: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="name" value="{{ $user['name'] ?? old('name') }}" placeholder="Họ tên">
                            </div>
                        </div><!-- col-4 -->
                        
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Nhóm: <span class="tx-danger">*</span></label>
                            <select class="form-control select2" data-placeholder="Choose country" name="role">
                                @foreach($permissions as $permission)
                                <option value="{{ $permission['permission_id'] }}" {{ $permission['permission_id'] == $user['role'] ? 'selected' : '' }}>
                                    {{ $permission['permission_name'] }}
                                </option>
                                @endforeach
                            </select>
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Trạng thái: <span class="tx-danger">*</span></label>
                            <select class="form-control select2" data-placeholder="Choose country" name="user_active">
                                <option value="1" {{ $user['active'] == '1' ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{ $user['active'] == '0' ? 'selected' : '' }}>Vô hiệu hoá</option>
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
              <button class="btn btn-primary">Sửa</button>
              <a class="btn btn-success" href="{{ route('user.show', $user['id']) }}">Reset mật khẩu</a>
              <a class="btn btn-danger" href="{{ route('user.destroy', $user['id']) }}">Xoá</a>
            </div><!-- form-layout-footer -->
          </div><!-- form-layout -->
        </div>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

@endsection