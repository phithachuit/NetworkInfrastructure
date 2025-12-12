@extends('template.index')

@section('title', 'Thêm mới nhóm')

@extends('template.panelLeft')
@extends('template.panelHead')

@section('content')

<!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="{{ route('permission.index') }}">Nhóm</a>
          <span class="breadcrumb-item active">Thêm mới nhóm</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Thêm mới nhóm</h4>
        <!-- <p class="mg-b-0">Forms are used to collect user information with different element types of input, select, checkboxes, radios and more.</p> -->
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
            <form action="{{ route('permission.store') }}" method="POST">
                @csrf
                <div class="form-layout form-layout-1">
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Mã nhóm: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="permission_id" id="permission_id" value="{{ old('permission_id') }}" placeholder="Mã nhóm">
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group">
                            <label class="form-control-label">Tên nhóm: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="permission_name" value="{{ old('permission_name') }}" placeholder="Tên nhóm">
                            </div>
                        </div><!-- col-4 -->
                        
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Trạng thái: <span class="tx-danger">*</span></label>
                            <select class="form-control select2" data-placeholder="Choose country" name="permission_active">
                                <option label="--Chọn trạng thái--"></option>
                                <option value="1" {{ old('permission_active') == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{ old('permission_active') == 0 ? 'selected' : '' }}>Không kích hoạt</option>
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
              <button class="btn btn-primary">OK</button>
              <button class="btn btn-secondary">Reset</button>
            </div><!-- form-layout-footer -->
          </div><!-- form-layout -->
        </div>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

@endsection