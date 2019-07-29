<section class="home-slider owl-carousel js-fullheight">
    <div class="slider-item js-fullheight"
        style="background-image: url('<?=base_url() . "assets/";?>images/bg_2.jpeg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text js-fullheight justify-content-center align-items-center"
                data-scrollax-parent="true">

                <div class="col-md-12 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-4 mt-5">A spamfree rideshare</h1>
                    <!-- <p><a href="#" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a> <a href="#" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">View Menu</a></p> -->
                </div>

            </div>
        </div>
    </div>

    <div class="slider-item js-fullheight"
        style="background-image: url('<?=base_url() . "assets/";?>images/bg_3.jpeg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                <div class="col-md-12 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-4 mt-5">Connect with others</h1>
                    <!-- <p><a href="#" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a> <a href="#" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">View Menu</a></p> -->
                </div>

            </div>
        </div>
    </div>
</section>
<script src="https://unpkg.com/gojs/release/go-debug.js"></script>

<section>
    <div id="homeDiagram" style="width:800px; height:800px; background-color: #DAE4E4;"></div>
    <script>
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }
    var $ = go.GraphObject.make;
    var myDiagram =
        $(go.Diagram, "homeDiagram", {
            "undoManager.isEnabled": true,
            "panningTool.isEnabled": false
        });
    myDiagram.allowHorizontalScroll = false;
    myDiagram.allowVerticalScroll = false;
    myDiagram.nodeTemplate =
        $(go.Node, "Auto",
            $(go.Shape, "RoundedRectangle", {
                strokeWidth: 0,
                fill: "white"
            }, new go.Binding("fill", "color")),
            $(go.TextBlock, {
                margin: 8
            }, new go.Binding("text", "key"))
        );
    myDiagram.linkTemplate =
        $(go.Link, 
            {
                curve: go.Link.Bezier
            }, 
            {
                routing: go.Link.AvoidsNodes,
                corner: 10
            },
            $(go.Shape)
            // $(go.Shape, {
            //     toArrow: "Standard"
            // }) //arrowhead setting
        );
    var myModel = $(go.Model);
    var $links = [];
    var $nodes = [];
    <?php foreach ($users as $row): ?>
    $nodes.push({
        key: "<?php echo $row->name; ?>",
        color: "lightblue"
    })
    <?php endforeach?>

    <?php foreach ($locations as $row): ?>
    <?php $dest = explode(",", $row->destination); $destination = $dest[0];?>
    $nodes.push({
        key: "<?php echo $destination; ?>",
        color: "lightgreen"
    })
    <?php endforeach?>

    <?php foreach ($data as $row): ?>
    <?php $dest = explode(",", $row->destination); $destination = $dest[0];?> //parse the destination result to include only the first part
    // $nodes.push({
    //     key: "<?php echo $row->rider; ?>"
    // }, {
    //     key: "<?php echo $row->driver; ?>"
    // }, {
    //     key: "<?php echo $destination; ?>"
    // })
    // $nodes.push({
    //         key: "<?php echo $row->rider; ?>",
    //         color: "lightblue"
    //     },
    //     {
    //         key: "<?php echo $row->driver; ?>",
    //         color: "orange"
    //     },
    //     {
    //         key: "<?php echo $destination; ?>",
    //         color: "lightgreen"
    //     }
    // );
    $links.push({
        from: "<?php echo $row->rider; ?>",
        to: "<?php echo $row->driver; ?>"
    }, {
        from: "<?php echo $row->rider; ?>",
        to: "<?php echo $destination; ?>"
    }, {
        from: "<?php echo $row->driver; ?>",
        to: "<?php echo $destination; ?>"
    });
    <?php endforeach?>
    // myModel.nodeDataArray = $nodes;
    myDiagram.model = myModel;
    shuffleArray($nodes);
    myDiagram.model = new go.GraphLinksModel($nodes, $links);
    print_r($nodes);
    </script>
</section>

<section class="ftco-section ftco-wrap-about ftco-no-pb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 wrap-about ftco-animate text-center">
                <div class="heading-section mb-4 text-center">
                    <span class="subheading">About</span>
                    <h2 class="mb-4">CarPanion</h2>
                </div>
                <p>A CS411 Project</p>

                <!--<div class="video justify-content-center">
                        <a href="https://vimeo.com/45830194" class="icon-video popup-vimeo d-flex justify-content-center align-items-center">
                        <span class="ion-ios-play"></span>
                    </a>
                    </div>-->
            </div>
        </div>
    </div>
</section>


<section class="ftco-section ftco-counter img" id="section-counter"
    style="background-image: url('<?=base_url() . "assets/";?>images/bg_4.jpeg')" data-stellar-background-ratio="0.5">
    <!-- <section class="ftco-section ftco-counter img ftco-no-pt" id="section-counter"> -->
    <div class="container">
        <div class="row d-md-flex align-items-center justify-content-center">
            <div class="col-lg-10">
                <div class="row d-md-flex align-items-center">
                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">
                                <strong class="number" data-number="<?=$total_drivers;?>">0</strong>
                                <span>Drivers</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">
                                <strong class="number" data-number="<?=$total_customers;?>">0</strong>
                                <span>Customers</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">
                                <strong class="number" data-number="<?=$total_rides;?>">0</strong>
                                <span>Rides</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">
                                <strong class="number" data-number="<?=$total_bookings;?>">0</strong>
                                <span>Bookings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>