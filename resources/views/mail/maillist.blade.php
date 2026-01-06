@extends('template.index')
@section('title', "Dashboard")
@extends('template.panelLeft')
@extends('template.panelHead')


@section('content')

<!-- ########## START: MAIN PANEL ########## -->

    <div class="br-mailbox-list">
      <div class="br-mailbox-list-header">
        <a href="" id="showMailBoxLeft" class="show-mailbox-left hidden-sm-up">
          <i class="fa fa-arrow-right"></i>
        </a>
        <h6 class="tx-inverse mg-b-0 tx-13 tx-uppercase">Mail đã gửi <span class="tx-roboto"></span></h6>
      </div><!-- br-mailbox-list-header -->
      <div class="br-mailbox-list-body">
        @foreach($data as $item)
        <div class="br-mailbox-list-item {{ request()->route('id') == $item->id ? 'unread active' : '' }}">
          <a href="{{ route('mail.show', $item['id']) }}">
            <div class="d-flex justify-content-between mg-b-5">
              {{--<div>
                <i class="icon ion-ios-star tx-warning"></i>
                <i class="icon ion-android-attach"></i>
              </div>--}}
              <span class="tx-12">{{ $item['created_at']->format('d/m/Y H:m:s') }}</span>
            </div><!-- d-flex -->
            <h6 class="tx-14 mg-b-10 tx-gray-800">1</h6>
            <p class="tx-12 tx-gray-600 mg-b-5">{{ $item['content'] }}</p>
            </a>
          </div><!-- br-mailbox-list-item -->
        @endforeach
      </div><!-- br-mailbox-list-body -->
    </div><!-- br-mailbox-list -->

    @if(isset($showMail))
    <div class="br-mailbox-body">
      <div class="br-msg-header d-flex justify-content-between">
        <div class="media align-items-center">
          <div class="media-body">
            <p class="tx-inverse tx-medium mg-b-0">Louise Kate Lumaad</p>
            <p class="tx-12 mg-b-0">
              <span>{{ $showMail['created_at']->format('d/m/Y H:m:s') }}</span>
            </p>
          </div><!-- media-body -->
        </div><!-- media -->
      </div><!-- br-msg-header -->
      <div class="br-msg-body">
        {{ $showMail['content'] }}
      </div><!-- br-msg-body -->     
    </div><!-- br-mailbox-body -->
    @endif

    <!-- ########## END: MAIN PANEL ########## -->
@endcontent