function appendMenuCategory(category) {
    $(document).ready(function() {
        $("#menu-category").append("<option>" + category + "</option>");
    });
}
