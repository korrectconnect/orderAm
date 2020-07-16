


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
    var href = $(this).data('href');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
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

    setTimeout(function() {
        $(".orderMenuBtn:first").click();
        $(".menuCategoryBtn:first").click();
    },100);
});

$(document).on('click', '.orderMenuBtn', function() {
    $('.orderMenuBtn').removeClass('orderMenuActive');
    $(this).addClass('orderMenuActive');
    var href = $(this).data("href");

    $(".orderListDiv").html("<center><i class='fa fa-spin fa-circle-notch fa-2x'></i></center>");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "get",
        success: function(e) {
            $(".orderListDiv").html(e);
        }
    });
});

$(document).on('submit', '#filterTransactionForm', function(e) {
    e.preventDefault();
    $("#filterTransactionFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");
    var href = $(this).data("href");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
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
                $("#filterTransactionFormBtn").prop('disabled', false).html("Filter");
            }else {
                $(".orderListDiv").html(e);
            }
        }
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

function refreshMenu(path) {

    $(".refreshMenuDiv").html("<i class='fa fa-spin fa-spinner'></i> Please Wait");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: path,
        type: "get",
        success: function(e) {
            $(".refreshMenuDiv").html(e);
        }
    });
}

$("#addcategoryForm").submit(function(e) {
    e.preventDefault();
    var href = $(this).data('href');

    $(".addMenuCategoryBtn").prop("disabled", true).html(" <i class='fa fa-circle-notch fa-spin'><i> ");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
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
                $(".addMenuCategoryBtn").prop("disabled", false).html('Add Category');

            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                $(".addMenuCategoryBtn").prop("disabled", false).html('Add Category');
                window.location.reload();
            }
        }
    });
});

$(".addCategoryLink").click(function() {
    $(".vendor_id").val($(this).data('id'));
});

$(document).on('click', '#authVendorBtn', function() {
    $("#authVendorForm").submit();
});

$(document).on('click', '#authVendorResetBtn', function() {
    if (confirm('Are you sure you want to reset vendors authentication credentials')) {
        $("#authVendorForm").submit();
    }
});

$(".deleteMenuCategory").click(function() {

    if (confirm('Are you sure')) {
        var btn = $(this) ;
        var link = btn.data("href");

        btn.prop('disabled', true).html("<i class='fa fa-spin fa-circle-notch'></i>");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: link,
            type: "GET",
            success: function(e) {
                if(e.errors != null) {
                    for(i in e.errors) {
                        toastr.error(e.errors[i], "Error", {timeOut: 5000});
                    }
                    btn.prop('disabled', true).html("<i class='fa fa-times-circle'></i>");
                }else {
                    toastr.success(e.message, "Success", {timeOut: 5000});
                    window.location.reload();
                }
            }
        });
    }
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

$(document).on('click', '#cancelOrder', function() {
    var href = $(this).data("href");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "GET",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 5000});
                }
            }else {
                window.location.reload();
            }
        }
    });

});

$(document).on('submit', '#riderCategoryForm', function(e) {
    e.preventDefault();

    var href = $(this).data("href");
    $("#riderCategoryFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-spinner'></i> &nbsp; ");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
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
                $("#riderCategoryFormBtn").prop('disabled', false).html(" <i class='fa fa-plus-circle'></i> Add ");

            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                $("#riderCategoryFormBtn").prop('disabled', false).html(" <i class='fa fa-plus-circle'></i> Add ");
                window.location.reload();
            }
        }
    });
});

$(document).on('click', '#deleteRiderCategoryBtn', function() {
    var btn = $(this);
    var href = btn.data("href");
    btn.prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-spinner'></i> &nbsp; ");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "GET",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 5000});
                }
                btn.prop('disabled', false).html("<i class='fa fa-trash'></i> Delete");
            }else {
                window.location.reload();
            }
        }
    });

});

$(document).on('submit', '#addRiderForm', function(e) {
    e.preventDefault();

    var href = $(this).data("href");
    $("#addRiderFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-spinner'></i> &nbsp; ");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
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
                $("#addRiderFormBtn").prop('disabled', false).html("Save & Upload");

            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                window.location.reload();
            }
        }
    });
});

$(document).on('submit', '#editRiderForm', function(e) {
    e.preventDefault();

    var href = $(this).data("href");
    $("#editRiderFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-spinner'></i> &nbsp; ");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
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
                $("#editRiderFormBtn").prop('disabled', false).html("Save edit & Upload");

            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                window.location.reload();
            }
        }
    });
});

$(document).on('submit', '#editVendorForm', function(e) {
    e.preventDefault();

    var href = $(this).data("href");
    $("#editVendorFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-spinner'></i> &nbsp; ");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
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
                $("#editVendorFormBtn").prop('disabled', false).html("Save edit & Upload");

            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                window.location.reload();
            }
        }
    });
});

