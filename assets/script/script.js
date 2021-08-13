$(document).ready(function () {
    $(function () {
        $('form').validate({
            rules: {
                fname: "required",
                contect:{
                    required: true,
                    minlength: 10
                },
                genderr: "required",
                email: {
                    required: true,
                    email: true,
                    email:'email',
                    remote: BASE_URL + 'index.php/user/emailcheck',
                },
                password: {
                    required: true,
                    minlength: 8
                },
                country: "required",
                state: "required",
                city: "required",
            },
            messages: {
                fname: "Please enter your Full name",
                contect: "Please enter your Contect number",
                email:
                {
                    email: "Please enter a valid email address",
                    remote: 'Email already used. Log in to your existing account.'
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 Digits",
                },
                genderr: "please select gender",
                country: "Please Select County",
                state: "Please Select State",
                city: "Please Select City",
            },
            submitHandler: function (form) {
                // e.preventDefault();
                var formdata = new FormData($('#formdata')[0]);
                $.ajax({
                    url: BASE_URL + 'index.php/user/insertData',
                    type: 'POST',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formdata,
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.status == 1) {
                            alert(data.msg);
                            $('#fname').val('');
                            $('#contect').val('');
                            $('#email').val('');
                            $('#password').val('');
                            $('#gender').prop('checked', false);
                            $('#country').val('');
                            $('#state').val('');
                            $('#city').val('');
                            $('#fileupload').val('');
                            $('#checkbox').val('');
                        } else {
                            alert(data.msg);
                        }
                    },
                });
            }
        });
    });

    //file upload file name
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $('#country').on('change', function () {
        // alert($(this).val());
        $.ajax({
            url: BASE_URL + 'index.php/user/selectstate',
            type: 'POST',
            data: {
                country: $(this).val()
            },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status == 1) {
                    $('#statelist').html('');
                    var result = data.list;
                    $('#statelist').html(result);
                }
            }
        });
    });
    $('body').on('change', '#state', function () {
        // alert($(this).val());
        $.ajax({
            url: BASE_URL + 'index.php/user/selectcity',
            type: 'POST',
            data: {
                state: $(this).val()
            },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status == 1) {
                    $('#citylist').html('');
                    var result = data.list;
                    $('#citylist').html(result);
                }
            }
        });
    });
});




