
@extends('template.index')
@section('title', "Danh sách người dùng")
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
    <h4 class="tx-gray-800 mg-b-5">Danh sách người dùng</h4>
    <!-- <p class="mg-b-0">A collection basic to advanced table design that you can use to your data.</p> -->
     
    </div>

    <div class="br-pagebody">
        <a href="{{ route('user.create') }}" class="btn btn-primary">Thêm người dùng</a>

    <div class="br-section-wrapper">
        <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table mg-b-0">
            <thead>
            <tr>
                <th>Mã số</th>
                <th>Email</th>
                <th>Tên</th>
                <th>Nhóm</th>
                <th>Trạng thái</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
            <tr>
                <th scope="row"><a href="{{ route('user.edit', $user['id']) }}">{{ $user['id'] }}</a></th>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['name'] }}</td>
                <td>{{ $user['permission_name'] }}</td>
                <td>{{ $user['active'] ? 'Kích hoạt' : 'Vô hiệu hoá' }}</td>
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