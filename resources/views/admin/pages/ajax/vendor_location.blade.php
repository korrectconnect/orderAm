@if ($locations->count() >= 1)
                            @foreach ($locations as $location)
                                <div class="alert alert-secondary">
                                    <i class="fa fa-location-arrow fa-2x"></i> &nbsp; {{$location->type." : ".$location->name}}
                                    <button class="btn btn-sm btn-link" id="deleteVendorLocationBtn" data-id="{{$location->id}}" style="margin-top:0px; float:right;"><i class="fa fa-trash fa-1x text-danger"></i></button>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                <small>You have not added any location for vendors <i class="fa fa-exclamation"></i></small>
                            </div>
                        @endif
