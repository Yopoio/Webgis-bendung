<style type="text/css">
/* Main marketing message and sign up button */

#judul {
	font-size: 20px;
	font-weight: bold;
}

#teks {
	font-size: 17px;
}

#dari {
	padding-bottom: 5px;
}

#ke {
	padding-bottom: 5px;
}

circle { 
  fill: rgb(202, 24, 18);
  stroke: #141C25;
  stroke-width: 1;
  cursor: pointer;
}

.label 
{ 
  font-family: arial;
  stroke: #ffffff;
  cursor: pointer;
}

line { 
  stroke: #1E1E1E;
  stroke-dasharray: 5,5;
  stroke-width: 2;
}

line.shortest { 
  stroke: rgb(155, 0, 245);
  stroke-dasharray: 5,0;
  stroke-width: 11;
  -webkit-box-shadow: 4px 5px 5px -1px rgba(0,0,0,0.75);
  -moz-box-shadow: 4px 5px 5px -1px rgba(0,0,0,0.75);
  box-shadow: 4px 5px 5px -1px rgba(0,0,0,0.75);
}

.line-label { 
  font-family: arial;
  font-size: 26px;
  stroke: #000000;
}
	</style>
<!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://cdn.jsdelivr.net/npm/d3@3.3.0/d3.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/leaflet@0.7.7/dist/leaflet.js"></script>
	<script src="<?=base_url('assets/js/leaflet-routing-machine/dist/leaflet-routing-machine.js')?>"></script>
    <script src="<?=base_url('assets/js/leaflet-routing-machine/examples/Control.Geocoder.js')?>"></script>
	<script src="<?=base_url('assets/js/leaflet-search/dist/leaflet-search.src.js')?>"></script>
	<script src="<?=site_url('admin/api/data/hotspot/varpoint')?>"></script>

   <script type="text/javascript">
   	var graphmap, svg, maps, g;

var mapdata = {
	allnodes: [],
	paths: [],
	distances: [],
	getui: {
		htmlSelectStartingNode: "#from-starting",
		htmlSelectEndNode: "#to-end",
	},
	getstate: {
		selectedNode: null,
		fromNode: null,
		toNode: null,
	},
};

let latLng=[-6.3664496, 107.1717351];
   	var maps = L.map('map').setView(latLng, 15);
   	var Layer=L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
	});
	
	maps.addLayer(Layer);

	// ambil titik
	getLocation();
	function getLocation() {
	  if (navigator.geolocation) {
	    navigator.geolocation.getCurrentPosition(showPosition);
	  } else {
	    x.innerHTML = "Geolocation is not supported by this browser.";
	  }
	}

	function showPosition(position) {
	  $("[name=latNow]").val(position.coords.latitude);
	  $("[name=lngNow]").val(position.coords.longitude);
	}
	// hostpot
	var layersHotspotPoint=L.geoJson(hotspotPoint, {
	    pointToLayer: function (feature, latlng) {
	    	// console.log(feature)
	        return L.marker(latlng, {
	        	icon : new L.icon({
	        			iconUrl: feature.properties.icon,
				    	iconSize: [38, 45]
        				})
	        });
	    },
    	onEachFeature: function(feature,layer){
    		let coord=feature.geometry.coordinates;
    		 if (feature.properties && feature.properties.name) {
		        layer.bindPopup(feature.properties.popUp+
		        	"<br><button class='btn btn-info keSini' data-lat='"+coord[1]+"' data-lng='"+coord[0]+"'>Ke Sini</button>"
		        	);
		    }
    	}
	}).addTo(maps);
	var poiLayers = L.layerGroup([
		layersHotspotPoint
	]);
	L.control.search({
		layer: poiLayers,
		initial: false,
		propertyName: 'name',
		buildTip: function(text, val) {
			// var jenis = val.layer.feature.properties.jenis;
			// return '<a href="#" class="'+jenis+'">'+text+'<b>'+jenis+'</b></a>';
			return '<a href="#" >'+text+'</a>';
		},
		marker: {
			icon: "",
			circle: {
				radius: 20,
				color: '#f32',
				opacity: 1,
				weight:5
			}
		}
	}).addTo(maps);
	// end pencarian
	// rute 

	var control = L.Routing.control({
	    waypoints: [
	        latLng
	    ],
		routeWhileDragging: true,
		reverseWaypoints: true,
		showAlternatives: true,
		altLineOptions: {
			styles: [
				{color: 'black', opacity: 0.15, weight: 9},
				{color: 'white', opacity: 0.8, weight: 6},
				{color: 'blue', opacity: 0.5, weight: 2}
			]
		},
		createMarker: function (i, waypoint, n) {
			let urlIcon;
			console.log(i+", "+n);
			var pos=i+1;
			if(pos==1){
				urlIcon='<?=assets('icons/icon-user.png')?>';
			}
			else if(pos==n){
				urlIcon='<?=assets('icons/icon-dest.png')?>';
			}
			else{
				urlIcon='<?=assets('icons/icon-step.png')?>';
			}

            const marker = L.marker(waypoint.latLng, {
              draggable: true,
              bounceOnAdd: false,
              bounceOnAddOptions: {
                duration: 1000,
                height: 800,
                function() {
                  (bindPopup(myPopup).openOn(maps))
                }
              },
              icon: L.icon({
    			iconUrl: urlIcon,
		    	iconSize: [38, 45]
              })
            });
            return marker;
          }
	})
	control.addTo(maps);

	$(document).on("click", ".dariSini", function() {
    let lat = $("[name=latNow]").val();
    let lng = $("[name=lngNow]").val();
    console.log("Latitude:", lat);
    console.log("Longitude:", lng);
    let latLng = [lat, lng];
    control.spliceWaypoints(0, 1, latLng);
    maps.panTo(latLng);
});
	maps._initPathRoot();