$(document).on('click', '#confirmOrderBtn', function() {
    $("#adminModalBody").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
    $("#adminModalTitle").html("Assign rider to order no. " + $(this).data('order'));
    $('#adminModal').modal('show');
    var href = $(this).data("href");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "get",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 3000});
                    $('#adminModal').modal('hide');
                }
            }else {
                $("#adminModalBody").html(e);
            }
        }
    });
});

$(document).on('click', '#confirmAssignOrderBtn', function() {
    var btn = $(this);
    var href = btn.data("href");

    btn.prop('disabled', true).html("<i class='fa fa-spin fa-spinner'></i>");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "get",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 3000});
                    btn.prop('disabled', false).html("Confirm");
                }
            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                window.location.reload() ;
            }
        }
    });
});

$(document).on('click', '#deleteSliderBtn', function() {
    var btn = $(this);
    var href = btn.data("href");

    btn.prop('disabled', true).html("<i class='fa fa-spin fa-spinner'></i>");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "get",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 3000});
                    btn.prop('disabled', false).html("<i class='fa fa-trash'> Delete</i>");
                }
            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                window.location.reload() ;
            }
        }
    });
});

$(document).on('click', '#viewRiderOrdersBtn', function() {
    $("#adminModalBody").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
    $("#adminModalTitle").html("Pending Delivery");
    $('#adminModal').modal('show');
    var href = $(this).data("href");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "get",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 3000});
                    $('#adminModal').modal('hide');
                }
            }else {
                $("#adminModalBody").html(e);
            }
        }
    });
});

$(document).on('click', '#viewOrderBtn', function() {
    $("#adminModalBody").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
    $("#adminModalTitle").html("Pending Delivery");
    $('#adminModal').modal('show');
    var href = $(this).data("href");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "get",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 3000});
                    $('#adminModal').modal('hide');
                }
            }else {
                $("#adminModalBody").html(e);
            }
        }
    });
});

$(document).on('click', '#viewPendingDeliveryBtn', function() {
    $("#adminModalBody").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
    $("#adminModalTitle").html("Pending Delivery");
    $('#adminModal').modal('show');
    var href = $(this).data("href");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "get",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 3000});
                    $('#adminModal').modal('hide');
                }
            }else {
                $("#adminModalBody").html(e);
            }
        }
    });
});

$(document).on('click', '#assignRiderBtn', function() {
    $("#adminModalBody").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
    $("#adminModalTitle").html("Assign rider to location");
    $('#adminModal').modal('show');
    var href = $(this).data("href");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "get",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 3000});
                    $('#adminModal').modal('hide');
                }
            }else {
                $("#adminModalBody").html(e);
            }
        }
    });
});

$(document).on('submit', '#assignRiderForm', function(e) {
    e.preventDefault();

    var href = $(this).data("href");
    $("#assignRiderFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-spinner'></i> &nbsp; ");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
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
                $("#assignRiderFormBtn").prop('disabled', false).html("Submit");

            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                window.location.reload();
            }
        }
    });
});

$(document).on('submit', '#assignRiderForm', function(e) {
    e.preventDefault();

    var href = $(this).data("href");
    $("#assignRiderFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-spinner'></i> &nbsp; ");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
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
                $("#assignRiderFormBtn").prop('disabled', false).html("Submit");

            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                window.location.reload();
            }
        }
    });
});

$(document).on('submit', '#addSliderForm', function(e) {
    e.preventDefault();

    var href = $(this).data("href");
    $("#addSliderFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-spinner'></i> &nbsp; ");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
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
                $("#addSliderFormBtn").prop('disabled', false).html("Add");

            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                window.location.reload();
            }
        }
    });
});

$(document).on('click', '#viewRiderAssignBtn', function() {
    $("#viewRiderAssignDiv").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
    var href = $(this).data("href");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "get",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 3000});
                    $('#viewRiderAssignDiv').html('<i>Click on <b>view</b> to see list of riders assigned to a location here</i>');
                }
            }else {
                $("#viewRiderAssignDiv").html(e);
            }
        }
    });
});

$(document).on('click', '#unassignRiderBtn', function() {
    $("#adminModalBody").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
    $("#adminModalTitle").html("");
    $('#adminModal').modal('show');
    var href = $(this).data("href");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: href,
        type: "get",
        success: function(e) {
            if(e.errors != null) {
                for(i in e.errors) {
                    toastr.error(e.errors[i], "Error", {timeOut: 3000});
                    $('#adminModal').modal('hide');
                }
            }else {
                toastr.success(e.message, "Success", {timeOut: 5000});
                window.location.reload();
            }
        }
    });
});
