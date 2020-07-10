<form data-href="{{route('admin.assign.rider')}}" id="assignRiderForm">
    @csrf

    <h5>{{$rider->firstname." ".$rider->lastname}}</h5><br>

    <div class="form-group">
        <label for="state">City</label>
        <select name="state" class="form-control" id="state">
            <option>{{$rider->state}}</option>
        </select>
    </div>

    <div class="form-group">
        <label for="lga">L.G.A</label>
        <select name="lga" class="form-control" id="lga">
            @if ($lgas->count() >= 1)
                @foreach ($lgas as $lga)
                    <option>{{$lga->name}}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="form-group">
        <label for="description">Location Description</label>
        <input name="description" class="form-control menu-input" id="description" type="text" placeholder="">
    </div>

    <input type="hidden" name="rider_id" value="{{$rider->id}}">

    <button type="submit" class="btn btn-md btn-primary " id="assignRiderFormBtn" style="float: right;">Submit</button>

</form>
