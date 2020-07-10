@extends('user.base')

@section('content')

<div class="breadcrumb-wrapper">

    <div class="container">

        <ol class="breadcrumb-list">
            <li><a href="index.html">Home</a></li>
            <li><span>Page not found</span></li>
        </ol>

    </div>

</div>

<div class="error-page-wrapper">

<div class="container">

    <div class="row">

        <div class="col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">

            <img src="{{asset('images/404.gif')}}" alt="" srcset="">

            <h3>Oops... Page Not Found!</h3>

            <a href="#" class="btn btn-primary mt-15">Back to home page</a>

        </div>

    </div>

</div>
</div>

@endsection