svg = d3
	.select("#map")
	.select("svg")
	.attr("class", "svgmap")
	.on("contextmenu", function () {
		d3.event.preventDefault();
	});

maps.on("viewreset", redrawmapwhenviewchanges);

function redrawmapwhenviewchanges() {
	redrawNodes();
	redrawLines();
}

maps.on("click", function (e) {
	var nodeName = mapdata.allnodes.length;
	console.log(e.latlng.lat + ", " + e.latlng.lng);

	mapdata.allnodes.push({
		name: nodeName,
		x: e.latlng.lat,
		y: e.latlng.lng,
	});
	redrawNodes();
	addNodeToSelect(nodeName);
});

function dragNode() {
	return function (d, i) {
		var d = d;

		var golf = true;
		maps.on("mousemove", function (e) {
			if (golf == true) {
				var nodeDatum = {
					name: d.name,
					x: e.latlng.lat,
					y: e.latlng.lng,
				};

				mapdata.allnodes[i] = nodeDatum;
				calculateDistancesbetweennodes();
				redrawLines();
				redrawNodes();
			} else {
				return;
			}
		});
		maps.on("mouseup", function (e) {
			golf = false;
			return;
		});
	};
}

function redrawNodes() {
	svg.selectAll("g.nodes").data([]).exit().remove();

	var elements = svg
		.selectAll("g.nodes")
		.data(mapdata.allnodes, function (d, i) {
			return d.name;
		});

	var nodesEnter = elements.enter().append("g").attr("class", "nodes");

	elements.attr("transform", function (d, i) {
		return (
			"translate(" +
			maps.latLngToLayerPoint(new L.LatLng(d.x, d.y)).x +
			"," +
			maps.latLngToLayerPoint(new L.LatLng(d.x, d.y)).y +
			")"
		);
	});

	nodesEnter
		.append("circle")
		.attr("nodeId", function (d, i) {
			return i;
		})
		.attr("r", "24")
		.attr("class", "node")
		.style("cursor", "pointer")
		.on("click", nodeClick)
		.on("mouseenter", function () {
			maps.dragging.disable();
		})
		.on("mouseout", function () {
			maps.dragging.enable();
		})
		.on("contextmenu", function (d, i) {
			startEndPath(i);
		})
		.call(dragManager);

	nodesEnter
		.append("text")
		.attr("nodeLabelId", function (d, i) {
			return i;
		})
		.attr("dx", "-5")
		.attr("dy", "5")
		.attr("class", "label")
		.on("contextmenu", function (d, i) {
			startEndPath(i);
		})
		.call(dragManager)
		.text(function (d, i) {
			return d.name;
		});

	elements.exit().remove();
}

