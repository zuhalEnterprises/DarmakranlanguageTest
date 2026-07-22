      const G_borderColor='#3388ff';
      const G_fillColor='#3388ff';
      const G_circleOpacity=0.3;
      const G_circleRadius=0.00300;
      const G_minZoom=10;
      const G_maxZoom=16;
      var G_SelectedCountryLayer=null;
      var map = null;
      var G_marker;
      var G_circle;
      
      function Map_Show(lat,lng,zoon)
      {
           map = L.map("map", { G_minZoom: 10,G_maxZoom: 16 }).setView([lat,lng], zoon);
           L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',}).addTo(map);
       
      }
       function Map_ShowCircle(lat,lng,zoon,delay)
       {
          Map_Show(lat,lng,zoon);
         
         
          setTimeout(() => {
            L.circle([lat,lng], {
              color: G_borderColor,
              fillColor: G_fillColor,
              fillOpacity: G_circleOpacity,
              radius: G_circleRadius*100000
          }).addTo(map);
          }, delay);
         
       }

      function Map_Init()
      {
         Map_Show(35.67849408943879,51.39129638671876,10);
         MapClick();
      }
          
    $(function(){
        $('#js_country').change(function()
        {
            if (G_SelectedCountryLayer != undefined) 
            {
                map.removeLayer(G_SelectedCountryLayer);
            };

            var SelectedPolygon=$(this).val();
            var data={};
            data.type='Feature';
            data.id='IRL';
            data.properties={};
            data.properties.name='Ireland';
            data.geometry={};
            data.geometry.type='Polygon';
            data.geometry.coordinates=JSON.parse("[" + SelectedPolygon + "]");;
            G_SelectedCountryLayer = L.geoJSON(data).addTo(map);
            map.fitBounds(G_SelectedCountryLayer.getBounds());
        });

    });
    function Map_DrawCircle()
        {
          if (G_circle != undefined) {
            map.removeLayer(G_circle);
            };

          var lat=G_marker.getLatLng().lat;
          var lng=G_marker.getLatLng().lng;
          
          var pt_angle = Math.random() * 2 * Math.PI;
          var pt_radius_sq = Math.random() * (G_circleRadius*0.95) * (G_circleRadius*0.95);
          var pt_x = Math.sqrt(pt_radius_sq) * Math.cos(pt_angle);
          var pt_y = Math.sqrt(pt_radius_sq) * Math.sin(pt_angle);
          //console.log(pt_x,pt_y)
           
          var RandomLat=getRandomArbitrary(lat-(pt_x),lat+(pt_x));
          var RandomLng=getRandomArbitrary(lng-(pt_y),lng+(pt_y));
          G_circle = L.circle([RandomLat,RandomLng], {
              color: G_borderColor,
              fillColor: G_fillColor,
              fillOpacity: G_circleOpacity,
              radius: G_circleRadius*100000
          }).addTo(map);
          //console.log(lat,lng);
          //console.log(RandomLat,RandomLng);
          return JSON.stringify({ Lat: RandomLat, Lng: RandomLng });
        }
        
        function getRandomArbitrary(min, max) {
            return Math.random() * (max - min) + min;
        }
        

       function MapClick()
       {
            map.on('click', function(e) {
                console.log(e.latlng.lat,e.latlng.lng)
            if (G_marker != undefined) 
            {
              map.removeLayer(G_marker);
            };
            map.flyTo([e.latlng.lat,e.latlng.lng], 13, 
            {
                animate: true,
                duration: 1.5
            });

            G_marker = L.marker([e.latlng.lat,e.latlng.lng]).addTo(map);
            $('#js_drawCircle').removeAttr('disabled');
        });
      }