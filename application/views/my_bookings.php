<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= base_url() . "assets/"; ?>images/bg_3.jpeg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">My bookings</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url(); ?>">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>My bookings <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>
<script src="https://unpkg.com/gojs/release/go-debug.js"></script>


<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container-fluid px-0">
        <div class="row d-flex no-gutters">
            <div class="col-md-12 order-md-last ftco-animate makereservation p-4 p-md-5 pt-5" style="background:#fff;">
                <div class="py-md-5">
                    <div class="heading-section ftco-animate mb-5">
                        <h2 class="mb-4">My bookings</h2>
                    </div>
                    <div id="result">
                        <table class="table" style="width:100%" id="intell_table1">
                            <thead class="">
                                <tr>
                                    <th>Booking id </th>
                                    <th>Leaving from</th>
                                    <th>Destination</th>
                                    <th>Leaving date</th>
                                    <th>Leaving time</th>
                                    <th>Link chart</th>
                                    <th>Added on</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $row) : ?>
                                    <tr>
                                        <td><?php echo $row->id; ?></td>
                                        <td><?php echo $row->leaving_from; ?></td>
                                        <td><?php echo $row->destination; ?></td>
                                        <td><?php echo $row->leaving_date; ?></td>
                                        <td><?php echo $row->leaving_time; ?></td>
                                        <td>
                                            <div id="myDiagram<?php echo $row->id; ?>" style="width:500px; height:200px;">
                                            </div>
                                        </td>
                                        <td><?php echo $row->created_at; ?></td>
                                        <?php $dest = explode(",", $row->destination);
                                        $destination = $dest[0]; ?>
                                    </tr>
                                    <script>
                                        var $ = go.GraphObject.make;
                                        var myDiagram =
                                            $(go.Diagram, "myDiagram<?php echo $row->id; ?>", {
                                                "undoManager.isEnabled": true
                                            });

                                        var myModel = $(go.Model);
                                        // myModel.nodeDataArray = [{
                                        //         key: "<?php echo $row->rider; ?>"
                                        //     },
                                        //     {
                                        //         key: "<?php echo $row->driver; ?>"
                                        //     },
                                        //     {
                                        //         key: "<?php echo $destination; ?>"
                                        //     }
                                        // ];
                                        // myDiagram.model = myModel;

                                        myDiagram.nodeTemplate = $(go.Node, $(go.TextBlock, new go.Binding("text", "key")));

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

                                        myDiagram.model = new go.GraphLinksModel(
                                            [{
                                                    key: "<?php echo $row->rider; ?>",
                                                    color: "lightblue"
                                                },
                                                {
                                                    key: "<?php echo $row->driver; ?>",
                                                    color: "orange"
                                                },
                                                {
                                                    key: "<?php echo $destination; ?>",
                                                    color: "lightgreen"
                                                }
                                            ],
                                            [{
                                                    from: "<?php echo $row->rider; ?>",
                                                    to: "<?php echo $row->driver; ?>"
                                                },
                                                //  { from: "<?php echo $row->rider; ?>", to: "<?php echo $destination; ?>" },
                                                {
                                                    from: "<?php echo $row->driver; ?>",
                                                    to: "<?php echo $destination; ?>"
                                                }
                                            ]
                                        );
                                    </script>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>