function redrawLines() {
	svg.selectAll("g.line").data([]).exit().remove();

	var elements = svg.selectAll("g.line").data(mapdata.paths, function (d) {
		return d.id;
	});

	var newElements = elements.enter();

	var group = newElements.append("g").attr("class", "line");

	var line = group
		.append("line")
		.attr("class", function (d) {
			return (
				"from" +
				mapdata.allnodes[d.from].name +
				"to" +
				mapdata.allnodes[d.to].name
			);
		})
		.attr("x1", function (d) {
			return maps.latLngToLayerPoint(
				new L.LatLng(mapdata.allnodes[d.from].x, mapdata.allnodes[d.from].y)
			).x;
		})
		.attr("y1", function (d) {
			return maps.latLngToLayerPoint(
				new L.LatLng(mapdata.allnodes[d.from].x, mapdata.allnodes[d.from].y)
			).y;
		})
		.attr("x2", function (d) {
			return maps.latLngToLayerPoint(
				new L.LatLng(mapdata.allnodes[d.to].x, mapdata.allnodes[d.to].y)
			).x;
		})
		.attr("y2", function (d) {
			return maps.latLngToLayerPoint(
				new L.LatLng(mapdata.allnodes[d.to].x, mapdata.allnodes[d.to].y)
			).y;
		});

	var text = group
		.append("text")
		.attr("x", function (d) {
			return (
				parseInt(
					(maps.latLngToLayerPoint(
						new L.LatLng(mapdata.allnodes[d.from].x, mapdata.allnodes[d.from].y)
					).x +
						maps.latLngToLayerPoint(
							new L.LatLng(mapdata.allnodes[d.to].x, mapdata.allnodes[d.to].y)
						).x) /
						2
				) + 5
			);
		})
		.attr("y", function (d) {
			return (
				parseInt(
					(maps.latLngToLayerPoint(
						new L.LatLng(mapdata.allnodes[d.from].x, mapdata.allnodes[d.from].y)
					).y +
						maps.latLngToLayerPoint(
							new L.LatLng(mapdata.allnodes[d.to].x, mapdata.allnodes[d.to].y)
						).y) /
						2
				) - 5
			);
		})
		.attr("class", "line-label");

	elements.selectAll("text").text(function (d) {
		return Math.round(mapdata.distances[d.from][d.to]) + " Meters";
	});

	elements.exit().remove();
}

function LatLon(lat, lon) {
	this.lat = Number(lat);
	this.lon = Number(lon);
}

// Haversine distance formula, see http://en.wikipedia.org/wiki/Haversine_formula

LatLon.prototype.distanceTo = function (point, radius) {
	if (!(point instanceof LatLon))
		throw new TypeError("point is not LatLon object");
	radius = radius === undefined ? 6378137 : Number(radius);
	if (Number.prototype.toRadians === undefined) {
		Number.prototype.toRadians = function () {
			return (this * Math.PI) / 180;
		};
	}
	if (Number.prototype.toDegrees === undefined) {
		Number.prototype.toDegrees = function () {
			return (this * 180) / Math.PI;
		};
	}
	var R = radius;
	var φ1 = this.lat.toRadians(),
		λ1 = this.lon.toRadians();
	var φ2 = point.lat.toRadians(),
		λ2 = point.lon.toRadians();
	var Δφ = φ2 - φ1;
	var Δλ = λ2 - λ1;
	var a =
		Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
		Math.cos(φ1) * Math.cos(φ2) * Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
	var d = R * c;
	return d;
};

var dragManager = d3.behavior
	.drag()
	.on("dragstart", dragNodeStart())
	.on("drag", dragNode())
	.on("dragend", dragNodeEnd());

$("#getmethere").on("click", function () {
	var valuelat = $("#latitude").val();
	var valuelong = $("#longitude").val();
	clearGraph();

	if (valuelat == "" || valuelong == "") {
		alert("Please Enter Lat. and Long.");
	} else {
		maps.setView(new L.LatLng(valuelat, valuelong), 10);
	}
});

$("#getshortestroute").on("click", function () {
	d3.selectAll("line").classed({ shortest: false });
	calculateDistancesbetweennodes();
	if (
		!$(mapdata.getui.htmlSelectStartingNode).val() ||
		!$(mapdata.getui.htmlSelectEndNode).val()
	)
		return;
	var sourceNode = $(mapdata.getui.htmlSelectStartingNode).val();
	var targetNode = $(mapdata.getui.htmlSelectEndNode).val();
	var results = dijkstra(sourceNode, targetNode);
	if (results.path) {
		results.path.forEach(function (step) {
			var dist = mapdata.distances[step.source][step.target];
			stepLine = d3.select(
				"line.from" +
					step.source +
					"to" +
					step.target +
					"," +
					"line.from" +
					step.target +
					"to" +
					step.source
			);
			stepLine.classed({ shortest: true });
		});
	}
});
$("#clearmap").on("click", function () {
	clearGraph();
});

function addNodeToSelect(nodeName) {
	$(mapdata.getui.htmlSelectStartingNode).append(
		$("<option></option>").attr("value", nodeName).text(nodeName)
	);
	$(mapdata.getui.htmlSelectEndNode).append(
		$("<option></option>").attr("value", nodeName).text(nodeName)
	);
}

