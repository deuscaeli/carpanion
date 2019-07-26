<section class="hero-wrap hero-wrap-2" style="background-image: url('<?=base_url()."assets/";?>images/bg_2.jpeg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Register Now</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?=base_url();?>">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Register <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container-fluid px-0">
        <div class="row d-flex no-gutters">
            <div class="col-md-12 order-md-last ftco-animate makereservation p-4 p-md-5 pt-5">
          	    <div class="py-md-5" >
                    <div class="heading-section ftco-animate mb-5 text-center">
                        <span class="subheading">Register</span>
                        <h2 class="mb-4">Join us to share your rides?</h2>
                    </div>
                    <div id="response"></div>
                    <form id="register_customer" novalidate  enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                                    <span id="err_name" class="text-danger err_span"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email id</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email id">
                                    <span id="err_email" class="text-danger err_span"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">Phone number</label>
                                    <input type="text" class="form-control" maxlength="10" onkeypress="return isNumberKey(event)" id="phone" name="phone" placeholder="Enter your phone number">
                                    <span id="err_phone" class="text-danger err_span"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="licence">Licence</label>
                                    <input type="text" class="form-control" id="licence" name="licence" placeholder="Enter your licence number">
                                    <span id="err_licence" class="text-danger err_span"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <span id="err_gender" class="text-danger err_span"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                    <span id="err_password" class="text-danger err_span"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password">
                                    <span id="err_confirm_password" class="text-danger err_span"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                    <button type="submit" class="btn btn-primary py-3 px-5">Register</button>
                                    <button type="reset" class="btn btn-danger py-3 px-5">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
	            </div>
            </div>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#register_customer").submit(function(event){
            $(".err_span").html("");
            event.preventDefault();
            var formData = new FormData();
            formData.append('licence', $('#licence').val());
            formData.append('name', $('#name').val());
            formData.append('email', $('#email').val());
            formData.append('phone', $('#phone').val());
            formData.append('gender', $('#gender').val());
            formData.append('password', $('#password').val());
            formData.append('confirm_password', $('#confirm_password').val());
            formData.append("<?=$this->security->get_csrf_token_name();?>", "<?=$this->security->get_csrf_hash();?>");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('register/register_customer') ?>",
                data: formData,
                dataType : "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response){
                    if(response.status){
                        $("#response").html(response.message);
                        $("#register_customer").trigger("reset");
                        setTimeout(function(){ $("#response").html(""); }, 3000);
                    }else{
                        $("#err_name").html(response.message.name);
                        $("#err_email").html(response.message.email);
                        $("#err_phone").html(response.message.phone);
                        $("#err_gender").html(response.message.gender);
                        $("#err_licence").html(response.message.licence);
                        $("#err_password").html(response.message.password);
                        $("#err_confirm_password").html(response.message.confirm_password);
                    }
                }
            });
            return false;
        });
    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

        return true;
    }

    function validateFileType(name,id){
        var fileName = document.getElementById(name+id).value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
        }else{
            $("#"+name+id).val('');
            alert("Only images are allowed!");
        }
    }

</script>
