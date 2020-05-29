/**************************************************************************************************
 * Geomap | Google Maps Javascript API v3를 이용하여 위치 기반 어플리케이션을 만듭니다.
 *
 * @class Geomap
 * @constructor
 * @version 1.0
 *
 **************************************************************************************************/
(function($) {

	'use strict';

	window.Geomap = function() {
		if(this instanceof Geomap === false) {
			return new Geomap();
		}
	};

	// Geomap class의 prototype 객체에 기본 property를 추가합니다.
	Geomap.prototype = {
		map: {},
		markers: [],
		opt: {
			initGeocode: {lat: 37.566535, lng: 126.97796919999996},
			mapOptions: {
				zoom: 12,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true
			},
			getCurrentPosition: true,
			icon: undefined,
			infoWindow: undefined,
			setMarker: true
		},
        geocoder: new google.maps.Geocoder()
	};

	/*
	 * Geomap class 초기화 함수
	 *
	 * @method initialize
	 * @param {String} container 컨테이너의 ID값
	 * @param {Object} options 옵션
	 * @param {Function} callback 콜백 함수
	 */
	Geomap.prototype.initialize = function(container, options, callback) {
		var _this = this;
		for(var prop in options) {
			if(prop === 'mapOptions') for(var property in options.mapOptions) this.opt[prop][property] = options[prop][property];
			else this.opt[prop] = options[prop];
		}
		var opt = this.opt;
		this.specialMarker = {
			url: opt.icon,
			scaledSize: new google.maps.Size(74, 86)
		};
		this.basicMarker = {
			url: opt.icon,
			scaledSize: new google.maps.Size(46, 55)
		};
		var generateMap = function(geocode) {
			if(typeof opt.mapOptions.center === 'undefined') opt.mapOptions.center = new google.maps.LatLng(geocode.lat, geocode.lng);
			_this.map = new google.maps.Map(document.getElementById(container), opt.mapOptions);
			if(opt.setMarker === true) _this.setClientLocationMarker(geocode);
			if(typeof callback === 'function') callback(geocode);
		};
		if(opt.getCurrentPosition === true) this.getCurrentPosition(generateMap, opt.initGeocode);
		else generateMap(opt.initGeocode);
	};

	/*
	 * 클라이언트의 현재 위치를 구합니다.
	 *
	 * @method getCurrentPosition
	 * @param {Function} callback
	 * @param {Object} geocode
	 */
	Geomap.prototype.getCurrentPosition = function(callback, geocode) {
		if(window.location.protocol.indexOf('https') > -1) {
			if(typeof navigator.geolocation === 'object') {
				navigator.geolocation.getCurrentPosition(function(response) {
					callback({lat: response.coords.latitude, lng: response.coords.longitude});
				}, function(e) {
					alert('장치의 현재 위치 접근이 차단되었거나 장치의 오류로 인하여 이용자의 현재 위치 정보를 가져올 수 없습니다.');
					callback(geocode);
				});
			} else {
				alert('브라우저가 현재 위치 접근 기능을 지원하지 않습니다.');
				callback(geocode);
			}
		} else {
			callback(geocode);
		}
	};

	/*
	 * 클라이언트의 현재 위치를 지도에 표시합니다.
	 *
	 * @method setClientLocationMarker
	 * @param {Object} geocode 경위도 좌표 값
	 */
	Geomap.prototype.setClientLocationMarker = function(geocode) {
		new google.maps.Marker({
			position: geocode,
			map: this.map,
			title: '내 위치'
		});
	};

	/*
	 * 특정 자원에서 위치 정보를 가져온 뒤 marking method를 호출합니다.
	 *
	 * @method setPlaceMarkers
	 * @param {String} requestUrl 위치 정보를 요청할 자원의 url
	 * @param {Object} params requestUrl에 전달할 쿼리
	 * @param {Function} callback 콜백 함수
	 */
	Geomap.prototype.setPlaceMarkers = function(requestUrl, params, callback) {
		var _this = this;
        $('.map_overlay').removeClass('on');
        $('.store_info_wrap').empty();
		this.deletePlaceMarkers();
		this.markers = [];
        var bounds = new google.maps.LatLngBounds();
		$.getJSON(requestUrl, params, function(response) {
            var length = response.length;
            for(var i=0; i<length; i++) {
                bounds.extend(new google.maps.LatLng(response[i]['view3_addr_y'], response[i]['view3_addr_x']));
                _this.marking(response[i], length);
            }
            if(params['local3']) {
                google.maps.event.trigger(_this.markers[0], 'click');
            } else {
                if(length > 1) {
                    _this.map.fitBounds(bounds);
                } else {
                    _this.map.setZoom(_this.opt.mapOptions.zoom);
                    if(params['local1']) {
                        _this.geocoding(params['local1'], function(geocode) {
                            _this.panToTarget(geocode);
                        });
                    } else {
                        _this.panToTarget(_this.opt.initGeocode);
                    }
                }
            }
			if(typeof callback === 'function') callback(response);
		}).error(function(e) {
			alert(e.statusText);
		});
	};

    /*
	 * 획득한 위치 정보를 바탕으로 지도에 마커를 표시합니다.
	 *
	 * @method marking
	 * @param {Object} data 위치 정보
	 * @param {Number} length 획득한 위치 정보의 갯수
	 */
	Geomap.prototype.marking = function(data, length) {
        var _this = this;
		var	marker = new google.maps.Marker({
			map: this.map,
			position: {lat: +data['view3_addr_y'], lng: +data['view3_addr_x']},
            title: data['title'],
			animation: google.maps.Animation.DROP,
			icon: this.basicMarker
		});
        google.maps.event.addListener(marker, 'click', function(e) {
            for(var i=0; i<_this.markers.length; i++) {
    			_this.markers[i].setIcon(_this.basicMarker);
    		}
            $('.map_overlay').addClass('on');
            _this.map.panTo(marker.getPosition());
            _this.map.setZoom(16);
            this.setIcon(_this.specialMarker);
            $.post(CONST_ROOT + '/html/map/place_pop.php', data, function(response) {
                $('.store_info_wrap').html(response);
            });
        });
		this.markers.push(marker);
	};

	/*
	 * 표시 중인 마커를 지웁니다.
	 *
	 * @method deletePlaceMarkers
	 */
	Geomap.prototype.deletePlaceMarkers = function() {
		for(var i=0; i<this.markers.length; i++) {
            this.markers[i].setIcon(this.basicMarker);
			this.markers[i].setMap(null);
		}
	};

    /*
	 * 해당 경위도 좌표 값으로 지도의 중심점을 옮깁니다.
	 *
	 * @method panToTarget
	 * @param {Object} geocode 경위도 좌표 값
	 */
	Geomap.prototype.panToTarget = function(geocode) {
		var marker = new google.maps.Marker({
			position: geocode,
			map: this.map,
			visible: false
		});
		this.map.panTo(marker.getPosition());
	};

    /*
	 * 문자열 주소를 경위도 좌표 값으로 변환한 뒤 callback 함수를 호출합니다.
	 *
	 * @method geocoding
	 * @param {String} address 변환할 주소
	 * @param {Function} callback 콜백 함수
	 */
	Geomap.prototype.geocoding = function(address, callback) {
		this.geocoder.geocode({address: address}, function(results, status) {
			if(status === google.maps.GeocoderStatus.OK) {
				var geocode = results[0].geometry.location;
				callback({lat: geocode.lat(), lng: geocode.lng()});
			} else if(status === google.maps.GeocoderStatus.ZERO_RESULTS) {
				throw new Error('요청하신 주소와 일치하는 값이 없습니다.');
			}
		});
	};

}(jQuery));


