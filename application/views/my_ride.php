<section class="hero-wrap hero-wrap-2" style="background-image: url('<?=base_url()."assets/";?>images/bg_3.jpeg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">My rides</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?=base_url();?>">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>My rides <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section ftco-no-pt ftco-no-pb">
	<div class="container-fluid px-0">
	    <div class="row d-flex no-gutters">
            <div class="col-md-12 order-md-last ftco-animate makereservation p-4 p-md-5 pt-5" style="background:#fff;">
                <div class="py-md-5">
                    <div class="heading-section ftco-animate mb-5">
                        <h2 class="mb-4">My rides</h2>
                    </div>
                    <div id="result">
                        <table class="table" style="width:100%" id="intell_table1">
                            <thead class="">
                                <tr>
                                    <th>Ride id </th>
                                    <th>Leaving from</th>
                                    <th>Destination</th>
                                    <th>Leaving date</th>
                                    <th>Leaving time</th>
                                    <th>Seats</th>
                                    <th>Added on</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $row): ?>
                                    <tr>
                                        <td><?php echo $row->id; ?></td>
                                        <td><?php echo $row->leaving_from; ?></td>
                                        <td><?php echo $row->destination; ?></td>
                                        <td><?php echo $row->leaving_date; ?></td>
                                        <td><?php echo $row->leaving_time; ?></td>
                                        <td><?php echo $row->seats; ?></td>
                                        <td><?php echo $row->created_at; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
