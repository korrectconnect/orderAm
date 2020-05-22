


$('#addVendor').submit(function(e) {
    e.preventDefault();
    $(".uploadVendorBtn").prop("disabled", true);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:"add",
        type: "POST",
        data: new FormData(this),
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 5000});
                }
                $(".uploadVendorBtn").prop("disabled", false);

            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                $(".uploadVendorBtn").prop("disabled", false);
            }
        }
    });
});


$("#addMenu").submit(function(e) {

        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //alert("hello");
        $(".uploadMenuBtn").prop("disabled", true);
        var link = $("#add_menu_link").data("link");
        var menu_id = $("#menu_refresh_id").data("id");

        $.ajax({
            url:link,
            type: "POST",
            data: new FormData(this),
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            success: function(e) {
                if(e.errors != null) {
                    for(i in e.errors) {
                        toastr.error(e.errors[i], "Error", {timeOut: 5000});
                    }
                    $(".uploadMenuBtn").prop("disabled", false);

                }else {
                    if(menu_id == 0) {
                        refreshMenus();
                    }else{
                        $("#refreshMenuBtn").click();
                        //refreshMenu(menu_id);
                    }
                    $('.cover-image').css("background-image","url('')");
                    $("#addMenu .menu-input").val("");
                    toastr.success(e.message, "Success", {timeOut: 5000});
                    $(".uploadMenuBtn").prop("disabled", false);
                }
            }
        });
    });



$(document).on('click', '#deleteVendorCategoryBtn', function() {
    if (confirm('Are you sure you want to delete category')) {
        var id = $(this).data('id');

        $(".refreshVendorCategoryDiv").html("<center><i class='fa fa-spin fa-spinner fa-2x'></i></center>");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "../ajax/deleteVendorCategory/" + id,
            type: "get",
            success: function(e) {
                if(e.errors != null) {
                    for(i in e.errors) {
                        toastr.error(e.errors[i], "Error", {timeOut: 5000});
                    }
                }else {
                    toastr.success(e.message, "Success", {timeOut: 5000});
                    refreshVendorCategory();
                }
            }
        });
    }
});

$(document).on('click', '#deleteVendorLocationBtn', function() {
    if (confirm('Are you sure you want to delete Location')) {
        var id = $(this).data('id');

        $(".refreshVendorLocationDiv").html("<center><i class='fa fa-spin fa-spinner fa-2x'></i></center>");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "../ajax/deleteVendorLocation/" + id,
            type: "get",
            success: function(e) {
                if(e.errors != null) {
                    for(i in e.errors) {
                        toastr.error(e.errors[i], "Error", {timeOut: 5000});
                    }
                }else {
                    toastr.success(e.message, "Success", {timeOut: 5000});
                    refreshVendorLocation();
                }
            }
        });
    }
});

$('#addLocationForm').submit(function(e) {
    e.preventDefault();
    $(".addLocationBtn").prop("disabled", true);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:"location",
        type: "POST",
        data: new FormData(this),
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 5000});
                }
                $(".addLocationBtn").prop("disabled", false);

            }else {
                refreshVendorLocation();
                toastr.success(e.message, "Success", {timeOut: 5000});
                $(".addLocationBtn").prop("disabled", false);
            }
        }
    });
});

$('#vendorCategoryForm').submit(function(e) {
    e.preventDefault();
    $(".vendorCategoryBtn").prop("disabled", true);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:"category",
        type: "POST",
        data: new FormData(this),
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 5000});
                }
                $(".vendorCategoryBtn").prop("disabled", false);

            }else {
                refreshVendorCategory();
                toastr.success(e.message, "Success", {timeOut: 5000});
                $(".vendorCategoryBtn").prop("disabled", false);
            }
        }
    });
});

$(".vendor-category-upload-image").click(function() {
    $("#vendor-category-file").click();
    $('.vendor-category-upload-image').css("background-image","url('')");

});

$("#vendor-category-file").change(function() {
    var reader = new FileReader();
    var file = this.files[0];
     var imagefile = file.type;
     var match= ["image/jpeg","image/png","image/jpg"];
     if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
     {
        toastr.error("Invalid image file (upload jpg, jpeg, png file)", "Error", {timeOut: 5000});
     }else {

          reader.onload = function() {
          $('.vendor-category-upload-image').css("background-image","url(" + reader.result + ")");
           };
          reader.readAsDataURL(event.target.files[0]);
    };
});

$(".vendor-image").click(function() {
    $("#vendor-image-file").click();
    $('.vendor-image').css("background-image","url('')");

});

$(".vendor-image-txt").click(function() {
    $("#vendor-image-file").click();
    $('.vendor-image').css("background-image","url('')");

});

