<form data-href="{{route('admin.menu_category.add')}}" id="addcategoryForm">
    @csrf

    <div class="form-group">
        <label for="category">Category</label>
        <input name="category" class="form-control menu-input" id="category" type="text" placeholder="Eg Drinks">
      </div>

      <input type="hidden" name="vendor_id" class="vendor_id">

      <button type="submit" class="btn btn-sm btn-primary addMenuCategoryBtn">Add Category</button>

</form>
