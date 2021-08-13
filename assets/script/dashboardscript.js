$(document).ready(function () {
    loaduserlist();
    $('#submit').on('click', function (form) {
        // e.preventDefault();
        var formdata = new FormData($('#formdata')[0]);
        $.ajax({
            url: BASE_URL + 'index.php/dashbord/insertdata',
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            data:formdata,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status == 1) {
                    alert(data.msg);
                    $('#exampleModal').modal('hide');
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
                    loaduserlist();
                } else {
                    alert(data.msg);
                }
            },
        });
        loaduserlist();
    });
    //file upload file name
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $('.openmodal').on('click',function(){
        $('#exampleModal').modal('show');
    });
    $('#country').on('change', function(){
        // alert($(this).val());
        $.ajax({
            url: BASE_URL + 'index.php/dashbord/selectstate',
            type: 'POST',
            data: {
                country: $(this).val()
            },
            success: function (response) {
                var data = JSON.parse(response);
                console.log(data);
                if (data.status == 1) {
                    $('#statelist').html('');
                    var result = data.list;
                    $('#statelist').html(data.list);
                }
            }
        });
    });
    $('body').on('change', '#state', function () {
        // alert($(this).val());
        $.ajax({
            url: BASE_URL + 'index.php/dashbord/selectcity',
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
function fillstateedit(country_id, state_id) {
    $.ajax({
        url: BASE_URL + 'index.php/dashbord/selectstate',
        type: 'POST',
        data: {
            country: country_id,
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                $('#statelist').html('');
                $('#statelist').html(data.list);
                $('#state').val(state_id);
            }
        }
    });
}
function fillcityedit(country_id, state_id, city_id) {
    $.ajax({
        url: BASE_URL + 'index.php/dashbord/selectcity',
        type: 'POST',
        data: {
            state: state_id,
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                $('#citylist').html('');
                var result = data.list;
                $('#citylist').html(result);
                $('#city').val(city_id);
            }
        }
    });
}
function loaduserlist() {
    $('#servicetable').dataTable({
        "paging": true,
        "pageLength": 10,
        "bProcessing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {
            type: "post",
            url: BASE_URL + 'index.php/dashbord/userlist',

        },
        "aoColumns": [
            { mData: 'id' },
            { mData: 'name' },
            { mData: 'contact' },
            { mData: 'email' },
            { mData: 'password' },
            { mData: 'gender' },
            { mData: 'country_name' },
            { mData: 'state_name' },
            { mData: 'city_name' },
            { mData: 'image' },
            { mData: 'status' },
            { mData: 'creaded_at' },
            { mData: 'update_at' },
            { mData: 'action' },
        ],
        "order": [[0, "asc"]],
        "columnDefs": [{
            "targets": [13],
            "orderable": false
        }]
    });
}

function delData(id) {
    var con = confirm('Your are sure to delete this record ? ');
    if (con == true) {
        $.ajax({
            url: BASE_URL + 'index.php/dashbord/deleteuser',
            type: 'POST',
            data: {
                id: id,
            },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status == 1) {
                    alert(data.msg);
                    loaduserlist();
                } else {
                    alert(data.msg);
                }
            }
        });
    }
}

function editData(id) {
    $('#hid').val();
    $.ajax({
        url: BASE_URL + 'index.php/dashbord/edituser',
        type: 'POST',
        data: {
            id: id
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                $('#exampleModal').modal('show');
                $('#submit').html('Update');
                var result = data.list;
                console.log(result);
                $('#hid').val(result.id);
                $('#fname').val(result.name);
                $('#contect').val(result.contact);
                $('#email').val(result.email);
                $('#contect').val(result.contact);
                $('#' + result.gender).attr("checked", true);
                $('#country').val(result.country);
                fillstateedit(result.country, result.state);
                fillcityedit(result.country, result.state, result.city);
                $('#statusswitch').val(result.status);
            }
        }
    });
}
$('body').on('change', '.statusswitch',function(){

var id = $(this).data("id");
// alert(id);
    var status = 0;
    if($(this).prop("checked") == true){
        status = 1;
    }     
     $.ajax({
        url: BASE_URL + 'index.php/dashbord/changestatus',
        type: 'POST',
        data:{
            id: id,
            status : status,
        },
        success: function(){
            loaduserlist();
        },
    });
});