$("#vendor-image-file").change(function() {
    $(".uploadVendorBtn").prop("disabled", true);
    var reader = new FileReader();
    var file = this.files[0];
     var imagefile = file.type;
     var match= ["image/jpeg","image/png","image/jpg"];
     if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
     {
        toastr.error("Invalid image file (upload jpg, jpeg, png file)", "Error", {timeOut: 5000});
        $(".uploadVendorBtn").prop("disabled", false);
     }else {

          reader.onload = function() {
          $('.vendor-image').css("background-image","url(" + reader.result + ")");
           };
          reader.readAsDataURL(event.target.files[0]);
          $(".uploadVendorBtn").prop("disabled", false);
    };
  });

  $(".cover-image").click(function() {
    $("#cover-file").click();
    $('.cover-image').css("background-image","url('')");

});

$(".cover-txt").click(function() {
    $("#cover-file").click();
    $('.cover-image').css("background-image","url('')");

});

$("#cover-file").change(function() {
    $(".uploadVendorBtn").prop("disabled", true);
    $(".uploadMenuBtn").prop("disabled", true);
    $(".uploadMenuBtn").html("<i class='fa fa-spinner fa-2x fa-spin'></i>");
    var reader = new FileReader();
    var file = this.files[0];
     var imagefile = file.type;
     var match= ["image/jpeg","image/png","image/jpg"];
     if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
     {
        toastr.error("Invalid image file (upload jpg, jpeg, png file)", "Error", {timeOut: 5000});
        $(".uploadVendorBtn").prop("disabled", false);
        $(".uploadMenuBtn").prop("disabled", true);
        $(".uploadMenuBtn").html("Add Menu");
     }else {

          reader.onload = function() {
          $('.cover-image').css("background-image","url(" + reader.result + ")");
           };
          reader.readAsDataURL(event.target.files[0]);
          $(".uploadVendorBtn").prop("disabled", false);
          $(".uploadMenuBtn").prop("disabled", false);
          $(".uploadMenuBtn").html("Add Menu");
    };
  });

$(document).ready(function() {
    $(".vendor_modal_btn").click(function() {
        window.location = "vendor/" + $("#moreVendorID").val() ;
    });
});

function refreshVendorCategory() {
    $(".refreshVendorCategoryDiv").html("<center><i class='fa fa-spin fa-spinner fa-2x'></i></center>");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "../ajax/refreshVendorCategory",
        type: "get",
        success: function(e) {
            $(".refreshVendorCategoryDiv").html(e);
        }
    });
}

function refreshVendorLocation() {
    $(".refreshVendorLocationDiv").html("<center><i class='fa fa-spin fa-spinner fa-2x'></i></center>");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "../ajax/refreshVendorLocation",
        type: "get",
        success: function(e) {
            $(".refreshVendorLocationDiv").html(e);
        }
    });
}

function refreshVendorLocation() {
    $(".refreshVendorLocationDiv").html("<center><i class='fa fa-spin fa-spinner fa-2x'></i></center>");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "../ajax/refreshVendorLocation",
        type: "get",
        success: function(e) {
            $(".refreshVendorLocationDiv").html(e);
        }
    });
}

function refreshMenus() {

    $(".refreshMenuDiv").html("<i class='fa fa-spin fa-spinner'></i> Please Wait");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "ajax/refreshMenu",
        type: "get",
        success: function(e) {
            $(".refreshMenuDiv").html(e);
        }
    });
}

function refreshMenu(id, path = '../../') {

    $(".refreshMenuDiv").html("<i class='fa fa-spin fa-spinner'></i> Please Wait");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: path + "ajax/refreshMenu/" + id,
        type: "get",
        success: function(e) {
            $(".refreshMenuDiv").html(e);
        }
    });
}

$("#addcategoryForm").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:"../../menuCategory/add",
        type: "POST",
        data: new FormData(this),
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,
        success: function(e) {
            //alert(e);
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 5000});
                }
                $(".addMenuCategoryBtn").prop("disabled", false);

            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                $(".addMenuCategoryBtn").prop("disabled", false);
                window.location.reload();
            }
        }
    });
});

$(".addCategoryLink").click(function() {
    $(".vendor_id").val($(this).data('id'));
});

$(".deleteMenuCategory").click(function() {
    $(".category_id").val($(this).data("id"));
    $(".deleteMenuCategoryForm").submit();
});

$(".deleteMenuCategoryForm").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:"../../menuCategory/delete",
        type: "POST",
        data: new FormData(this),
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,
        success: function(e) {
            //alert(e);
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 5000});
                }
            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                window.location.reload();
            }
        }
    });
});

function deleteMenu(link) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:link,
        type: "GET",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 5000});
                }
            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                $("#refreshMenuBtn").click();
            }
        }
    });
}

$("#deleteVendorBtn").click(function() {
    var link = $("#delete_vendor_link").val();
    var id = $("#delete_vendor_id").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:link,
        type: "GET",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 5000});
                }
            }else {
                $("#close_modal").click();
                toastr.success(e.message, "Success", {timeOut: 5000});
                $("#vendor_" + id).fadeOut(500);
            }
        }
    });
});

function searchVendor(e) {
    var key = $(e).val();
    if(key != "") {
        $(".menuSearchDiv").html("<i class='fa fa-spin fa-spinner'></i> Please Wait");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "ajax/searchVendor/" + key,
            type: "GET",
            success: function(e) {
                $(".menuSearchDiv").html(e);
            }
        });
    }
}
