
<form action="{{route('admin.menu.add')}}" method="POST" enctype="multipart/form-data" id="addMenu">
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
                <input name="name" class="form-control menu-input" id="name" type="text" placeholder="Enter your company name">
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <input name="description" class="form-control menu-input" id="description" type="text" placeholder="Eg With cheese / 1 portion / 3 Pieces">
              </div>
              <div class="form-group">
                  <label for="category">Category</label><div id="menu_category_loader" style="display:inline-block; float:right; font-size:12px;"><i class='fa fa-check text-success' ></i></div>
                  <select name="category" class="form-control" id="menu-category"></select>
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
                    <input type="hidden" name="vendor_id" id="vendor_id" value="">
                    <input type="hidden" name="add_menu_link" id="add_menu_link" data-link="{{route('admin.menu.add')}}">
                    <input type="hidden" name="menu_bool" id="menu_refresh_id" data-id="0">
                    <button type="submit" class="btn btn-primary btn-sm uploadMenuBtn" style="float:right;">Add Menu</button>
                </div>
              </div>

    </div>
</div>
</form>