(function($) {
    $(document).ready(function() {
        function setMarkers(params) {
            $geomap.setPlaceMarkers(CONST_ROOT + '/html/map/map_data.php', params);
        }

        var $geomap = new Geomap();
        $geomap.initialize('placeLoadMap', {
            icon: CONST_REQUEST_ROOT + '/design/other/marker_big.png'
        }, function() {
            setMarkers({});
        });

        (function() {
            function local1Spread() {
    			if($local1Wrap.is(':hidden') === true) {
    				$local1Wrap.stop().slideDown(300, function() {
    					$(this).mCustomScrollbar({
    						autoDraggerLength: false,
    						scrollInertia: 80
    					});
    				});
    				if($local2Btn.text() !== local2BtnDef) $local2Btn.text(local2BtnDef);
    			}
    		}

            function local2Spread() {
    			if(local1Val && $local2Wrap.is(':hidden') === true) {
    				$local2Wrap.stop().slideDown(300, function() {
    					$(this).mCustomScrollbar({
    						autoDraggerLength: false,
    						scrollInertia: 80
    					});
    				});
    			}
    		}

            function local1Action(e) {
    			selectBoxInit();
    			$local1Btn.text($(this).text() === '전체' ? local1BtnDef : $(this).text());
                local1Val = $(this).data('value');
                $.getJSON(CONST_ROOT + '/html/map/district_data.php', {local1: local1Val}, function(response) {
                    $local2.empty();
                    if(response.length > 0) {
            			$local2.append('<li><a href="#none">전체</a></li>');
                        for(var i=0; i<response.length; i++) {
                            var text = (response[i]['local2'] ? response[i]['local2'] + ' ' : '') + response[i]['local3'];
        					$local2.append('<li><a href="#none" data-local2="' + response[i]['local2'] + '" data-local3="' + response[i]['local3'] + '">' + text + '</a></li>');
                        }
                    }
                    setMarkers({local1: local1Val});
                });
    			e.preventDefault();
    		}

            function local2Action(e) {
    			selectBoxInit();
                $local2Btn.text($(this).text());
    			if(typeof local1Val === 'string') {
                    setMarkers({local1: local1Val, local2: $(this).data('local2'), local3: $(this).data('local3')});
    			}
    			e.preventDefault();
    		}

            function selectBoxInit() {
    			if($local1Wrap.is(':visible')) {
    				$local1Wrap.hide(0, function() {
    					$(this).mCustomScrollbar('destroy');
    				});
    			}
    			if($local2Wrap.is(':visible')) {
    				$local2Wrap.hide(0, function() {
    					$(this).mCustomScrollbar('destroy');
    				});
    			}
    		}

            function top10Action(e) {
                selectBoxInit();
                setMarkers({local1: $(this).data('local1'), local2: $(this).data('local2'), local3: $(this).data('local3')});
                e.preventDefault();
            }

            var $placeFindWrap = $('#placeFindWrap'),
                $local1Wrap = $('#local1ListWrap'),
                $local2Wrap = $('#local2ListWrap'),
                $local1Btn = $('#local1Button'),
                $local2Btn = $('#local2Button'),
                $local1 = $('#local1'),
    			$local2 = $('#local2'),
    			local1BtnDef = $local1Btn.text(),
    			local2BtnDef = $local2Btn.text(),
                local1Val = null,
    			local2Val = null;

            var $top10List = $('.top10-list');

            $local1Btn.on('click', local1Spread);
            $local2Btn.on('click', local2Spread);
            $local1.on('click', 'a', local1Action);
            $local2.on('click', 'a', local2Action);

            $top10List.on('click', top10Action);

            $placeFindWrap.find('.cols').on('mouseleave', selectBoxInit);

            $('.zoom-control').on('click', 'button', function() {
                $geomap.map.setZoom($geomap.map.getZoom() + ($(this).data('fx') === '+' ? 1 : -1));
            });
        }());
    });
}(jQuery));
