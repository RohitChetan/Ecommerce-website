<?php 
require('top.inc.php');
?>

 <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Login</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Contact Area -->
        <section class="htc__contact__area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-form-wrap mt--60">
                            <div class="col-xs-12">
                                <div class="contact-title">
                                    <h2 class="title__line--6">FORGOT PASSWORD</h2>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <form id="login-form"  method="post">
                                    <div class="single-contact-form">
                                        <div class="contact-box name">
                                            <input type="email" name="email" id="email" placeholder="Your Email*" style="width:100%">
                                        </div>
                                         <span class="login_error" id="email_error" style="color: red;"></span>
                                    </div>
                                    <div class="contact-btn">
                                        <button type="submit" name="login" onclick="Forgot_password()" class="fv-btn forgot_button">Login</button>
                                    </div>
                                </form>
                                <div class="form-output login_error_message">
                                    <p class="form-messege"></p>
                                </div>
                            </div>
                        </div> 
                
                </div>
                
                </div>
            </div>
        </section>
        <!-- End Contact Area -->
        <input type="hidden" id="is_email_verified"/>
<script>

function Forgot_password(){

    $('#email_error').html('');
    var email = $('#email').val();

    if(email==''){

        $('#email_error').html('Please Enter Email ID');
    }else{

        $('.forgot_button').html('Pleas Wait...');
        $('.forgot_button').attr('disabled',true);

        $.ajax({

            url : 'Forgot_password_submit.php',
            type: 'POST',
            data : 'email='+email,
            success : function(result){

                $('#email').val('');
                $('.forgot_button').html('submit');
                $('.forgot_button').attr('disabled',false);
            }
        });
    }
}

</script>
<?php
require('footer.inc.php');
?>








