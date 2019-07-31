<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= base_url() . "assets/"; ?>images/bg_3.jpeg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">My Bookings</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url(); ?>">Home <i
                                class="ion-ios-arrow-forward"></i></a></span> <span>My Bookings <i
                            class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>
<script src="https://unpkg.com/gojs@2.0.15/release/go-debug.js"></script>
<script src="https://gojs.net/latest/extensions/RadialLayout.js"></script>
<script>
    var links = [];
    var nodes = [];
    <?php foreach ($users as $row): ?>
    nodes.push({
        key: "<?php echo $row->name; ?>",
        color: "lightblue"
    });
    <?php endforeach?>

    <?php foreach ($locations as $row): ?>
    <?php $dest = explode(",", $row->destination); $destination = $dest[0];?>
    nodes.push({
        key: "<?php echo $destination; ?>",
        color: "lightgreen"
    });
    <?php endforeach?>

    <?php foreach ($graphlinks as $row): ?>
    <?php $dest = explode(",", $row->destination); $destination = $dest[0];?> //parse the destination result to include only the first part
    links.push({
        from: "<?php echo $row->rider; ?>",
        to: "<?php echo $destination; ?>", 
        color: go.Brush.randomColor(0, 127)
    }, {
        from: "<?php echo $row->driver; ?>",
        to: "<?php echo $destination; ?>", 
        color: go.Brush.randomColor(0, 127)
    });
    <?php endforeach?>
</script>
<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container-fluid px-0">
        <div class="row d-flex no-gutters">
            <div class="col-md-12 order-md-last ftco-animate makereservation p-4 p-md-5 pt-5" style="background:#fff;">
                <div class="py-md-5">
                    <div class="heading-section ftco-animate mb-5">
                        <h2 class="mb-4">My Bookings</h2>
                    </div>

                    <body onload="init()">
                        <div id="radialDiagram" style="background: white; width: 100%; height: 1000px; width: 1200px;"></div>
                        <script>
                        function init() {
                            var $ = go.GraphObject.make; // for conciseness in defining templates
                            radialDiagram =
                                $(go.Diagram, "radialDiagram", // must be the ID or reference to div
                                    {
                                        initialAutoScale: go.Diagram.Uniform,
                                        padding: 10,
                                        isReadOnly: true,
                                        layout: $(RadialLayout, {
                                            maxLayers: 2,
                                            rotateNode: function(node, angle, sweep, radius) {
                                                // rotate the nodes to make sure no text is not upside-down
                                                node.angle = angle;
                                                var label = node.findObject("TEXTBLOCK");
                                                if (label !== null) {
                                                    label.angle = ((angle > 90 && angle < 270 || angle < -
                                                            90) ?
                                                        180 : 0);
                                                }
                                            },
                                            commitLayers: function() { //add circles in the background
                                                var diagram = this.diagram;
                                                var gridlayer = diagram.findLayer("Grid");
                                                var circles = new go.Set( /*go.Part*/ );
                                                gridlayer.parts.each(function(circle) {
                                                    if (circle.name === "CIRCLE") circles.add(
                                                        circle);
                                                });
                                                circles.each(function(circle) {
                                                    diagram.remove(circle);
                                                });
                                                // add circles centered at the root
                                                var $ = go.GraphObject
                                                    .make; // for conciseness in defining templates
                                                for (var lay = 1; lay <= this.maxLayers; lay++) {
                                                    var radius = lay * this.layerThickness;
                                                    var circle =
                                                        $(go.Part, {
                                                                name: "CIRCLE",
                                                                layerName: "Grid"
                                                            }, {
                                                                locationSpot: go.Spot.Center,
                                                                location: this.root.location
                                                            },
                                                            $(go.Shape, "Circle", {
                                                                width: radius * 2,
                                                                height: radius * 2
                                                            }, {
                                                                fill: "rgba(200,200,200,0.2)",
                                                                stroke: null
                                                            }));
                                                    diagram.add(circle);
                                                }
                                            }
                                        }),
                                        "animationManager.isEnabled": false
                                    });

                            // shows when hovering over a node
                            var commonToolTip =
                                $("ToolTip",
                                    $(go.Panel, "Vertical", {
                                            margin: 3
                                        },
                                        $(go.TextBlock, // bound to node data
                                            {
                                                margin: 4,
                                                font: "bold 12pt sans-serif"
                                            },
                                            new go.Binding("text")),
                                        $(go.TextBlock, // bound to node data
                                            new go.Binding("text", "color", function(co) {
                                            if (co=="lightgreen") {
                                                return "Destination";
                                            } else if (co=="lightblue") {
                                                return "User";
                                            }
                                        })),
                                        $(go.TextBlock, // bound to Adornment because of call to Binding.ofObject
                                            new go.Binding("text", "", function(ad) {
                                                return "Connections: " + ad.adornedPart.linksConnected.count;
                                            }).ofObject())
                                    ) // end Vertical Panel
                                ); // end Adornment

                            // define the Node template
                            radialDiagram.nodeTemplate =
                                $(go.Node, "Spot", {
                                        locationSpot: go.Spot.Center,
                                        locationObjectName: "SHAPE", // Node.location is the center of the Shape
                                        selectionAdorned: false,
                                        click: nodeClicked,
                                        toolTip: commonToolTip
                                    },
                                    $(go.Shape, "Circle", {
                                            name: "SHAPE",
                                            fill: "lightgray", // default value, but also data-bound
                                            stroke: "transparent",
                                            strokeWidth: 2,
                                            desiredSize: new go.Size(20, 20),
                                            portId: "" // so links will go to the shape, not the whole node
                                        },
                                        new go.Binding("fill", "color")),
                                    $(go.TextBlock, {
                                            name: "TEXTBLOCK",
                                            alignment: go.Spot.Right,
                                            alignmentFocus: go.Spot.Left
                                        },
                                        new go.Binding("text","key"))
                                );

                            // add root node to nodeTemplate
                            radialDiagram.nodeTemplateMap.add("Root",
                                $(go.Node, "Auto", {
                                        locationSpot: go.Spot.Center,
                                        selectionAdorned: false,
                                        toolTip: commonToolTip
                                    },
                                    $(go.Shape, "Circle", {
                                        fill: "white"
                                    }),
                                    $(go.TextBlock, {
                                            font: "bold 12pt sans-serif",
                                            margin: 5
                                        },
                                        new go.Binding("text", "key"))
                                ));

                            // define the Link template
                            radialDiagram.linkTemplate =
                                $(go.Link, {
                                        routing: go.Link.Normal,
                                        curve: go.Link.Bezier,
                                        selectionAdorned: false,
                                        layerName: "Background"
                                    },
                                    $(go.Shape, {
                                            stroke: "black", // default value, but is data-bound
                                            strokeWidth: 1
                                        },
                                        new go.Binding("stroke", "color"))
                                );
                            generateGraph()
                        }

                        function generateGraph() {
                            radialDiagram.model = new go.GraphLinksModel(nodes, links);
                            var root = radialDiagram.findNodeForKey("<?php echo $customer_name; ?>");
                            nodeClicked(null, root);
                            radialDiagram.layout.layerThickness = 200;
                        }

                        function nodeClicked(e, root) {
                            var diagram = root.diagram;
                            if (diagram === null) return;
                            // all other nodes should be visible and use the default category
                            diagram.nodes.each(function(n) {
                                n.visible = true;
                                if (n !== root) n.category = "";
                            })
                            // make this Node the root
                            root.category = "Root";
                            // tell the RadialLayout what the root node should be
                            diagram.layout.root = root;
                            diagram.layoutDiagram(true);
                        }
                        </script>
                    </body>
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