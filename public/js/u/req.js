function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$(document).ready(function() {

    setTimeout(function() {
        $(".menuCategoryBtn:first").click();
    },100);

    $(document).on('click', '.authNavBtn', function() {
        $('.authNavBtn').removeClass('authNavActive');
        $(this).addClass('authNavActive');
        var page = $(this).data("href");

        $("#authDisplayDiv").html("<center><br><br><i class='fa fa-spin fa-circle-notch fa-2x' style='color:rgb(120,120,120);'></i><br><br></center>");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: page,
            type: "get",
            success: function(e) {
                $("#authDisplayDiv").html(e);
            }
        });
    });

    $(document).on('click', '.menuCategoryBtn', function() {
        $('.menuCategoryBtn').removeClass('menuCategoryActive');
        $(this).addClass('menuCategoryActive');

        var vendor = $(this).data('vendor');
        var category = $(this).data('category');

        $(".menuListDiv").html("<center><i class='fa fa-spin fa-circle-notch fa-2x'></i></center>");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "../../request/menu/"+vendor+"/"+category,
            type: "get",
            success: function(e) {
                $(".menuListDiv").html(e);
            }
        });
    });


    $(document).on('click', '#selectServiceBtn', function() {
        $("#loadVendorByLocation").val($(this).data("load"));
        $("#vendorLocationForm").submit();
    });

    $(document).on('submit', '#authLoginForm', function(e) {
        e.preventDefault();

        var href = $(this).data('href');

        $("#authLoginFormBtn").prop('disabled',true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");

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
                    $("#authLoginFormBtn").prop('disabled',false).html("SIGN IN");
                }else {
                    toastr.success(e.message, "Signed In", {timeOut: 5000});
                    window.location.reload();
                }
            }
        });
    });

    $(document).on('submit', '#authRegisterForm', function(e) {
        e.preventDefault();

        var href = $(this).data('href');

        $("#authRegisterFormBtn").prop('disabled',true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");

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
                    $("#authRegisterFormBtn").prop('disabled',false).html("SUBMIT");
                }else {
                    toastr.success(e.message, "Signed Up", {timeOut: 5000});
                    window.location.reload();
                }
            }
        });
    });

    $('#vendorLocationForm').submit(function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:"request/vendor/location",
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
                }else {
                    window.location = 'vendors/' + $("#loadVendorByLocation").val() ;
                }
            }
        });
    });


    $(document).on('click', '.addToCartBtn', function() {
        $(this).html(" &nbsp; <i class='fa fa-spin fa-spinner'></i> &nbsp; ");
        var menu_id = $(this).data("menu");
        $("#inputCartMenuID").val(menu_id);
        $("#addToCartForm").submit();
    });

    $(document).on('submit', '#addToCartForm', function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:"../../request/cart",
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
                    $("#cart_btn_"+e.menu).html("<i class='fa fa-plus'></i> Add <i class='fa fa-shopping-cart'></i>");
                }else {
                    if(e.auth == false) {
                        $('#authModal').modal('show');
                        $('#authNavLogin').click();
                        $("#cart_btn_"+e.menu).html("<i class='fa fa-plus'></i> Add <i class='fa fa-shopping-cart'></i>");
                    }else {
                        $("#cart_btn_"+e.menu).html("<i class='fa fa-plus'></i> Add <i class='fa fa-shopping-cart'></i>");
                        if(e.count == 0) {
                            $("#cart-checkout-btn").prop('disabled', true);
                        }else {
                            $("#cart-checkout-btn").prop('disabled', false);
                        }
                        refreshCart(e.vendor);
                    }
                }
            }
        });
    });

    $(document).on('click', '#remove-cart-btn', function() {

        var id = $(this).data('id');

        $("#cart-div").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "../../request/cart/delete/"+id,
            type: "get",
            success: function(e) {
                //$(".menuListDiv").html(e);
                if(e.errors != null) {
                    for(i in e.errors) {
                        toastr.error(e.errors[i], "Error", {timeOut: 5000});
                    }
                }else {
                    if(e.count == 0) {
                            $("#cart-checkout-btn").prop('disabled', true);
                        }else {
                            $("#cart-checkout-btn").prop('disabled', false);
                        }
                    refreshCart(e.vendor);
                }
            }
        });
    });

    $(document).on('click', '#decrease-cart-btn', function() {

        var id = $(this).data('id');

        $("#cart-div").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "../../request/cart/decrease/"+id,
            type: "get",
            success: function(e) {
                //$(".menuListDiv").html(e);
                if(e.errors != null) {
                    for(i in e.errors) {
                        toastr.error(e.errors[i], "Error", {timeOut: 5000});
                    }
                }else {
                    if(e.count == 0) {
                            $("#cart-checkout-btn").prop('disabled', true);
                        }else {
                            $("#cart-checkout-btn").prop('disabled', false);
                        }
                    refreshCart(e.vendor);
                }
            }
        });
    });

    $(document).on('click', '#increase-cart-btn', function() {

        var id = $(this).data('id');

        $("#cart-div").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "../../request/cart/increase/"+id,
            type: "get",
            success: function(e) {
                //$(".menuListDiv").html(e);
                if(e.errors != null) {
                    for(i in e.errors) {
                        toastr.error(e.errors[i], "Error", {timeOut: 5000});
                    }
                }else {
                    if(e.count == 0) {
                            $("#cart-checkout-btn").prop('disabled', true);
                        }else {
                            $("#cart-checkout-btn").prop('disabled', false);
                        }
                    refreshCart(e.vendor);
                }
            }
        });
    });

    function refreshCart(id) {
        $(".custom-checkout").prop('disabled', true).html("<i class='fa fa-spin fa-circle-notch'></i>");
        $("#cart-div").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
        $("#orderCoupon").val("");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "../../request/cart/"+id,
            type: "get",
            success: function(e) {
                $("#cart-div").html(e);
                $(".custom-checkout").prop('disabled', false).html("PROCEED TO CHECKOUT");
            }
        });
    }

    $("#showLoginAuth").click(function() {
        $('#authModal').modal('show');
        $('#authNavLogin').click();
    });

    $("#showRegisterAuth").click(function() {
        $('#authModal').modal('show');
        $('#authNavRegister').click();
    });

    $(document).on('click', '.addressDiv', function() {
        $("#addressHidden").val($(this).data("id"));
        $('.addressDiv').removeClass('addressDivActive');
        $(this).addClass('addressDivActive');
        $('.activeAddressTag').css('display','none');
        $(this).find('.activeAddressTag').css('display','inline-block');
    });

    $(document).on('click', '#addAddressBtn', function() {
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

    $(document).on('submit', '#addAddressForm', function(e) {
        e.preventDefault();
        $("#addAddressFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");
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
                    $("#addAddressFormBtn").prop('disabled', false).html("SUBMIT");
                }else {
                    window.location.reload() ;
                }
            }
        });
    });

    $(document).on('click', '#order-checkout-btn', function() {
        var address = $("#addressHidden").val();
        if (address == "") {
            toastr.error('No delivery address specified', 'Error', {timeOut: 5000})
        }else {
            if($("#payOnDeviveryRadio").is(':checked')) {
                orderSummary('cash', address);
            }

            if($("#payOnlineRadio").is(':checked')) {
                orderSummary('card', address);
            }
        }
    });

    function orderSummary(type, address) {
        $("#loadDisplayDiv").html("<center><br><i class='fa fa-spin fa-circle-notch fa-2x'></i></center><br>");
        $('#loadModal').modal('show');
        var coupon = "null";
        if(!$("#mCoupon").val()) {
            coupon = "null" ;
        }else {
            var init = $("#mCoupon").val();
            if(!init.replace(/\s/g, '').length) {
                coupon = "null"
            }else {
                coupon = $("#mCoupon").val();
            }
        }

        //Validate Address
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "../../request/order/"+$("#order-checkout-btn").data("vendor")+"/summary/"+address+"/"+type+"/"+coupon,
            type: "get",
            success: function(e) {
                if(e.errors) {
                    if (e.stock == true) {
                        for(i in e.errors) {
                            toastr.error(e.errors[i], "Error", {timeOut: 5000});
                        }
                        $('#loadModal').modal('hide');
                    }else {
                        for(i in e.errors) {
                            toastr.warning(e.errors[i], "Error", {timeOut: 5000});
                        }
                        $('#loadModal').modal('hide');
                        refreshCart(e.vendor);
                    }
                }else {
                    $("#loadDisplayDiv").html(e);
                }
            }
        });

    }

    $(document).on('submit', '#checkCouponForm', function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:"../../request/coupon",
            type: "POST",
            data: new FormData(this),
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            success: function(e) {
                if(e.errors != null) {
                    for(i in e.errors) {
                        toastr.error(e.errors[i], "Error", {timeOut: 3000});
                    }
                    $("#couponDiv").css('display','none');
                    $("#mCoupon").val("");
                    $("#couponSpan").html("0");
                    $("#orderTotal").html($("#orderTotalHidden").val());
                }else {
                    toastr.success(e.message, "Success", {timeOut: 3000});
                    var getTotal = parseFloat($("#orderTotalHidden").val()) - parseFloat(e.amount) ;
                    var total = 0 ;
                    if(getTotal < 0) {
                        total = 0
                    }else {
                        total = getTotal ;
                    }
                    $("#orderTotal").html(total);
                    $("#mCoupon").val(e.coupon);
                    $("#couponSpan").html("-"+e.amount);
                    $("#couponDiv").css('display','block');
                }
            }
        });
    });

    $(document).on('click', '#order_list', function() {
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

    $(document).on('click', '#editAddress', function() {
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
                        toastr.error(e.errors[i], "Error", {timeOut: 3000});
                        $('#loadModal').modal('hide');
                    }
                }else {
                    $("#loadDisplayDiv").html(e);
                }
            }
        });
    });

    $(document).on('click', '#deleteAddress', function() {
        var btn = $(this) ;
        btn.html("<i class='fa fa-spin fa-spinner'></i>");
        var href = $(this).data("href");

        if (confirm('Are you sure you want to delete address from your address book')) {
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
                            btn.html("<i class='fa fa-trash'></i> Delete");
                        }
                    }else {
                        window.location.reload() ;
                    }
                }
            });
        }
    });

    $(document).on('click', '#makeDefaultAddress', function() {
        var btn = $(this) ;
        btn.html("<i class='fa fa-spin fa-spinner'></i>");
        var href = $(this).data("href");

        if (confirm('Are you sure you want to set this address as your default address')) {
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
                            btn.html("<i class='fa fa-trash'></i> Delete");
                        }
                    }else {
                        window.location.reload() ;
                    }
                }
            });
        }
    });

    $(document).on('submit', '#editAddressForm', function(e) {
        e.preventDefault();
        $("#editAddressFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");
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
                    $("#editAddressFormBtn").prop('disabled', false).html("SUBMIT");
                }else {
                    window.location.reload() ;
                }
            }
        });
    });

    $(".favoriteVendor").click(function() {
        var href = $(this).data("href")
        $(".favoriteVendor").html("<i class='fa fa-spin fa-spinner'></i>");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: href,
            type: "get",
            success: function(e) {
                if (e.status == true) {
                    $(".favoriteVendor").html("<i class='fa fa-heart siteColor'></i>");
                    toastr.success(e.message, "Success", {timeOut: 5000});
                }else {
                    $(".favoriteVendor").html("<i class='fa fa-heart'></i>");
                    toastr.warning(e.message, "Success", {timeOut: 5000});
                }
            }
        });
    });

    $(document).on('submit', '#editProfleForm', function(e) {
        e.preventDefault();
        $("#editProfileFormBtn").prop('disabled', true).html(" &nbsp; <i class='fa fa-spin fa-circle-notch'></i> &nbsp; ");
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
                    $("#editProfileFormBtn").prop('disabled', false).html("SAVE");
                }else {
                    window.location.reload() ;
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
                    $("#changePasswordFormBtn").prop('disabled', false).html("SUBMIT");
                }else {
                    toastr.success(e.message, "Success", {timeOut: 3000});
                    $("#changePasswordFormBtn").prop('disabled', false).html("SUBMIT");
                    //window.location.reload() ;
                    $("#changePasswordForm").find('input').val("");
                }
            }
        });
    });

});
