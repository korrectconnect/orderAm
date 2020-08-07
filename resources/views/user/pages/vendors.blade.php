@extends('user.base')

@section('content')


<!-- start hero-header -->
<div class="breadcrumb-wrapper">

    <div class="container">

        <ol class="breadcrumb-list booking-step">
            <li><a href="{{route('user.home')}}">Home</a></li>
            <li><span>Vendors</span></li>
            <li> &nbsp; / &nbsp;<span>{{$type}}</span></li>
        </ol>

    </div>

</div>
<!-- end hero-header -->

<div class="section sm">

    <div class="container">

        <div class="sorting-wrappper alt">

            <div class="GridLex-grid-middle">

                <div class="GridLex-col-3_sm-12_xs-12">

                    <div class="sorting-header">
                        <h3 class="sorting-title">
                            @if ($vendors->count() >= 1)
                                {{$vendors->count()}} &nbsp;{{$type}}
                            @endif
                        </h3>
                    </div>

                </div>



                <div class="GridLex-col-4_sm-6_xs-6_xss-12">

                    <div class="alert alert-secondary">

                        <span style="font-size:14px; color:rgb(255, 136, 0);">
                            <i class="fa fa-location-arrow"></i> Delivering to
                        </span> &nbsp; &nbsp;
                        <span style="font-size:14px; font-weight:bold;">
                            {{$state." , ".$area}}
                        </span>

                        <a href="{{route('user.vendors.home')}}" style="float: right; color:rgb(255, 136, 0);"><i class="fa fa-pen"></i></a>

                    </div>

                </div>

            </div>

        </div>

        <div class="company-grid-wrapper top-company-2-wrapper">

            <div class="GridLex-gap-30">

                <div class="GridLex-grid-noGutter-equalHeight">

                    @if ($vendors->count() >= 1)

                        @foreach ($vendors as $vendor)

                        <div class="GridLex-col-3_sm-4_xs-6_xss-12">

                            <div class="top-company-2">
                                <a href="{{route('user.vendor', ['id' => $vendor->id, 'name' => $type])}}">

                                    <div class="image">
                                        <img src="{{$vendor->image}}" alt="image" />
                                    </div>

                                    <div class="content">
                                        <h5 class="heading text-primary font700">{{$vendor->name}}</h5>
                                        <p class="texting font600">{{$vendor->description}}</p>
                                        <p class="mata-p clearfix"><span class="text-primary font700">&#8358; {{$vendor->price}}</span> <span class="font13">min order</span> <span class="pull-right icon"><i class="fa fa-long-arrow-right"></i></span></p>

                                    </div>


                                </a>

                            </div>

                        </div>

                        @endforeach

                    @else

                        <h2>Opps No {{$type}} here !</h2><br><br>

                    @endif

                </div>

            </div>

        </div>

        {{-- <div class="pager-wrapper">

            <ul class="pager-list">
                <li class="paging-nav"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                <li class="paging-nav"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                <li class="number">
                    <span class="mr-5"><span class="font600">page</span></span>
                </li>
                <li class="form">
                    <form>
                        <input type="text" value="1" class="form-control">
                    </form>
                </li>
                <li class="number">
                    <span class="mr-5">/</span> <span class="font600">79</span>
                </li>
                <li class="paging-nav"><a href="#">go</a></li>
                <li class="paging-nav"><a href="#"><i class="fa fa-angle-right"></i></a></li>
                <li class="paging-nav"><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
            </ul>

        </div> --}}

    </div>

</div>

@endsection
