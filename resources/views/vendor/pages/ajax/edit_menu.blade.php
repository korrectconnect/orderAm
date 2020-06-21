
<form enctype="multipart/form-data" id="editMenuForm" data-href="{{route('vendor.menu.edit')}}">
    @csrf

    <div class="row null">
        <div class="col-sm-6">
            <b><small>Add Menu cover</small></b>

            <div class="cover-container">
                <div class="cover-image" style="background-image:url('{{$menu->image}}')"></div>
                <div class="cover-txt">Click here to add image from file </div>
            </div>
        </div>

        <div class="col-sm-6">
            <b><small>Enter Menu Info</small></b>

                  <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" class="form-control menu-input" id="name" type="text" value="{{$menu->menu}}" placeholder="Enter menu name/title">
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <input name="description" class="form-control menu-input" id="description" value="{{$menu->description}}" type="text" placeholder="Eg With cheese / 1 portion / 3 Pieces">
                  </div>
                  <div class="form-group">
                      <label for="category">Category</label>
                      <select name="category" class="form-control">
                          @if ($menu_categories->count() >= 1)
                            <option value="{{$menu->category}}" selected>{{$menu->category}}</option>
                            @foreach ($menu_categories as $category)
                                @if ($menu->category != $category->category)
                                    <option value="{{$category->category}}">{{$category->category}}</option>
                                @endif
                            @endforeach
                          @endif
                      </select>
                    </div>
                  <div class="row null">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input name="price" class="form-control menu-input" value="{{$menu->price}}" id="price" type="text" placeholder="1900.99">
                    </div>
                    </div>

                   <div class="col-sm-6"><br>
                        <input type="file" name="cover" class="menu-input" style="display:none;" id="cover-file">
                        <input type="hidden" name="id" value="{{$menu->id}}">
                        <button type="submit" class="btn btn-primary btn-sm" id="editMenuFormBtn" style="float:right;">Edit Menu</button>
                    </div>
                  </div>

        </div>
    </div>
    </form>


