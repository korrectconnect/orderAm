
<form enctype="multipart/form-data" id="addMenuForm" data-href="{{route('vendor.menu.add')}}">
    @csrf

    <div class="row null">
        <div class="col-sm-6">
            <b><small>Add Menu cover</small></b>

            <div class="cover-container">
                <div class="cover-image"></div>
                <div class="cover-txt">Click here to add image from file </div>
            </div>
        </div>

        <div class="col-sm-6">
            <b><small>Enter Menu Info</small></b>

                  <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" class="form-control menu-input" id="name" type="text" placeholder="Enter menu name/title">
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <input name="description" class="form-control menu-input" id="description" type="text" placeholder="Eg With cheese / 1 portion / 3 Pieces">
                  </div>
                  <div class="form-group">
                      <label for="category">Category</label>
                      <select name="category" class="form-control">
                          @if ($menu_categories->count() >= 1)
                            @foreach ($menu_categories as $category)
                                <option value="{{$category->category}}">{{$category->category}}</option>
                            @endforeach
                          @endif
                      </select>
                    </div>
                  <div class="row null">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input name="price" class="form-control menu-input" id="price" type="text" placeholder="1900.99">
                    </div>
                    </div>

                   <div class="col-sm-6"><br>
                        <input type="file" name="cover" class="menu-input" style="display:none;" id="cover-file">
                        <button type="submit" class="btn btn-primary btn-sm" id="addMenuFormBtn" style="float:right;">Add Menu</button>
                    </div>
                  </div>

        </div>
    </div>
    </form>


