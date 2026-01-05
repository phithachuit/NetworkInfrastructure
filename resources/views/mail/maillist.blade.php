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
        <h6 class="tx-inverse mg-b-0 tx-13 tx-uppercase">Mail đã gửi <span class="tx-roboto">(2)</span></h6>
      </div><!-- br-mailbox-list-header -->
      <div class="br-mailbox-list-body">
        <div class="br-mailbox-list-item">
          <div class="d-flex justify-content-between mg-b-5">
            {{--<div>
              <i class="icon ion-ios-star tx-warning"></i>
              <i class="icon ion-android-attach"></i>
            </div>--}}
            <span class="tx-12">10 hours ago</span>
          </div><!-- d-flex -->
          <h6 class="tx-14 mg-b-10 tx-gray-800">Socrates Itumay, me (4)</h6>
          <p class="tx-12 tx-gray-600 mg-b-5">I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never...</p>
        </div><!-- br-mailbox-list-item -->
      </div><!-- br-mailbox-list-body -->
    </div><!-- br-mailbox-list -->

    <div class="br-mailbox-body">
      <div class="br-msg-header d-flex justify-content-between">
        <div class="media align-items-center">
          <div class="media-body">
            <p class="tx-inverse tx-medium mg-b-0">Louise Kate Lumaad</p>
            <p class="tx-12 mg-b-0">
              <span>Sep 20, 2017 8:45am</span>
            </p>
          </div><!-- media-body -->
        </div><!-- media -->
      </div><!-- br-msg-header -->
      <div class="br-msg-body">
        <h6 class="tx-inverse mg-b-25 lh-4">Message sent via your Envato Market profile from themepixels</h6>

        <p>Hi Isidore,</p>

        <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>

        <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents.</p>

        <p>I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>

        <p>Regards,<br>ThemePixels</p>
      </div><!-- br-msg-body -->

      
    </div><!-- br-mailbox-body -->

    <!-- ########## END: MAIN PANEL ########## -->
@endcontent