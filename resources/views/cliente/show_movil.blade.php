<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VSRAD') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/js/go-debug.js"></script>

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/movil') }}">
                    {{ config('app.name', 'VSRAD') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (Auth::guest())
                        <li>  </li>
                    @elseif (Auth::user()->hasRol("cliente"))
                        <li><a href="{{ route('movil') }}">Mis proyectos</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        {{--<li><a href="{{ route('register') }}">Registrar</a></li>--}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->getCompleteName() }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Salir
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container container-page">
        <div class="row">
            <div class="col-lg-12">
                <h2>{{$proyecto->nombre}}</h2>
                <hr>
                @if(count($errors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div hidden>
                    <textarea id="configuracion" name="configuracion" class="form-control" required>{{ $proyecto->configuracion  }}</textarea>
                </div>
                <div class="row">
                    <div class="col-lg-10">
                        <div hidden>
                        <div id="myDiagramDiv" class="canvas-plano canvas-casa-{{$proyecto->id_plano}}" style="background-color: #f0f9f6; border:  solid  1px #d3e0e9;"></div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Coste total de los productos</h3>
                            </div>
                            <div class="panel-body">
                                <div class="input-group-addon col-xs-2">€</div>
                                    <input id="coste" type="text" name="coste" size="6" value="{{$proyecto->coste}}" readonly>
                                <footer><h6>Precio sin IVA</h6></footer>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div id="detalles" hidden>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Detalles del producto</h3>
                            </div>
                            <div id="det-text" class="panel-body">
                                <div class="col-lg-4">
                                    <img id="imagen_producto" src="" alt="Imagen del producto" class="img-thumbnail">
                                </div>
                                <div class="col-lg-8">
                                    <ul>
                                        <li id="nombre_p"></li>
                                        <li id="descripcion_p"></li>
                                        <li id="restricciones_p"></li>
                                        <li id="coste_p"></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div>

            </div>
            </div>
        </div>
    </div>

    <script>


        var AllowTopLevel = false;
        var CellSize = new go.Size(30, 30);

        var $$ = go.GraphObject.make;
        var myDiagram =
            $$(go.Diagram, "myDiagramDiv",
                {
                    /*fixedBounds: Rect(0,0,669,460),*/
                    /*initialContentAlignment: go.Spot.Center,  // center the content*/
                    grid: $$(go.Panel, "Grid",
                        {gridCellSize: CellSize},
                        $$(go.Shape, "LineH", {stroke: "lightgray"}),
                        $$(go.Shape, "LineV", {stroke: "lightgray"})
                    ),
                    // support grid snapping when dragging and when resizing
                    "draggingTool.isGridSnapEnabled": false,
                    "draggingTool.gridSnapCellSpot": go.Spot.Center,
                    "resizingTool.isGridSnapEnabled": false,
                    allowDrop: false,  // handle drag-and-drop from the Palette
                    // For this sample, automatically show the state of the diagram's model on the page
                    "ModelChanged": function (e) {
                        if (e.isTransactionFinished) {}
                    },
                    "animationManager.isEnabled": true,
                    "undoManager.isEnabled": false // enable Ctrl-Z to undo and Ctrl-Y to redo
                });

        function onSelectionChanged(node) {
            //var elem = node.diagram.selection.first(); //NO FUNCIONA ESTO
            var icon = node.findObject("SHAPE");

            //console.log(elem.data);

            if (icon !== null) {
                if (node.isSelected) {
                    icon.fill = "#B2FF59";
                    document.getElementById('detalles').hidden=false;

                    console.log("Nombre: " + node.data.nombre + " Imagen: " + node.data.imagen);

                    var path = "/img/" + node.data.imagen;

                    jQuery('#imagen_producto').attr("src", path);

                    document.getElementById('nombre_p').textContent = "Nombre: " + node.data.nombre;
                    document.getElementById('descripcion_p').textContent = "Descripción: " + node.data.descripcion;
                    document.getElementById('restricciones_p').textContent = "Restricciones: " + node.data.restricciones;
                    document.getElementById('coste_p').textContent = "Coste: " + node.data.coste + " € (sin IVA)";
                }
                else{
                    icon.fill = "lightgray";
                    document.getElementById('detalles').hidden=true;
                }
            }
        }

        // Regular Nodes represent items to be put onto racks.
        // Nodes are currently resizable, but if that is not desired, just set resizable to false.
        myDiagram.nodeTemplate =
            $$(go.Node, "Auto",
                {
                    selectionChanged: onSelectionChanged,
                    resizable: false, resizeObjectName: "SHAPE",
                    locationObjectName: "TB",
                    // because the gridSnapCellSpot is Center, offset the Node's location
                    locationSpot: go.Spot.Center ,
                    // provide a visual warning about dropping anything onto an "item"
                    mouseDragEnter: function (e, node) {
                        e.handled = true;
                        node.findObject("SHAPE").fill = "red";
                    },
                    mouseDragLeave: function (e, node) {
                        node.updateTargetBindings();
                    },
                    mouseDrop: function (e, node) {  // disallow dropping anything onto an "item"
                        node.diagram.currentTool.doCancel();
                    }
                },
                // always save/load the point that is the top-left corner of the node, not the location
                new go.Binding("position", "pos", go.Point.parse).makeTwoWay(go.Point.stringify),
                // this is the primary thing people see
                $$(go.Shape,
                    {
                        figure: "RoundedRectangle",
                        name: "SHAPE",
                        fill: "white",
                    },
                    new go.Binding("fill", "color"),
                    new go.Binding("desiredSize", "size", go.Size.parse).makeTwoWay(go.Size.stringify)),
                // with the textual key in the middle
                $$(go.TextBlock,
                    {alignment: go.Spot.Center, font: 'bold 12px sans-serif', margin: 3},
                    new go.Binding("text", "nombre"))
            );  // end Node

        function highlightGroup(grp, show) {
            if (!grp) return;
            if (show) {  // check that the drop may really happen into the Group
                var tool = grp.diagram.toolManager.draggingTool;
                var map = tool.draggedParts || tool.copiedParts;  // this is a Map
                if (grp.canAddMembers(map.toKeySet())) {
                    grp.isHighlighted = true;
                    return;
                }
            }
            grp.isHighlighted = false;
        }

        var groupFill = "rgba(128,128,128,0)";
        var groupStroke = "white";
        var dropFill = "rgba(128,255,255,0.2)";
        var dropStroke = "red";

        myDiagram.groupTemplate =
            $$(go.Group,
                {
                    layerName: "Background",
                    resizable: false, resizeObjectName: "SHAPE",
                    // because the gridSnapCellSpot is Center, offset the Group's location
                    locationSpot: new go.Spot(0, 0, CellSize.width/2, CellSize.height/2)
                },
                // always save/load the point that is the top-left corner of the node, not the location
                new go.Binding("position", "pos", go.Point.parse).makeTwoWay(go.Point.stringify),
                { // what to do when a drag-over or a drag-drop occurs on a Group
                    mouseDragEnter: function(e, grp, prev) { highlightGroup(grp, true); },
                    mouseDragLeave: function(e, grp, next) { highlightGroup(grp, false); },
                    mouseDrop: function(e, grp) {
                        var ok = grp.addMembers(grp.diagram.selection, true);
                        if (!ok) grp.diagram.currentTool.doCancel();
                    }
                },
                $$(go.Shape, "Rectangle",  // the rectangular shape around the members
                    { name: "SHAPE",
                        fill: groupFill,
                        stroke: groupStroke,
                        minSize: new go.Size(CellSize.width*2, CellSize.height*2)
                    },
                    new go.Binding("desiredSize", "size", go.Size.parse).makeTwoWay(go.Size.stringify),
                    new go.Binding("fill", "isHighlighted", function(h) { return h ? dropFill : groupFill; }).ofObject(),
                    new go.Binding("stroke", "isHighlighted", function(h) { return h ? dropStroke: groupStroke; }).ofObject())
            );

        // decide what kinds of Parts can be added to a Group
        myDiagram.commandHandler.memberValidation = function(grp, node) {
            if (grp instanceof go.Group && node instanceof go.Group) return false;  // cannot add Groups to Groups
            // but dropping a Group onto the background is always OK
            return true;
        };

        // what to do when a drag-drop occurs in the Diagram's background
        myDiagram.mouseDragOver = function(e) {
            if (!AllowTopLevel) {
                // but OK to drop a group anywhere
                if (!e.diagram.selection.all(function(p) { return p instanceof go.Group; })) {
                    e.diagram.currentCursor = "not-allowed";
                }
            }
        };

        myDiagram.mouseDrop = function(e) {
            if (AllowTopLevel) {
                // when the selection is dropped in the diagram's background,
                // make sure the selected Parts no longer belong to any Group
                if (!e.diagram.commandHandler.addTopLevelParts(e.diagram.selection, true)) {
                    e.diagram.currentTool.doCancel();
                }
            } else {
                // disallow dropping any regular nodes onto the background, but allow dropping "racks"
                if (!e.diagram.selection.all(function(p) { return p instanceof go.Group; })) {
                    e.diagram.currentTool.doCancel();
                }
            }
        };


        // start off with four "racks" that are positioned next to each other
        var configuracion = JSON.parse(document.getElementById("configuracion").textContent);

        console.log("tipo: "+ typeof(configuracion));
        console.log("contenido: "+ configuracion);

        myDiagram.model = go.Model.fromJson(configuracion);

        myDiagram.isReadOnly = true;



    </script>

</div>

</body>

</html>