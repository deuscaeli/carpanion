<section class="hero-wrap hero-wrap-2" style="background-image: url('<?=base_url()."assets/";?>images/bg_4.jpeg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Login Now</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?=base_url();?>">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Login <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container-fluid px-0">
        <div class="row d-flex no-gutters">
            <div class="col-md-3"></div>
            <div class="col-md-6 order-md-last ftco-animate makereservation p-4 p-md-5 pt-5">
          	    <div class="py-md-5" >
                    <div class="heading-section ftco-animate mb-5 text-center">
                        <span class="subheading">Login here</span>
                        <!-- <h2 class="mb-4">Login to share your rides?</h2> -->
                    </div>
                    <form id="register_customer" novalidate>
                        <div class="row">
                            <div class="col-md-12" id="response"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone">Phone number</label>
                                    <input type="text" class="form-control" maxlength="10" onkeypress="return isNumberKey(event)" id="phone" name="phone" placeholder="Enter your phone number">
                                    <span id="err_phone" class="text-danger err_span"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                    <span id="err_password" class="text-danger err_span"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                    <button type="submit" class="btn btn-primary py-3 px-5">Login</button>
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
            var thidata = $("#register_customer").serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('login/check_login') ?>",
                data: thidata,
                dataType : "json",
                success: function (response){
                    if(response.status){
                        $("#response").html(response.message);
                        $("#register_customer").trigger("reset");
                        setTimeout(function(){ $("#response").html(""); location.href="<?=base_url()?>"}, 3000);
                    }else{
                        $("#err_phone").html(response.message.phone);
                        $("#err_password").html(response.message.password);
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

</script>
