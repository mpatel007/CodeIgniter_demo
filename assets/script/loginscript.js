$(document).ready(function () {
    $(function () {
        $("form[name='formdata']").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    email: 'email',
                },
                password: {
                    required: true,
                    minlength: 8
                },
            },
            messages: {
                email:
                {
                    email: "Please enter a valid email address",
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 Digits",
                },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: BASE_URL + 'index.php/user/process',
                    type: "POST",
                    data: $("#formdata").serialize(),
                    success: function (response) {
                        $('#email').val('');
                        $('#password').val('');
                        var data = JSON.parse(response);
                        if (data.status == 1) {
                            alert(data.msg);
                            window.location.replace(BASE_URL + 'index.php/dashbord');
                        } else {
                            alert(data.msg);
                        }

                    }
                });
            }
        });
    });

    $(function () {
        $("form[name='forgotpassword']").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    email: 'email',
                    remote: BASE_URL + 'index.php/user/forgotpasswordemailcheck',
                },
            },
            messages: {
                email:
                {
                    email: "Please enter a valid email address",
                    remote: 'Invalid email This email ID is not register. Please Register First.'
                },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: BASE_URL + 'index.php/user/forgotpasswordd',
                    type: "POST",
                    data: $("#forgotpassword").serialize(),
                    success: function (response) {
                       
                            $('#email').val('');
                    }
                });
            }
        });
    });
    
    $(function () {
        $("form[name='newpassword']").validate({
            rules: {
                password: {
                    minlength: 8
                },
                password_confirm: {
                    minlength: 8,
                    equalTo: "#password"
                }
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 Digits",
                },
                password_confirm: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 Digits",
                    equalTo: "Your new password and confirm password do not match",
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: BASE_URL + 'index.php/user/newpasswordset',
                    type: "POST",
                    data: $("#newpassword").serialize(),
                    success: function (response) {
                        var data = JSON.parse(response);
                        console.log(data);
                        if (data.status == 1) {
                            alert(data.msg);
                            $('#password').val('');
                            $('#password_confirm').val('');
                            window.location.replace(BASE_URL + 'index.php/user/login');
                        }else{
                            alert(data.msg);

                        }

                    }
                });
            }
        });
    });
});


