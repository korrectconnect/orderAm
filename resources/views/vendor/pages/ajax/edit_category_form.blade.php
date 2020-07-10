<form id="editMenuCategoryForm" data-href="{{route('vendor.menu_category.edit')}}">
    @csrf

    <div class="form-group">
        <label for="category">Category</label>
        <input value="{{$category->category}}" name="category" class="form-control menu-input" id="category" type="text" placeholder="Eg Drinks">
      </div>

      <input type="hidden" value="{{$category->id}}" name="id">

      <button type="submit" class="btn btn-sm btn-primary" id="editMenuCategoryFormBtn">Edit Category</button>

</form>
