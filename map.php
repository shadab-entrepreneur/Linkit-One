<?php
        function getParameter($par, $default = null)
		{
            if (isset($_POST[$par]) && strlen($_POST[$par])) return $_POST[$par];
            if (isset($_GET[$par]) && strlen($_GET[$par])) return $_GET[$par];
            else return $default;
        }
?>

<!DOCTYPE html>
<html>    
	<head>
    	<script language="JavaScript" type="text/javascript" src="jquery-2.1.4.min.js"></script>     
		<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDvq-I0pKous0qH6jiNviSpKcZIFyaQ150"></script>
		<script type="text/javascript">
    	var map;
			var poly;
			var file_name = <?php echo "\"".getParameter("file")."\"" ?>;//get tile name
      var lastLat=0;
			var lastLon=0;
			var polyOptions= //polyline properties
			{
				strokeColor: '0#000000',
				strokeOpacity: 1.0,
				strokeWeight: 3
			};
			var mapProp = //map properties
			{
				zoom:15,
				mapTypeId:google.maps.MapTypeId.ROADMAP
			};
	            
            
			function initialize()
			{
				map=new google.maps.Map(document.getElementById("map"),mapProp);
				poly=new google.maps.Polyline(polyOptions);
				poly.setMap(map);
				$.get(file_name, function(txt) 
				{
                	console.log("file")
                	var lines = txt.split("\n");
                	for (var i=0;i<(lines.length-1);i++)
	                {
            			var coords=lines[i].split(",");
                        if(lastLat!=coords[2]||lastLon!=coords[3])
                        {
                        	var pos = new google.maps.LatLng(coords[2],coords[3]);
							poly.getPath().push(pos);
                            map.setCenter(pos);
                            lastLat = coords[2];
                            lastLon = coords[3];
                        }
                    }
              	});  
			}
            google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	</head>
	<body >
		<div>
            <center>
               <div id="map" style="width: 100vw;height:100vh;"></div>
            </center>
        </div>
	</body>
</html>
