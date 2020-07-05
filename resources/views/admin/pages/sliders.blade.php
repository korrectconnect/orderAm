@extends('admin.base')

@section('content')

<div class="container">
    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <strong>Upload Image</strong>
                </div>
                <div class="card-body">
                    <div class="cover-image"></div><br>

                    <form data-href="{{route('admin.slider.add')}}" method="POST" id="addSliderForm" enctype="multipart/form-data">
                        <input type="file" name="image" id="cover-file" style="display:none;">

                        <button type="submit" id="addSliderFormBtn" class="btn btn-md btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <strong>Slider preview</strong>
                </div>
                <div class="card-body">
                    @if ($sliders->count() >= 1)

                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                          @if ($sliders->count() >= 1)
                            <?php
                                $i = 0 ;
                                foreach ($sliders as $slider) {
                                    if($i == 0) {
                                        ?>
                                        <div class="carousel-item active">
                                            <div class="card shadow">
                                                <img class="d-block w-100 card-img-top" src="{{$slider->image}}">
                                            </div>
                                        </div>
                                        <?php
                                        $i++ ;
                                    }else {
                                        ?>
                                        <div class="carousel-item ">
                                            <div class="card shadow">
                                                <img class="d-block w-100 card-img-top" src="{{$slider->image}}">
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                          @endif
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>

                      <div class="row">

                        @foreach ($sliders as $slider)

                            <div class="col-md-3">
                                <div style="width: 100%; height:auto; margin-bottom: 20px;">
                                    <img src="{{$slider->image}}" style="width: 100%;"><br>
                                    <button data-href="{{route('admin.slider.delete', ['id' => $slider->id])}}" id="deleteSliderBtn" class="text-danger btn btn-link btn-md"><i class="fa fa-trash"></i> Delete</button>
                                </div>
                            </div>

                        @endforeach

                      </div>

                    @else
                        <div class="alert alert-secondary">
                            <i class="fa fa-exclamation-circle"></i> No Image has been added to home slider
                        </div>
                    @endif


                </div>
            </div>
        </div>

    </div>
</div>


@endsection
