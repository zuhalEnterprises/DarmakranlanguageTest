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
    $.fn.kamaMap = function( options ) {
        var map;
        var G_marker;
        var G_circle;
        var G_Polygon;
        var G_L;
        var G_MarkerCluster;
        var G_PenPolygon;
        var G_Pen_mouseDown=false;
        var G_Pen_mouseMove=false;
        var G_Pen_ThereIsOneBoundry=false;
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
            showPen:false,
            borderColor: "#3388ff",
            fillColor: "#3388ff",
            shapeOpacity:0.3,
            circleRadius:0.00300,
            minZoom:10,
            maxZoom:18,
            lat:35.67849408943879,
            lng:51.39129638671876,
            zoom:10,
            click_duration:0.5,
            click_zoom:13,
            click_animation:true,
            attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">nitasoft.ir</a>'
        }, options );

        this.G_L=L;

        this.G_PenPolygon=null;
        this.G_Pen_ThereIsOneBoundry=false;
        this.map = L.map(this.attr('id'), {zoomControl:settings.zoomControl,
            scrollWheelZoom:settings.scrollWheelZoom,
            minZoom: settings.minZoom,
            maxZoom: settings.maxZoom,
            // drawControl: settings.drawControl
            }).setView([settings.lat,settings.lng], settings.zoom);//.fitWorld();

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        {attribution:settings.attribution,}).addTo(this.map);

        $.fn.PenDrawBoundry = function(callback,removeCallback)
        {
            var _this = this;
            _this.append($('<div class="leaflet-top leaflet-right"><div class="leaflet-draw leaflet-control"><div class="leaflet-draw-section"><div class="leaflet-draw-toolbar leaflet-bar" style="margin-top:60px;margin-right:10px"><a id="js_refreshButton" title="رسم محدوده دلخواه" class="leaflet-draw-edit-edit leaflet-enabled"><i class="mr-2 fa fa-pen"></i><span class="font-danger">رسم محدوده جغرافیایی</span></a></div></div></div></div>'));
            $(this).find('#js_refreshButton').click(function()
            {
                $(this).toggleClass('active');
                $(this).find('i').toggleClass('fa-pen');
                $(this).find('i').toggleClass('fa-remove');
                $(this).parent().toggleClass('active');
                $(_this).toggleClass('activePen');
                if($(this).hasClass('active'))
                {
                    if(_this.privateIsMobile())
                    {
                        _this.find('.leaflet-right:first').hide();
                    }
                }
                else
                {
                    if (typeof removeCallback == 'function') { // make sure the callback is a function
                        removeCallback.call(this); // brings the scope to the callback
                    }

                    if (!isNullOrEmpty(_this.G_PenPolygon)) {
                        _this.map.removeLayer(_this.G_PenPolygon);

                    };
                    _this.G_Pen_mouseDown = false;
                    _this.G_Pen_mouseMove = false;
                    _this.G_Pen_ThereIsOneBoundry=false;
                    _this.setCluster(addressPoints);
                }
            });

            if(_this.privateIsMobile())
            {
                _this.map.on('touchstart', function() {
                    _this.privateMouseDown();
                });

                $(document).on('touchend touchcancel',_this.map, function() {
                _this.privateMouseUp(callback);
                _this.find('.leaflet-right:first').show();
                });

                _this.map.on('touchmove', function(e){
                    _this.privateMouseMove(e);
                });
            }
            else
            {
                _this.map.on('mousedown', function() {
                    _this.privateMouseDown();
                });

                _this.map.on('mouseup', function() {
                _this.privateMouseUp(callback);
                });

                _this.map.on('mousemove', function(e){
                    _this.privateMouseMove(e);
                });
            }
            return _this;
    };

    $.fn.privateMouseUp = function(callback) {
        var _this=this;

        if($(_this).hasClass('activePen'))
        {
            if(_this.G_Pen_mouseDown==true && _this.G_Pen_mouseMove==true)
            {
                var arrPoint=_this.G_PenPolygon.editing._poly._latlngs;
                if( arrPoint[0] !=arrPoint[arrPoint.length-1] )
                {
                    _this.G_PenPolygon.addLatLng(arrPoint[0]);
                    arrPoint.push(arrPoint[0]);

                    var finalArr=new Array();
                    for(var i = 0; i < arrPoint.length; i++) {
                        finalArr.push([arrPoint[i].lat,arrPoint[i].lng]);
                    }
                    _this.setCluster(_this.Private_PointInPolygon(addressPoints,finalArr,callback));
                    if(finalArr.length>0)
                    {
                        _this.map.fitBounds(finalArr);
                    }
                    _this.G_Pen_paintMode=false;
                }
            }
            _this.G_Pen_mouseDown = false;
            _this.G_Pen_mouseMove = false;
            _this.G_Pen_ThereIsOneBoundry=true;
            _this.map.dragging.enable();
        }
    };

    $.fn.privateMouseMove = function(e)
    {
        var _this=this;
        if ($(_this).hasClass('activePen'))
        {
            if (_this.G_Pen_mouseDown==true)
            {
                _this.G_Pen_mouseMove=true;
                _this.G_PenPolygon.addLatLng(e.latlng);
            //  console.log(e.latlng)
            }
        }
    };

    $.fn.privateMouseDown = function()
    {
        var _this=this;
        if($(_this).hasClass('activePen'))
        {

            if(_this.G_Pen_ThereIsOneBoundry==false)
            {
                _this.map.dragging.disable();
                _this.G_Pen_mouseDown = true;

            // if (_this.G_Pen_mouseMove) {
                    _this.G_PenPolygon = _this.G_L.polyline([]).addTo(_this.map);
                //  console.log(_this.myPolyline)
            //  }
            }
        }
    };

    $.fn.privateIsMobile = function()
    {
        let isMobile=false;
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
                || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
                isMobile = true;
            }

            return isMobile;
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
                if (!isNullOrEmpty(_this.G_circle)) {
                    _this.map.removeLayer(_this.G_circle);
                };

            _this.map.on('zoomend', function () {
                _this.drawCircle(callback);
            });
            }
    });
    return  _this;
    };

    $.fn.showCircle = function(lat,lng,delay) {
            var _this=this;
            setTimeout(() => {
                _this.G_circle =  _this.G_L.circle([lat,lng], {
                color: settings.borderColor,
                fillColor: settings.fillColor,
                fillOpacity: settings.shapeOpacity,
                radius: settings.circleRadius*100000
            }).addTo(_this.map);
            }, delay);
            return _this;
    };

    $.fn.showMarkerByClick = function(showCircle) {
        var _this=this;

        _this.map.on('click', function(e) {
            if (!isNullOrEmpty(_this.G_marker))
            {
            _this.map.removeLayer(_this.G_marker);
            };
            //console.log(e.latlng);
            _this.map.flyTo([e.latlng.lat,e.latlng.lng], settings.click_zoom,
            {
                animate: settings.click_animation,
                duration: settings.click_duration,

            });
            _this.data('markerPoint',[e.latlng.lat,e.latlng.lng]);
            _this.G_marker = _this.G_L.marker([e.latlng.lat,e.latlng.lng]).addTo(_this.map);
        if(showCircle)
        {
            _this.map.on('zoomend', function () {
                _this.drawCircle();
            });
        }
    });
    return _this;
    };

    $.fn.showMarkerAndCircleByClick = function() {
    return this.showMarkerByClick(true);
    };

    $.fn.drawCircle = function(callback)
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

        if (typeof callback == 'function') { // make sure the callback is a function

            let data={};
            data.markerPoint=_this.data('markerPoint');
            data.circlePoint=_this.data('circlePoint');

            callback.call(this,data); // brings the scope to the callback
        }
        return _this;
    };

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
        if(pointArray == undefined){
            return null;
        }
        data.geometry.coordinates=JSON.parse("[" + pointArray + "]");

        _this.G_Polygon = _this.G_L.geoJSON(data).addTo(_this.map);
        _this.G_Polygon.setStyle(
        {
            fillColor: isNullOrEmptyAlter(fillColor,'#f00'),
            weight:isNullOrEmptyAlter(borderWith,1) ,
            opacity: isNullOrEmptyAlter(borderOpacity,1),
            color: isNullOrEmptyAlter(borderColor,'#3388ff'),  //Outline color
            fillOpacity:  isNullOrEmptyAlter(fillOpacity,0),
        }
        );
        _this.map.fitBounds(_this.G_Polygon.getBounds());
        return _this;
    };

    $.fn.setCluster=function(points)
    {
        var _this=this;

        if (!isNullOrEmpty( _this.G_MarkerCluster)) {
            _this.map.removeLayer( _this.G_MarkerCluster);
        };

        let poitnArr=points;
        if(poitnArr==undefined || poitnArr==null)
        {
            poitnArr=addressPoints;
        }

        _this.G_MarkerCluster  = new _this.G_L.MarkerClusterGroup();

        // console.log(markers)
        for (var i = 0; i < poitnArr.length; i++) {
            console.log(poitnArr.length);
            let a = poitnArr[i];
            let title = a[3];
            let marker = new _this.G_L.Marker(new _this.G_L.LatLng(a[0], a[1]), { title: title });
            if(0 && siteid != undefined && siteid == 4)
            {
                marker.bindPopup("ID: " + a[2] +" [<a target='_blank' href='/v/"+a[2]+"'>View</a>]<br><br>" + title );
            }
            else
            {
                marker.bindPopup("کد ملک: " + a[2] +" [<a target='_blank' href='/v/"+a[2]+"'>مشاهده</a>]<br><br>" + title );
            }
            //marker.bindPopup(title);
            //marker.title = title;
            marker.on('dblclick', function(e) {
                //mapClick(a[2]);
            });
            _this.G_MarkerCluster.addLayer(marker);
        }

        _this.map.addLayer(_this.G_MarkerCluster);
        //   if(poitnArr.length>0)
        //   {
        //       //aaa
        //     _this.map.fitBounds( _this.G_MarkerCluster.getBounds());
        //   }
        return _this;
    };

    $.fn.setPen = function(callback)
    {
        var _this = this;
        // var drawnItems = new L.FeatureGroup();
        // this.map.addLayer(drawnItems);
        //  var t = new _this.G_L.Control.Draw({
        //      position: "topright",
        //      draw: {
        //          polyline: 0,
        //          marker: !1,
        //          circlemarker: !1,
        //          rectangle: !1,
        //          circle: !1,
        //          simpleshape:true
        //      },
        //      edit: {
        //          featureGroup: drawnItems
        //      }
        //  });

    //      _this.G_L.drawLocal = {
    //          draw: {
    //              toolbar: {
    //                  actions: {
    //                      title: "انصراف از رسم",
    //                      text: "انصراف"
    //                  },
    //                  finish: {
    //                      title: "پایان رسم",
    //                      text: "پایان"
    //                  },
    //                  undo: {
    //                      title: "برداشتن دکمه آخر",
    //                      text: "بازگشت به حالت قبل"
    //                  },
    //                  buttons: {
    //                      polygon: "محدود کردن محیط با رسم چند ضلعی"
    //                  }
    //              },
    //              handlers: {
    //                  circle: {
    //                      tooltip: {
    //                          start: "- your text-"
    //                      },
    //                      radius: "- your text-"
    //                  },
    //                  circlemarker: {
    //                      tooltip: {
    //                          start: "- your text-."
    //                      }
    //                  },
    //                  marker: {
    //                      tooltip: {
    //                          start: "- your text-."
    //                      }
    //                  },
    //                  polygon: {
    //                      tooltip: {
    //                          start: "برای شروع رسم چند ضلعی بر روی موقعیت مورد نظر کلیک کنید",
    //                          cont: "برای ادامه رسم کلیک کنید",
    //                          end: "برای پایان رسم بر روی نقطه شروع کلیک کنید"
    //                      }
    //                  },
    //                  polyline: {
    //                      tooltip: {
    //                          start: "برای شروع رسم کلیک کنید",
    //                          cont: "برای ادامه رسم کلیک کنید",
    //                          end: "برای پایان رسم بر روی نقشه شروع کلیک کنید"
    //                      }
    //                  },
    //                  rectangle: {
    //                      tooltip: {
    //                          start: "- your text-."
    //                      }
    //                  },
    //                  simpleshape: {
    //                      tooltip: {
    //                          end: "Release mouse to finish drawing."
    //                      }
    //                  }
    //              }
    //          },
    //          edit: {
    //              toolbar: {
    //                  actions: {
    //                      save: {
    //                          title: "اعمال تغییرات",
    //                          text: "اعمال"
    //                      },
    //                      cancel: {
    //                          title: "لغو ویرایش، همه تغییرات را باز می گردند",
    //                          text: "لغو"
    //                      },
    //                      clearAll: {
    //                          title: "پاک کردن همه چند ضلعی ها",
    //                          text: "پاک کردن چند ضلعی رسم شده"
    //                      }
    //                  },
    //                  buttons: {
    //                      edit: "ویرایش چند ضلعی",
    //                      editDisabled: "موردی برای ویرایش وجود ندارد",
    //                      remove: "حذف چند ضلعی",
    //                      removeDisabled: "موردی برای حذف وجود ندارد"
    //                  }
    //              },
    //              handlers: {
    //                  edit: {
    //                      tooltip: {
    //                          text: "برای ویرایش، دکمه های روی چند ضلعی را جابجا کنید و سپس اعمال را فشار دهید",
    //                          subtext: "برای انصراف از تغییرات انجام شده لغو را فشار دهید"
    //                      }
    //                  },
    //                  remove: {
    //                      tooltip: {
    //                          text: "حذف چند ضلعی"
    //                      }
    //                  }
    //              }
    //          }
    //      }

    //     //_this.map.addControl(t);
    //    _this.map.on(_this.G_L.Draw.Event.DRAWSTART, function(e)
    //    {
    //         $(window).width() > 100 && $(".easy-filters-toggle.icon-cancel").trigger("click");
    //    });

    //    _this.map.on(_this.G_L.Draw.Event.CREATED, function(e)
    //    {

    //         let t = e.layer;
    //         drawnItems.addLayer(t);
    //         G_Filters.polygon = t.getLatLngs()[0].map(Object.values);

    //         $(".leaflet-draw-draw-polygon").addClass("leaflet-disabled");
    //     // $("#polygon-title").show().find("p").text("محدود به چند ضلعی"),
    //     //  ,applyFilters()

    //         _this.setCluster(_this.Private_PointInPolygon(addressPoints,G_Filters.polygon,callback));
    //     });

        // _this.map.on(L.Draw.Event.EDITED, function(e) {
        //     for (let t in e.target._layers)
        //     {
        //         if (e.target._layers.hasOwnProperty(t) && e.target._layers[t].hasOwnProperty("edited"))
        //         {
        //             let a = e.target._layers[t].editing.latlngs[0];
        //             _this.G_Filters.polygon = a[0].map(Object.values)
        //             //,applyFilters()
        //         }
        //     }
        //     console.log(_this.G_Filters.polygon)
        // });

        // _this.map.on(L.Draw.Event.DELETED, function(e) {
        //     $(".leaflet-draw-draw-polygon").removeClass("leaflet-disabled");
        //     G_Filters.polygon = null;
        //     saleEstateListInPolygon = [];
        //     rentEstateListInPolygon = [];
        //     $("#polygon-title").hide();
        //     _this.setCluster();
        //    // applyFilters();
        // });
        // _this.map.on("moveend zoomend", function() {
        //     //updateBoundaries(), findClosestDistrict()
        // })

    return _this;
    };
    $.fn.Private_PointInPolygon = function(arrPoint,arrPolygon,callback)
    {
        var points = turf.points(arrPoint);
        var arr=new Array();
        var turfPolygon=arrPolygon;
        // set end point on start point
        if(turfPolygon[0]!=turfPolygon[arrPolygon.length-1])
        {
            turfPolygon.push(turfPolygon[0]);
        }
        // increse poligon point length
        for (var i = 0; i < turfPolygon.length; i++)
        {
            turfPolygon[i][0]=parseFloat(parseFloat(turfPolygon[i][0]).toFixed(5));
            turfPolygon[i][1]=parseFloat(parseFloat(turfPolygon[i][1]).toFixed(5));
        }
        arr.push(turfPolygon);
        var searchWithin = turf.polygon(arr);
        var ptsWithin = turf.pointsWithinPolygon(points, searchWithin);
        var arrNewPoint=new Array();
        for (var i = 0; i < ptsWithin.features.length; i++)
        {
            arrNewPoint.push(ptsWithin.features[i].geometry.coordinates);
        }
        if (typeof callback == 'function') { // make sure the callback is a function

            let data={};
            data.points=new Array();
            for (var i = 0; i < arrNewPoint.length; i++)
            {
                data.points.push(arrNewPoint[i][2]);
            }
            data.points=data.points.join(',');
            callback.call(this,data); // brings the scope to the callback
        }

        return arrNewPoint;
    };
    if(settings.drawControl)
    {
        this.setPen();
    };
    if(settings.showPen)
    {
        this.PenDrawBoundry();
    };
    return this;
};
}( jQuery ));
