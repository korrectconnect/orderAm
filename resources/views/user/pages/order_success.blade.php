@extends('user.base')

@section('content')

<!-- start hero-header -->
<div class="breadcrumb-wrapper">

    <div class="container">

        <ol class="breadcrumb-list booking-step">
            <li><a href="{{route('user.home')}}">Home</a></li>
            <li><span>Order Success</span></li>
        </ol>

    </div>

</div>
<!-- end hero-header -->

<div class="section sm">

    <div class="cfo-area">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="contact-details thankyou text-center clearfix">
                        <div style="padding: 20px 25px; border-radius:100px; background-color: rgb(255, 102, 0); color:#fff; text-align:center; display:inline-block;" ><i class="fa fa-check" aria-hidden="true"></i></div>
                        <h2>Thank you for your order</h2>
                        <b>Order No. : <span class="siteColor">{{$order}}</span></b>
                        <br><br>
                        <p>
                            Your order has been sent to <b>{{$vendor->name}} ({{$vendor->lga}})</b>. You will be notified by your selected vendor once your order has been confirmed. You can check the status of your order <a href="{{route('user.orders')}}">here.</a> Your order number can be found at the top of this message. A copy of this message has been sent to your email.
                        </p><br>

                        <center><img src="{{asset('images/orderam logo.png')}}" alt="Logo" width="150" /></center>

                        <div class="clearfix"></div><br><br>
                    </div>
                    <div class="clearfix"></div>
                    <!-- END OF CONTACT DETAILS SECTION -->

                </div>
                <!-- End of CFO order list -->


            </div>
        </div>
    </div>

</div>

@endsection
