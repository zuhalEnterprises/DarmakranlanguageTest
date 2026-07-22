//https://jsfiddle.net/oryza_anggara/2gze75L6/
function isNullOrEmpty(ob)
{
    return ob == null || ob == '' || ob == undefined;
}
function isNullOrEmptyAlter(ob,alter)
{
    return isNullOrEmpty(ob) ? alter : ob;
}
function getRandomArbitrary(min, max) {
    return Math.random() * (max - min) + min;
}

(function ( $ ) {

  $.fn.kamaMap = function( options,callback ) {
      var map;
      var G_marker;
      var G_circle;
      var G_Polygon;
      var G_L;
      var G_Filters={
        deal_type: 0,
        deal_type_mobile: 0,
        has_tour: 2,
        estate_type: 2,
        estate_document: 2,
        price_analyse: 0,

        center: null,
        zoom: null,

        polygon: null,
        easyFilters: null
    };
      // This is the easiest way to have default options.
      var settings = $.extend({
          // These are the defaults.
          zoomControl:true,
          scrollWheelZoom:true,
          drawControl:false,
          borderColor: "#3388ff",
          fillColor: "#3388ff",
          shapeOpacity:0.3,
          circleRadius:0.00300,
          minZoom:1,
          maxZoom:30,
          lat:35.67849408943879,
          lng:51.39129638671876,
          zoom:10,
          click_duration:0.5,
          click_zoom:13,
          click_animation:true,
          attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">ekama.ir</a>',

      }, options );
      this.G_L=L;

      this.map = L.map(this.attr('id'), {zoomControl:settings.zoomControl,
        scrollWheelZoom:settings.scrollWheelZoom,
         minZoom: settings.minZoom,
         maxZoom: settings.maxZoom,
        // drawControl: settings.drawControl
        }).setView([settings.lat,settings.lng], settings.zoom);

      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
       {attribution:settings.attribution,}).addTo(this.map);
        if(settings.drawControl)
        {
            this.setPen();
        }

      $.fn.showCircle = function(lat,lng,delay) {
        var _this=this;
        setTimeout(() => {
                  _this.G_L.circle([lat,lng], {
                    color: settings.borderColor,
                    fillColor: settings.fillColor,
                    fillOpacity: settings.shapeOpacity,
                    radius: settings.circleRadius*100000
                }).addTo(_this.map);
                }, delay);
                return _this;
      };

      $.fn.clickMap = function(showCircle,callback) {
        var _this=this;

        _this.map.on('click', function(e) {

            if (!isNullOrEmpty(_this.G_marker))
            {
              _this.map.removeLayer(_this.G_marker);
            };
            _this.map.flyTo([e.latlng.lat,e.latlng.lng], settings.click_zoom,
            {
                animate: settings.click_animation,
                duration: settings.click_duration,

            });

            _this.G_marker = _this.G_L.marker([e.latlng.lat,e.latlng.lng]).addTo(_this.map);

            _this.data('markerPoint',[e.latlng.lat,e.latlng.lng]);
          if(showCircle)
          {
           // _this.map.on('zoomend', function () {
                _this.drawCircle();
           // });
          }

          if (typeof callback == 'function') { // make sure the callback is a function

            let data={};
            data.markerPoint=_this.data('markerPoint');
            data.circlePoint=_this.data('circlePoint');
            callback.call(this,data); // brings the scope to the callback
        }

      });
      return  _this;
    };

      $.fn.showMarkerByClick = function(showCircle) {
        var _this=this;
        _this.map.on('click', function(e) {

            if (!isNullOrEmpty(_this.G_marker))
            {
              _this.map.removeLayer(_this.G_marker);
            };
            _this.map.flyTo([e.latlng.lat,e.latlng.lng], settings.click_zoom,
            {
                animate: settings.click_animation,
                duration: settings.click_duration,

            });

            _this.G_marker = _this.G_L.marker([e.latlng.lat,e.latlng.lng]).addTo(_this.map);
            _this.attr('markerPoint',[e.latlng.lat,e.latlng.lng]);
          if(showCircle)
          {
            _this.map.on('zoomend', function () {
                _this.drawCircle();
            });
          }

      });
      return  _this;
    };

    $.fn.showMarkerAndCircleByClick = function() {
        var _this=this;
       return _this.showMarkerByClick(true);
    };

    $.fn.drawCircle = function()
    {
        var _this=this;
        if (!isNullOrEmpty(_this.G_circle)) {
            _this.map.removeLayer(_this.G_circle);
        };

        let lat=_this.G_marker.getLatLng().lat;
        let lng=_this.G_marker.getLatLng().lng;
        let pt_angle = Math.random() * 2 * Math.PI;
        let pt_radius_sq = Math.random() * (settings.circleRadius*0.95) * (settings.circleRadius*0.95);
        let pt_x = Math.sqrt(pt_radius_sq) * Math.cos(pt_angle);
        let pt_y = Math.sqrt(pt_radius_sq) * Math.sin(pt_angle);
        //console.log(pt_x,pt_y)

        let RandomLat=getRandomArbitrary(lat-(pt_x),lat+(pt_x));
        let RandomLng=getRandomArbitrary(lng-(pt_y),lng+(pt_y));

        _this.data('circlePoint',[RandomLat,RandomLng]);
        _this.G_circle = _this.G_L.circle([RandomLat,RandomLng], {
            color: settings.borderColor,
            fillColor: settings.fillColor,
            fillOpacity: settings.shapeOpacity,
            radius: settings.circleRadius*100000
        }).addTo(_this.map);
        //console.log(lat,lng);
        //console.log(RandomLat,RandomLng);
       // return  JSON.stringify({ Lat: RandomLat, Lng: RandomLng });

        return _this;
     }

     $.fn.drawBoundary = function(pointArray,fillColor,fillOpacity,borderColor,borderWith,borderOpacity)
    {
        var _this=this;
        if (!isNullOrEmpty(_this.G_Polygon)) {
            _this.map.removeLayer(_this.G_Polygon);
        };

        let data={};
        data.type='Feature';
        data.id='IRL';
        data.properties={};
        data.properties.name='state';
        data.geometry={};
        data.geometry.type='Polygon';
        data.geometry.coordinates=JSON.parse("[" + pointArray + "]");
        _this.G_Polygon = _this.G_L.geoJSON(data).addTo(_this.map);
        _this.G_Polygon.setStyle(
          {
            fillColor: isNullOrEmptyAlter(fillColor,'#f00'),
            weight:isNullOrEmptyAlter(borderWith,1) ,
            opacity: isNullOrEmptyAlter(borderOpacity,1),
            color: isNullOrEmptyAlter(borderColor,'#0f0'),  //Outline color
            fillOpacity:  isNullOrEmptyAlter(fillOpacity,0),
          }
        );
        _this.map.fitBounds(_this.G_Polygon.getBounds());
        return _this;
     }

    $.fn.setCluster=function()
    {
         var _this=this;
          let markers = new _this.G_L.MarkerClusterGroup();
         // console.log(markers)
          for (var i = 0; i < addressPoints.length; i++) {
            let a = addressPoints[i];
            let title = a[2];
            let marker = new _this.G_L.Marker(new _this.G_L.LatLng(a[0], a[1]), { title: title });
            marker.bindPopup(title);
            markers.addLayer(marker);
          }

          _this.map.addLayer(markers);
          _this.map.fitBounds(markers.getBounds());
          return _this;
    }

    $.fn.setPen = function()
    {
        var _this = this;
        var drawnItems = new L.FeatureGroup();
        this.map.addLayer(drawnItems);
         var t = new _this.G_L.Control.Draw({
             position: "topright",
             draw: {
                 polyline: !1,
                 marker: !1,
                 circlemarker: !1,
                 rectangle: !1,
                 circle: !1
             },
             edit: {
                 featureGroup: drawnItems
             }
         });

         _this.G_L.drawLocal = {
             draw: {
                 toolbar: {
                     actions: {
                         title: "انصراف از رسم",
                         text: "انصراف"
                     },
                     finish: {
                         title: "پایان رسم",
                         text: "پایان"
                     },
                     undo: {
                         title: "برداشتن دکمه آخر",
                         text: "بازگشت به حالت قبل"
                     },
                     buttons: {
                         polygon: "محدود کردن محیط با رسم چند ضلعی"
                     }
                 },
                 handlers: {
                     circle: {
                         tooltip: {
                             start: "- your text-"
                         },
                         radius: "- your text-"
                     },
                     circlemarker: {
                         tooltip: {
                             start: "- your text-."
                         }
                     },
                     marker: {
                         tooltip: {
                             start: "- your text-."
                         }
                     },
                     polygon: {
                         tooltip: {
                             start: "برای شروع رسم چند ضلعی بر روی موقعیت مورد نظر کلیک کنید",
                             cont: "برای ادامه رسم کلیک کنید",
                             end: "برای پایان رسم بر روی نقطه شروع کلیک کنید"
                         }
                     },
                     polyline: {
                         tooltip: {
                             start: "برای شروع رسم کلیک کنید",
                             cont: "برای ادامه رسم کلیک کنید",
                             end: "برای پایان رسم بر روی نقشه شروع کلیک کنید"
                         }
                     },
                     rectangle: {
                         tooltip: {
                             start: "- your text-."
                         }
                     },
                     simpleshape: {
                         tooltip: {
                             end: "Release mouse to finish drawing."
                         }
                     }
                 }
             },
             edit: {
                 toolbar: {
                     actions: {
                         save: {
                             title: "اعمال تغییرات",
                             text: "اعمال"
                         },
                         cancel: {
                             title: "لغو ویرایش، همه تغییرات را باز می گردند",
                             text: "لغو"
                         },
                         clearAll: {
                             title: "پاک کردن همه چند ضلعی ها",
                             text: "پاک کردن چند ضلعی رسم شده"
                         }
                     },
                     buttons: {
                         edit: "ویرایش چند ضلعی",
                         editDisabled: "موردی برای ویرایش وجود ندارد",
                         remove: "حذف چند ضلعی",
                         removeDisabled: "موردی برای حذف وجود ندارد"
                     }
                 },
                 handlers: {
                     edit: {
                         tooltip: {
                             text: "برای ویرایش، دکمه های روی چند ضلعی را جابجا کنید و سپس اعمال را فشار دهید",
                             subtext: "برای انصراف از تغییرات انجام شده لغو را فشار دهید"
                         }
                     },
                     remove: {
                         tooltip: {
                             text: "حذف چند ضلعی"
                         }
                     }
                 }
             }
         }

       _this.map.addControl(t);
       _this.map.on(_this.G_L.Draw.Event.DRAWSTART, function(e)
       {
            $(window).width() > 100 && $(".easy-filters-toggle.icon-cancel").trigger("click");
       });

       _this.map.on(_this.G_L.Draw.Event.CREATED, function(e)
       {

            let t = e.layer;
            drawnItems.addLayer(t),
            G_Filters.polygon = t.getLatLngs()[0].map(Object.values),
            $(".leaflet-draw-draw-polygon").addClass("leaflet-disabled")
        // $("#polygon-title").show().find("p").text("محدود به چند ضلعی"),
        //  ,applyFilters()
        });

        _this.map.on(L.Draw.Event.EDITED, function(e) {
            for (let t in e.target._layers)
            {
                if (e.target._layers.hasOwnProperty(t) && e.target._layers[t].hasOwnProperty("edited"))
                {
                    let a = e.target._layers[t].editing.latlngs[0];
                    _this.G_Filters.polygon = a[0].map(Object.values)
                    //,applyFilters()
                }
            }
            console.log(_this.G_Filters.polygon)
        });

        _this.map.on(L.Draw.Event.DELETED, function(e) {
            $(".leaflet-draw-draw-polygon").removeClass("leaflet-disabled");
            G_Filters.polygon = null;
            saleEstateListInPolygon = [];
            rentEstateListInPolygon = [];
            $("#polygon-title").hide();
            applyFilters();
        });
        _this.map.on("moveend zoomend", function() {
            //updateBoundaries(), findClosestDistrict()
        })

       return _this;
    }
    return this;
  };

}( jQuery ));
