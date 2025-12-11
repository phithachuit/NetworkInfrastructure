
@extends('template.index')
@section('title', "Dashboard")
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
    <h4 class="tx-gray-800 mg-b-5">Danh sách tài khoản</h4>
    <!-- <p class="mg-b-0">A collection basic to advanced table design that you can use to your data.</p> -->
     
    </div>

    <div class="br-pagebody">
        <a href="{{ route('user.create') }}" class="btn btn-primary">Thêm tài khoản</a>

    <div class="br-section-wrapper">
        <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table mg-b-0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Quyền</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
            <tr>
                <th scope="row">{{ $user['id'] }}</th>
                <td>{{ $user['name'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>admin</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
@endsection