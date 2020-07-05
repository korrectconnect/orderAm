function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$(document).ready(function() {

    setTimeout(function() {
        $(".orderMenuBtn:first").click();
        $(".menuCategoryBtn:first").click();
    },100);

    $(document).on('click', '.menuCategoryBtn', function() {
        $('.menuCategoryBtn').removeClass('menuCategoryActive');
        $(this).addClass('menuCategoryActive');
        var href = $(this).data("href");

        $(".menuListDiv").html("<center><i class='fa fa-spin fa-circle-notch fa-2x'></i></center>");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: href,
            type: "get",
            success: function(e) {
                $(".menuListDiv").html(e);
            }
        });
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

    $(document).on('click', '#view_order', function() {
        $("#loadDisplayDiv").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
        $('#loadModal').modal('show');
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
                $("#loadDisplayDiv").html(e);
            }
        });
    });

    $(document).on('click', '#declineOrderBtn', function(e) {
        e.preventDefault();
        var href = $(this).data("href");
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");

        if (confirm('Are you sure')) {
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
                            toastr.error(e.errors[i], "Error", {timeOut: 4000});
                        }
                        $("#declineOrderBtn").html("Decline");
                    }else {
                        $('#loadModal').modal('hide');
                        toastr.success(e.message, "Success", {timeOut: 3000});
                    }
                }
            });
        }
    });

    $(document).on('click', '#confirmOrderBtn', function(e) {
        e.preventDefault();
        var href = $(this).data("href");
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");

        if (confirm('Are you sure')) {
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
                            toastr.error(e.errors[i], "Error", {timeOut: 4000});
                        }
                        $("#confirmOrderBtn").html("Confirm");
                    }else {
                        $('#loadModal').modal('hide');
                        toastr.success(e.message, "Success", {timeOut: 3000});
                    }
                }
            });
        }
    });

    $(document).on('click', '#addMenuBtn', function() {
        $("#loadDisplayDiv").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
        $('#loadModal').modal('show');
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
                $("#loadDisplayDiv").html(e);
            }
        });
    });

    $(document).on('submit', '#addMenuForm', function(e) {
        e.preventDefault();
        $("#addMenuFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");
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
                    $("#addMenuFormBtn").prop('disabled', false).html("SUBMIT");
                }else {
                    toastr.success(e.message, "Success", {timeOut: 5000});
                    $('#loadModal').modal('hide');
                    $("#menuCategoryBtn_" + e.category).click();
                }
            }
        });
    });

    $(document).on('click', '#deleteMenuCategoryBtn', function() {
        if (confirm('Are you sure you want to delete this category. All menu added to this category will be moved to the unsorted list')) {

            $("#loadDisplayDiv").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
            $('#loadModal').modal('show');
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
                            toastr.error(e.errors[i], "Error", {timeOut: 5000});
                        }
                        $('#loadModal').modal('hide');
                    }else {
                        toastr.success(e.message, "Success", {timeOut: 5000});
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                }
            });

        }
    });

    $(document).on('click', '#addMenuCategoryBtn', function() {
        $("#loadDisplayDiv").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
        $('#loadModal').modal('show');
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
                $("#loadDisplayDiv").html(e);
            }
        });
    });

    $(document).on('submit', '#addMenuCategoryForm', function(e) {
        e.preventDefault();
        $("#addMenuCategoryFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");
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
                    $("#addMenuCategoryFormBtn").prop('disabled', false).html("Add Category");
                }else {
                    toastr.success(e.message, "Success", {timeOut: 5000});
                    window.location.reload();
                }
            }
        });
    });

    $(document).on('click', '#editMenuCategoryBtn', function() {
        $("#loadDisplayDiv").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
        $('#loadModal').modal('show');
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
                $("#loadDisplayDiv").html(e);
            }
        });
    });

    $(document).on('submit', '#editMenuCategoryForm', function(e) {
        e.preventDefault();
        $("#editMenuCategoryFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");
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
                    $("#editMenuCategoryFormBtn").prop('disabled', false).html("Edit Category");
                }else {
                    toastr.success(e.message, "Success", {timeOut: 5000});
                    window.location.reload();
                }
            }
        });
    });

    $(document).on('click', '#editMenuBtn', function() {
        $("#loadDisplayDiv").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
        $('#loadModal').modal('show');
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
                $("#loadDisplayDiv").html(e);
            }
        });
    });

    $(document).on('submit', '#editMenuForm', function(e) {
        e.preventDefault();
        $("#editMenuFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");
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
                    $("#editMenuFormBtn").prop('disabled', false).html("Edit Menu");
                }else {
                    toastr.success(e.message, "Success", {timeOut: 5000});
                    $('#loadModal').modal('hide');
                    $("#menuCategoryBtn_" + e.category).click();
                }
            }
        });
    });

    $(document).on('submit', '#changePasswordForm', function(e) {
        e.preventDefault();
        $("#changePasswordFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");
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
                    $("#changePasswordFormBtn").prop('disabled', false).html("CHANGE PASSWORD");
                }else {
                    toastr.success(e.message, "Success", {timeOut: 5000});
                    window.location.reload();
                }
            }
        });
    });

    $(document).on('click', '#deleteMenuBtn', function() {
        if (confirm('Are you sure you want to delete this menu')) {

            $("#loadDisplayDiv").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
            $('#loadModal').modal('show');
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
                            toastr.error(e.errors[i], "Error", {timeOut: 5000});
                        }
                        $('#loadModal').modal('hide');
                    }else {
                        toastr.success(e.message, "Success", {timeOut: 5000});
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                }
            });

        }
    });

    $(document).on('click', '#toggleMenuStock', function() {
        $("#loadDisplayDiv").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
        $('#loadModal').modal('show');
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
                        toastr.error(e.errors[i], "Error", {timeOut: 5000});
                    }
                    $('#loadModal').modal('hide');
                }else {
                    toastr.success(e.message, "Success", {timeOut: 5000});
                    $('#loadModal').modal('hide');
                    $("#menuCategoryBtn_" + e.category).click();
                }
            }
        });
    });

    $(document).on('click', '.cover-image', function() {
        $("#cover-file").click();
        $('.cover-image').css("background-image","url('')");
    });

    $(document).on('click', '.cover-txt', function() {
        $("#cover-file").click();
        $('.cover-image').css("background-image","url('')");
    });

    $(document).on('change', '#cover-file', function() {
        $("#addMenuFormBtn").prop("disabled", true);
        $("#addMenuFormBtn").html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");
        var reader = new FileReader();
        var file = this.files[0];
         var imagefile = file.type;
         var match= ["image/jpeg","image/png","image/jpg"];
         if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
         {
            toastr.error("Invalid image file (upload jpg, jpeg, png file)", "Error", {timeOut: 5000});
            $("#addMenuFormBtn").prop("disabled", true);
            $("#addMenuFormBtn").html("Add Menu");
         }else {

              reader.onload = function() {
              $('.cover-image').css("background-image","url(" + reader.result + ")");
               };
              reader.readAsDataURL(event.target.files[0]);
              $("#addMenuFormBtn").prop("disabled", false);
              $("#addMenuFormBtn").html("Add Menu");
        };
      });

});
