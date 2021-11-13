<?php 
require('top.inc.php');
?>
<div class="container">
  <h2>Carousel Example</h2>  
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="la.jpg" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="chicago.jpg" alt="Chicago" style="width:100%;">
      </div>
    
      <div class="item">
        <img src="ny.jpg" alt="New york" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

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
                                    <h2 class="title__line--6">Login</h2>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <form id="login-form" action="" method="post">
                                    <div class="single-contact-form">
                                        <div class="contact-box name">
                                            <input type="email" name="login_email" id="login_email" placeholder="Your Email*" style="width:100%">
                                        </div>
                                         <span class="login_error" id="login_email_error" style="color: red;"></span>
                                    </div>
                                    <div class="single-contact-form">
                                        <div class="contact-box name">
                                            <input type="password" name="login_password" id="login_password" placeholder="Your Password*" style="width:100%">
                                        </div>
                                         <span class="login_error" id="login_pass_error" style="color: red;"></span>
                                    </div>
                                    
                                    <div class="contact-btn">
                                        <button type="submit" name="login" onclick="User_Login()" class="fv-btn">Login</button>
                                    </div>
                                    <br/>
                                    <h4> Forgot Password Don't werry !<a href="Forgot_password.php" style="color:red;"> Click Here </a> </h4>
                                </form>
                                <div class="form-output login_error_message">
                                    <p class="form-messege"></p>
                                </div>
                            </div>
                        </div> 
                
                </div>
                

                    <div class="col-md-6">
                        <div class="contact-form-wrap mt--60">
                            <div class="col-xs-12">
                                <div class="contact-title">
                                    <h2 class="title__line--6">Register</h2>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <form id="register-form" action="" method="post">
                                    <div class="single-contact-form">
                                        <div class="contact-box name">
                                            <input type="text" name="name" id="name" placeholder="Your Name*" style="width:100%">
                                        </div>
                                        <span class="field_error" id="name_error" style="color: red;"></span>
                                    </div>
                                    <div class="single-contact-form">
                                        <div class="contact-box name">
                                            <input type="text" name="email" id="email" placeholder="Your Email*">
                                            <button type="button" class="fv-btn send_otp height_80px" onclick="send_otp()">Send OTP</button>
                                            <input type="text" id="otp" placeholder="Enter OTP" class="fv-btn verify_otp">
                                            <button type="button" onclick="verify_otp()" class="fv-btn verify_otp">Verify Email </button>

                                            <span class="field_error" id="email_verify" style="color: green; font-size: 18px; margin-top: 15px; font-weight: 750;" ></span>
                                        </div>
                                        <span class="field_error" id="email_error" style="color: red;" ></span>
                                    </div>
                                    <div class="single-contact-form">
                                        <div class="contact-box name">
                                            <input type="text" name="mobile" id="mobile" placeholder="Your Mobile*" style="width:100%">
                                        </div>
                                        <span class="field_error" id="mobile_error" style="color: red;"></span>
                                    </div>
                                    <div class="single-contact-form">
                                        <div class="contact-box name">
                                            <input type="password" name="password" id="password" placeholder="Your Password*" style="width:100%">
                                        </div>
                                        <span class="field_error" id="pass_error" style="color: red;" ></span>
                                    </div>
                                    
                                    <div class="contact-btn">
                                        <button type="button" onclick="User_register()" class="fv-btn register" disabled>Register</button>
                                    </div>
                                </form>
                                <div class="form-output register_error_message">
                                    <p class="form-messege"></p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </section>
        <!-- End Contact Area -->
        <input type="hidden" id="is_email_verified"/>
<script>
    
function send_otp() {
    $('#email_error').html('');
    var email = $('#email').val();
    if(email == ''){

        $('#email_error').html("Please Enter Email ID ");
    }else{

        $('.send_otp').html('Pleas Wait...');
        $('.send_otp').attr('disabled',true);

        $.ajax({
            url : 'send_otp.php',
            type : 'post',
            data : 'email='+email+'&type=email',
            success : function(result){
                if(result ==''){

                    $('#email_error').html('Please Try After Sometimes');
                    $('.send_otp').html('Send OTP');
                    $('.send_otp').attr('disabled',false);

                }else if(result == 'Email Already Present'){

                    $('#email_error').html('EMAIL IS Allready register');

                }else{
                    $('#email').attr('disabled',true);
                    $('.verify_otp').show();
                    $('.send_otp').hide();
                }
            }
        });
    }
}

function verify_otp() {

    $('#email_error').html('');
    var otp_check = $('#otp').val();
    if(otp_check == ''){

        $('#email_error').html("Please Enter OTP ");
        
    }else{

        $.ajax({
            url : 'check_otp.php',
            type : 'post',
            data : 'otp='+otp_check+'&type=email',
            success : function(result){

                if(result == 'done'){

                    $('.verify_otp').hide();
                    $('#email_verify').html("Email is Verified");
                    $('#is_email_verified').val('1');
                    if($('#is_email_verified').val() == 1){
                        $('.register').attr('disabled',false);
                    }
                }else{
                    $('#email_error').html("YOUR OTP IS WRONG");
                }
            }
        });
    }
}

</script>
<?php
require('footer.inc.php');
?>








