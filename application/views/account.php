<section class="hero-wrap hero-wrap-2" style="background-image: url('<?=base_url()."assets/";?>images/bg_3.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Account</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?=base_url();?>">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Account <i class="ion-ios-arrow-forward"></i></span></p>
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

                <p> <br>
                <input type="text" id="changed_email" name="changed_email" placeholder=" Enter Destination"> &nbsp;&nbsp; <button type="submit" id="change_email" class="btn btn-primary py-1 px-3">Change Most Recent Offer's Destination</button> <br/> <br/>

                <button type="submit" id="delete_account" name="delete_account" class=" py-1 px-3">Delete All My Posts</button></p>
    <div class="col-md-12" id="response"></div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtZZ49a-AIC_xYCSgwh09xKzYL6zr89p4&libraries=places&callback=init" async defer></script>
 
<script>
    $(document).ready(function() {
        $("#change_email").click(function(event){
            $(".err_span").html("");
            event.preventDefault();
            var changed_email = $('#changed_email').serialize();
            console.log(changed_email);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('account/change_email') ?>",
                data: changed_email,
                dataType : "json",
                success: function (response){
                    if(response.status){
                        $("#changed_email").html(response.message);
                       
                    }else{
                        $("#changed_email").html(response.message);
                    }
                }
            });
            return false;
        }); 
        $("#delete_account").click(function(event){
            $(".err_span").html("");
            event.preventDefault();
            var delete_account = $('#delete_account').serialize();
            console.log(delete_account);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('account/delete_account') ?>",
                data: delete_account,
                dataType : "json",
                success: function (response){
                    if(response.status){
                        $("#delete_account").html(response.message);
                       
                    }else{
                        $("#delete_account").html(response.message);
                    }
                }
            });
            return false;
        }); 
    });
    
</script>