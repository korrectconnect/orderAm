<form id="addMenuCategoryForm" data-href="{{route('vendor.menu_category.add')}}">
    @csrf

    <div class="form-group">
        <label for="category">Category</label>
        <input name="category" class="form-control menu-input" id="category" type="text" placeholder="Eg Drinks">
      </div>

      <input type="hidden" name="vendor_id" class="vendor_id">

      <button type="submit" class="btn btn-sm btn-primary" id="addMenuCategoryFormBtn">Add Category</button>

</form>
