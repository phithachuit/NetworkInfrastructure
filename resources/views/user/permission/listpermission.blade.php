
@extends('template.index')
@section('title', "Danh sách nhóm")
@extends('template.panelLeft')
@extends('template.panelHead')

@section('content')

<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel">
    {{--<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="index.html">Bracket</a>
        <a class="breadcrumb-item" href="#">Tables</a>
        <span class="breadcrumb-item active">Basic Table</span>
    </nav>
    </div><!-- br-pageheader --> --}}
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Danh sách nhóm</h4>
    <!-- <p class="mg-b-0">A collection basic to advanced table design that you can use to your data.</p> -->
     
    </div>

    <div class="br-pagebody">
        <a href="{{ route('permission.create') }}" class="btn btn-primary">Thêm nhóm</a>

    <div class="br-section-wrapper">
        <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table mg-b-0">
            <thead>
            <tr>
                <th class="text-center">Mã nhóm</th>
                <th class="text-center">Tên</th>
                <th class="text-center">Số lượng tài khoản</th>
                <th class="text-center">Trạng thái</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($permissions as $permission)
            <tr>
                <th scope="row" class="text-center"><a href="{{ route('permission.edit', $permission['permission_id']) }}">{{ $permission['permission_id'] }}</a></th>
                <td class="text-center">{{ $permission['permission_name'] }}</td>
                <td class="text-center">{{ $permission['users_count'] }}</td>
                <td class="text-center">{{ $permission['permission_active'] ? 'Kích hoạt' : 'Không kích hoạt' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif
</div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
@endsection