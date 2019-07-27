<section class="hero-wrap hero-wrap-2" style="background-image: url('<?=base_url()."assets/";?>images/bg_3.jpeg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Account</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?=base_url();?>">Home <i
                                class="ion-ios-arrow-forward"></i></a></span> <span>Account <i
                            class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section ftco-wrap-about ftco-no-pb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 wrap-about ftco-animate text-center">
                <div class="heading-section mb-4 text-center">
                    <span class="subheading">Account</span>
                </div>
                <form id="register_customer" novalidate enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?=$data->name;?>"
                                    placeholder="Enter your name">
                                <span id="err_name" class="text-danger err_span"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email id</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?=$data->email;?>" placeholder="Enter your email id">
                                <span id="err_email" class="text-danger err_span"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">Phone number</label>
                                <input type="text" class="form-control" maxlength="10" value="<?=$data->phone;?>"
                                    onkeypress="return isNumberKey(event)" id="phone" name="phone"
                                    placeholder="Enter your phone number">
                                <span id="err_phone" class="text-danger err_span"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="licence">Licence</label>
                                <input type="text" class="form-control" id="licence" value="<?=$data->licence;?>"
                                    name="licence" placeholder="Enter your licence number">
                                <span id="err_licence" class="text-danger err_span"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <?php if($data->gender=="Male"){
                            echo '<option value="Male" selected>Male</option>
                            <option value="Female">Female</option>';
                        }else{
                            echo '<option value="Male" >Male</option>
                            <option value="Female" selected>Female</option>';
                        }?>
                                </select>
                                <span id="err_gender" class="text-danger err_span"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter your password">
                                <span id="err_password" class="text-danger err_span"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="confirm_password">Confirm password</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" placeholder="Confirm your password">
                                <span id="err_confirm_password" class="text-danger err_span"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>"
                                    value="<?=$this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="id" id="id" value="<?=$data->id;?>" />
                                <button type="submit" class="btn btn-primary py-3 px-5">Update Account</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" id="changed_email" name="changed_email" placeholder=" Enter new Destination">
                        &nbsp;&nbsp;
                        <button type="submit" id="change_email" class="btn btn-primary py-1 px-3">Change Most Recent
                            Offer's Destination</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" id="delete_account" name="delete_account"
                            class="btn btn-primary py-1 px-3">Delete All My Posts</button></p>
                    </div>
                </div>
                <div class="col-md-12" id="response"></div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtZZ49a-AIC_xYCSgwh09xKzYL6zr89p4&libraries=places&callback=init"
    async defer></script>

<script>
$(document).ready(function() {
    $("#change_email").click(function(event) {
        $(".err_span").html("");
        event.preventDefault();
        var changed_email = $('#changed_email').serialize();
        console.log(changed_email);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('account/change_email') ?>",
            data: changed_email,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $("#changed_email").html(response.message);

                } else {
                    $("#changed_email").html(response.message);
                }
            }
        });
        return false;
    });
    $("#delete_account").click(function(event) {
        $(".err_span").html("");
        event.preventDefault();
        var delete_account = $('#delete_account').serialize();
        console.log(delete_account);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('account/delete_account') ?>",
            data: delete_account,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $("#delete_account").html(response.message);

                } else {
                    $("#delete_account").html(response.message);
                }
            }
        });
        return false;
    });

    $("#register_customer").submit(function(event) {
        $(".err_span").html("");
        event.preventDefault();
        var formData = new FormData();
        formData.append('licence', $('#licence').val());
        formData.append('name', $('#name').val());
        formData.append('email', $('#email').val());
        formData.append('phone', $('#phone').val());
        formData.append('gender', $('#gender').val());
        formData.append('id', $('#id').val());
        formData.append('password', $('#password').val());
        formData.append('confirm_password', $('#confirm_password').val());
        formData.append("<?=$this->security->get_csrf_token_name();?>",
            "<?=$this->security->get_csrf_hash();?>");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('account/update_customer') ?>",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    $("#response").html(response.message);
                    setTimeout(function() {
                        $("#response").html("");
                    }, 3000);
                } else {
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
</script>