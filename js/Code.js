
function send_message() {
    
    var name = $("#name").val();
    var email = $("#email").val();
    var mobile = $("#mobile").val();
    var subject = $("#subject").val();
    var message = $("#message").val();

    var is_erro = "";

    if(name == ''){

        alert("Please Enter Name");
    }else if(email == ''){

        alert("Please Enter Email");
    }else if(mobile == ''){

        alert("Please Enter Mobile");
    }else if(subject == ''){

        alert("Please Enter Subject");
    }else if(message == ''){

        alert("Please Enter Message");
    }else{

        $.ajax({

            url:'send_message.php',
            type:'POST',
            data : 'name='+name+'&email='+email+'&mobile='+mobile+'&subject='+subject+'&message='+message,
            success:function(res) {
                
                alert("MESSAGE SEND ");
            }
        });
    }
}



function User_register(){

    $('.field_error').html('');
    var name = $("#name").val();
    var email = $("#email").val();
    var mobile = $("#mobile").val();
    var password = $("#password").val();

    var is_erro = "";

    if(name == ''){

        $("#name_error").html("Please Enter Your Name");
        is_erro =='yes';
    }
    if(email == ''){

        $("#email_error").html("Please Enter Your Email");
        is_erro =='yes';
    }
    if(mobile == ''){

        $("#mobile_error").html("Please Enter Your Mobile");
        is_erro =='yes';
    }
    if(password == ''){

        $("#pass_error").html("Please Enter Your Password");
        is_erro =='yes';
    }

    if(is_erro==''){

        $.ajax({

            url:'User_register.php',
            type:'POST',
            data : 'name='+name+'&email='+email+'&mobile='+mobile+'&password='+password,
            success:function(res) {

                res=res.trim();
                if(res == 'Present'){

                    $('#email_error').html("Email IS Allready Register");
                }
                if(res == 'Insert'){

                    $('.register_error_message').html("SUCCESSFULL");

                }
            }
        });
    }
}


function User_Login(){

    $('.login_error').html('');
    var email = $("#login_email").val();
    var password = $("#login_password").val();

    var is_login = "";

    if(email == ''){

        $("#login_email_error").html("Please Enter Your Email");
        is_login =='yes';
    }
    if(password == ''){

        $("#login_password_error").html("Please Enter Your Password");
        is_login =='yes';
    }

    if(is_login==''){
        
        $.ajax({

            url:'User_Login.php',
            type:'POST',
            data : 'email='+email+'&password='+password,
            success:function(res) {

                res=res.trim();
                if(res == 'Try'){

                    $('#login_email_error').html("Email IS Not Register");
                }
                if(res == 'Insert'){
                    swal({
                          icon: "success",
                          timer: 5000,
                        });
                    window.location.href='index.php';
                }
            }
        });
    }

}

 
function Manage_cart(pid,type){

    if(type=='update'){ 
        var qty = $("#"+pid+"qty").val();
    }else{

        var qty = $('#Quantity').val();
    }
   
        $.ajax({

            url:'Manage_cart.php',
            type:'POST',
            data : 'pid='+pid+'&qty='+qty+'&type='+type,
            success:function(result) {

                if(type=='update' || type=='remove'){
                    window.location.href= window.location.href;
                }
                if(result=='not available'){

                    alert('Quantity Not Available');
                }else{
                    $('.htc__qua').html(result);
                }
            }
        });
}


function Sort_product_drop(cate_id,site_path){

    var sort_product_id = $('#sort_product_id').val();
    window.location.href=site_path+"categories.php?id="+cate_id+"&sort="+sort_product_id;
}

function Wishlist_Manage(pid,type){

    $.ajax({
            url:'Wishlist_Manage.php',
            type:'POST',
            data : 'pid='+pid+'&type='+type,
            cache: false,   
            success:function(result) {

                if(result=='Not Login'){
                    window.location.href='login.php';
                }else{
                    
                    $('.htc__wishlist').html(result);
                }
            }
        });

}