function clearGraph() {
	mapdata.allnodes = [];
	mapdata.paths = [];
	$(mapdata.getui.htmlSelectStartingNode).empty();
	$(mapdata.getui.htmlSelectEndNode).empty();
	$("#results").empty();
	$("#map").css({
		"background-image": "url(" + null + ")",
	});
	redrawNodes();
	redrawLines();
}

function nodeClick(d, i) {
	console.log("node:click %s", i);
	console.log(d);

	d3.event.preventDefault();
	d3.event.stopPropagation();
}

function dragNodeStart() {
	return function (d, i) {
		console.log("dragging node " + i);
	};
}

function dragNodeEnd() {
	return function (d, i) {
		console.log("node " + i + " repositioned");
	};
}

function killEvent() {
	if (d3.event.preventDefault) {
		d3.event.preventDefault();
		d3.event.stopPropagation();
	}
}

function startEndPath(index) {
	d3.event.stopPropagation();
	d3.event.preventDefault();
	if (mapdata.getstate.fromNode === null) {
		mapdata.getstate.fromNode = index;
	} else {
		if (mapdata.getstate.fromNode === index) {
			return;
		}

		mapdata.getstate.toNode = index;
		console.log(index + " Node lar");
		var pathDatum = {
			id: mapdata.paths.length,
			from: mapdata.getstate.fromNode,
			to: index,
		};
		mapdata.paths.push(pathDatum);
		calculateDistancesbetweennodes();
		redrawLines();
		redrawNodes();
		mapdata.getstate.fromNode = null;
		mapdata.getstate.toNode = null;
	}
}

function calculateDistancesbetweennodes() {
	mapdata.distances = [];
	for (var i = 0; i < mapdata.allnodes.length; i++) {
		mapdata.distances[i] = [];
		for (var j = 0; j < mapdata.allnodes.length; j++)
			mapdata.distances[i][j] = "x";
	}
	for (var i = 0; i < mapdata.paths.length; i++) {
		var sourceNodeId = parseInt(mapdata.paths[i].from);
		var targetNodeId = parseInt(mapdata.paths[i].to);
		var sourceNode = mapdata.allnodes[sourceNodeId];
		var targetNode = mapdata.allnodes[targetNodeId];
		var p1 = new LatLon(sourceNode.x, sourceNode.y);
		var p2 = new LatLon(targetNode.x, targetNode.y);
		var d = p1.distanceTo(p2);
		mapdata.distances[sourceNodeId][targetNodeId] = d;
		mapdata.distances[targetNodeId][sourceNodeId] = d;
	}
}

function dijkstra(start, end) {
	var nodeCount = mapdata.distances.length,
		infinity = 99999, // infinity
		shortestPath = new Array(nodeCount),
		nodeChecked = new Array(nodeCount),
		pred = new Array(nodeCount);

	for (var i = 0; i < nodeCount; i++) {
		shortestPath[i] = infinity;
		pred[i] = null;
		nodeChecked[i] = false;
	}

	shortestPath[start] = 0;

	for (var i = 0; i < nodeCount; i++) {
		var minDist = infinity;
		var closestNode = null;

		for (var j = 0; j < nodeCount; j++) {
			if (!nodeChecked[j]) {
				if (shortestPath[j] <= minDist) {
					minDist = shortestPath[j];
					closestNode = j;
				}
			}
		}

		nodeChecked[closestNode] = true;

		for (var k = 0; k < nodeCount; k++) {
			if (!nodeChecked[k]) {
				var nextDistance = distanceBetween(closestNode, k, mapdata.distances);
				if (
					parseInt(shortestPath[closestNode]) + parseInt(nextDistance) <
					parseInt(shortestPath[k])
				) {
					soFar = parseInt(shortestPath[closestNode]);
					extra = parseInt(nextDistance);
					shortestPath[k] = soFar + extra;
					pred[k] = closestNode;
				}
			}
		}
	}

	if (shortestPath[end] < infinity) {
		var newPath = [];
		var step = {
			target: parseInt(end),
		};

		var v = parseInt(end);

		while (v >= 0) {
			v = pred[v];
			if (v !== null && v >= 0) {
				step.source = v;
				newPath.unshift(step);
				step = {
					target: v,
				};
			}
		}

		totalDistance = shortestPath[end];

		return {
			mesg: "Status: OK",
			path: newPath,
			source: start,
			target: end,
			distance: totalDistance,
		};
	} else {
		return {
			mesg: "Sorry No path found",
			path: null,
			source: start,
			target: end,
			distance: 0,
		};
	}

	function distanceBetween(fromNode, toNode, distances) {
		dist = distances[fromNode][toNode];
		if (dist === "x") dist = infinity;
		return dist;
	}
}

   </script>