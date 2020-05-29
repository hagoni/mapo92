/**************************************************************************************************
 * PreLoader | 프리로더입니다.
 *
 * @class PreLoader
 * @constructor
 * @version 1.0
 *
 * @param {Array} assets 불러올 자원 배열
 * @param {Function} callback 콜백 함수
 *
 **************************************************************************************************/
window.PreLoader = function(assets, callback) {

	'use strict';

	if(this instanceof PreLoader === false) {
		return new PreLoader(assets, callback);
	}

	if(typeof assets !== 'object') return false;

	var _this = this;

	var LENGTH = assets.length;

	var	unit = 100 / LENGTH,
		progress = 0,
		loaded = false,
		imgs = [];

	this.initialize = function() {
		for(var i=0; i<assets.length; i++) {
			imgs[i] = new Image();
			this.setHandler(imgs[i]);
			imgs[i].src = assets[i];
		}
	};

	this.setHandler = function(img) {
		img.onload = this.calculate;
		img.onerror = this.report;
	};

	this.calculate = function() {
		progress += unit;
		if(Math.ceil(progress) >= 100) {
			if(loaded === false) _this.load();
			loaded = true;
		}
	};

	this.report = function() {
		if(typeof console === 'object') console.log(this.src + ' 이미지를 불러올 수 없습니다.');
		_this.calculate();
	}

	this.load = function() {
		if(typeof callback === 'function') callback();
	};

	this.initialize();
};


/**************************************************************************************************
 * FlowSlider | 흐르는 슬라이더입니다.
 *
 * @class FlowSlider
 * @constructor
 * @version 1.0
 *
 * @param {Object} container jQuery 객체
 * @param {Object} options 옵션 객체
 *
 **************************************************************************************************/
(function($) {

	'use strict';

	window.FlowSlider = function(container, options) {

		if(this instanceof FlowSlider === false) {
			return new FlowSlider(container, options);
		}

		var _this = this;

		var container = typeof container === 'object' ? container : $('#' + container),
			opt = {autoPlay: true, axis: 'x', pps: 60, unit: 'px', itemsPerView: 4, reverse: false, stopOver: true};

		for(var prop in options) {
			opt[prop] = options[prop];
		}

		var wrapper = container.children(':first-child'),
			items = wrapper.children(),
			initLength = items.length,
			length = initLength;

		if(items.length === 0) return false;

		var	containerDim,
			itemDim,
			scrollMax,
			animProp,
            init = true;

		var tl;

		var assetsLoaded = false,
			preLoadTimer = null,
			playTryCount = 0;

		var resizeTimer = null;

		this.initialize = function() {
			animProp = opt.axis === 'x' ? 'scrollLeft' : 'scrollTop';
			this.assetsPreload(function() {
				assetsLoaded = true;
				_this.setSliderProps();
				_this.setTimeline();
				_this.setHandler();
				_this.flow();
			});
		};

		this.assetsPreload = function(callback) {
			var assets = [];
			container.find('*').each(function(i) {
				if($(this).prop('tagName') === 'IMG') assets.push($(this).attr('src'));
			});
			if(assets.length > 0) new PreLoader(assets, callback);
			else callback();
		};

		this.setSliderProps = function() {
			containerDim = opt.axis === 'x' ? container.width() : container.height();
			itemDim = opt.unit === 'px' ? opt.axis === 'x' ? items.eq(0).outerWidth(true) : items.eq(0).outerHeight(true) : containerDim / opt.itemsPerView;
            if(init === true) {
                var appendCount = itemDim * initLength > containerDim ? 1 : Math.ceil(containerDim / (itemDim * initLength));
				if(appendCount === Infinity) return false;
                for(var i=0; i<appendCount; i++) {
                    items.clone().addClass('flow-items-clone').appendTo(wrapper);
                }
                scrollMax = itemDim * initLength;
            } else {
				if(opt.unit !== 'px') scrollMax = itemDim * initLength;
                if(itemDim * length < containerDim + scrollMax) {
                    var appendCount = Math.ceil(((containerDim + scrollMax) - (itemDim * length)) / scrollMax);
					if(appendCount === Infinity) return false;
                    for(var i=0; i<appendCount; i++) {
                        items.not('.flow-items-clone').clone().addClass('flow-items-clone').appendTo(wrapper);
                    }
                }
            }
            items = wrapper.children();
            length = items.length;
			opt.axis === 'x' ? wrapper.width(itemDim * length) : wrapper.height(itemDim * length);
            if(opt.unit !== 'px') opt.axis === 'x' ? items.width(itemDim) : items.height(itemDim);
            init = false;
		};

		this.setTimeline = function() {
			tl = new TimelineMax({paused: true, repeat: -1});
			var from = {}, to = {ease: Power0.easeNone};
			from[animProp] = opt.reverse === false ? 0 : scrollMax;
			to[animProp] = opt.reverse === false ? scrollMax : 0;
			tl.fromTo(container, scrollMax / opt.pps, from, to);
		};

		this.setHandler = function() {
			$(window).resize(this.handler.resize);
			if(opt.stopOver === true) {
				container.mouseenter(function() {
					if(opt.autoPlay === true) tl.pause();
				}).mouseleave(function() {
					if(opt.autoPlay === true) tl.play();
				});
			}
		};

		this.handler = {
			resize: function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function() {
					if(assetsLoaded === true) {
						_this.setSliderProps();
						_this.tlReset();
					}
				}, 100);
			}
		};

		this.tlReset = function() {
			tl.recent().vars.startAt[animProp] = opt.reverse === false ? 0 : scrollMax;
			tl.recent().vars[animProp] = opt.reverse === false ? scrollMax : 0;
			tl.duration(scrollMax / opt.pps);
			tl.invalidate();
		};

		this.flow = function() {
			if(opt.autoPlay === true) tl.play();
		};

		this.play = function() {
			clearTimeout(preLoadTimer);
			if(assetsLoaded === false) {
				if(playTryCount > 50) throw new Error('이미지 로딩이 끝나지 않아 play method를 호출할 수 없습니다.');
				preLoadTimer = setTimeout(function() {
					playTryCount++;
					_this.play();
				}, 100);
				return false;
			}
			if(tl.paused() === true) tl.play();
			opt.autoPlay = true;
		};

		this.stop = function() {
			if(tl.paused() === false) tl.pause();
			opt.autoPlay = false;
		};

		// FlowSlider class 초기화 함수를 호출합니다.
		this.initialize();
	};

}(jQuery));

(function($) {

	'use strict';

	window.YMotion = function(motionItems, options) {

		var _this = this;

        var opt = {oElems: 'motion-offset', rewind: false, oFixed: false, singly: false, half: false, divide: 2};

        for(var prop in options) {
            opt[prop] = options[prop];
        }

		var motionOffsetElems = [],
			motionOffset = [],
			rewindOffset = [],
			limitOffset,
			tempTl = [],
            sortTl = [],
			motionEnded = [],
			prevScrollTop = win.scrollTop(),
			scrollTop = prevScrollTop,
			winH,
			prevDocH,
			docH = doc.height(),
			docDiff = 0,
			queued = false,
			active = false;

		var	LENGTH = motionItems.length;

		this.initialize = function() {
			this.setMotionOffset();
			this.setElements();
			this.setTimeline();
		};

		this.setMotionOffset = function() {
			$('[data-' + opt.oElems + ']').each(function(i) {
				motionOffsetElems[i] = $(this);
				motionOffsetElems[i].data({offset: motionOffsetElems[i].offset().top, height: parseFloat(motionOffsetElems[i].css('height'), 10)});
			});

			prevDocH = docH;
			docH = doc.height();
			docDiff = docH - prevDocH;
			winH = win.height();
			limitOffset = docH - winH;
			for(var i=0, j=0, tempH; i<motionOffsetElems.length; i++) {
				tempH = opt.half === false ? motionOffsetElems[i].data('height') : motionOffsetElems[i].data('height') / 2;
				motionOffset[i] = tempH > winH / opt.divide ? (motionOffsetElems[i].data('offset') + docDiff) - winH + (winH / opt.divide) : (motionOffsetElems[i].data('offset') + docDiff) - winH + tempH;
				if(typeof motionOffsetElems[i].data('diff') === 'number') motionOffset[i] -= motionOffsetElems[i].data('diff');
				if(motionOffset[i] > limitOffset) {
					motionOffset[i] = limitOffset - motionOffsetElems.length + j;
					j++;
				}
				if(opt.oFixed === true && motionOffset[i] < 0) motionOffset[i] = 0;
				rewindOffset[i] = motionOffset[i];
			}
			motionOffset[motionOffsetElems.length] = limitOffset + 1;
			rewindOffset[motionOffsetElems.length] = limitOffset + 1;
		};

		this.setElements = function() {
			for(var i=0; i<LENGTH; i++) {
				for(var j=0, o; j<motionItems[i].length; j++) {
					o = motionItems[i][j];
                    if(typeof o.method === 'undefined') {
						if(o.el.length === 0) continue;
						if(o.effect === 'text') {
							$(o.el).each(function(k) {
								var _text = $(this).html();
								var html = '';
								var text = _text.replace(/\<br(\s?\/?)\>/g, '^').replace('&amp;', '&');
								for(var l=0; l<text.length; l++) {
									if(text[l] !== '^') html += '<i>'+ text[l] +'</i>';
									else html += '<br>';
								}
								$(this).html(html);
							});
						}
						if(typeof o.set === 'undefined') continue;
                        TweenMax.set(o.el, o.set);
                    } else {
                        switch(o.method) {
                            case 'add':
								if(typeof o.items === 'object') {
	                                for(var k=0; k<o.items.length; k++) {
										if(typeof o.items[k].set === 'undefined' || o.items[k] instanceof TimelineMax === true || o.items[k].el.length === 0) continue;
										TweenMax.set(o.items[k].el, o.items[k].set);
									}
								}
                                break;
                            default:
                                break;
                        }
                    }
				}
			}
		};

		this.setTimeline = function() {
			for(var i=0; i<LENGTH; i++) {
				tempTl[i] = new TimelineMax({paused: true, onComplete: function() {
					if(opt.singly === true) {
						queued = false;
						_this.handler.scroll();
					}
				}, onReverseComplete: function() {
					if(opt.singly === true) {
						queued = false;
						if(opt.oFixed === false) _this.handler.scroll();
						else {
							if(scrollTop <= 0 && scrollTop - prevScrollTop <= 0) {
								prevScrollTop = 0.5;
								_this.scroll();
							}
						}
					} else {
						if(opt.oFixed === true && scrollTop <= 0 && scrollTop - prevScrollTop <= 0) {
							prevScrollTop = 0.5;
							_this.scroll();
						}
					}
				}});
				motionEnded[i] = false;
				for(var j=0, o; j<motionItems[i].length; j++) {
                    o = motionItems[i][j];
					if(typeof o.method === 'undefined' && typeof o.to === 'undefined') continue;
                    if(typeof o.method === 'undefined') {
						if(o.el.length === 0) continue;
						if(o.effect !== 'text') {
							typeof o.t === 'undefined' ? tempTl[i].to(o.el, o.d, o.to) : tempTl[i].to(o.el, o.d, o.to, o.t);
						} else {
							$(o.el).each(function(k) {
								$(this).find('i').each(function(l) {
									if($.trim($(this).text()) !== '') typeof o.t === 'undefined' ? tempTl[i].to($(this), o.d, o.to) : tempTl[i].to($(this), o.d, o.to, l > 0 ? o.t : '+=0');
								});
							});
						}
                    } else {
                        switch(o.method) {
							case 'addLabel':
								tempTl[i][o.method](o.label);
								break;
                            case 'add':
								var a = [];
								if(typeof o.items === 'object') {
									for(var k=0; k<o.items.length; k++) {
										if(o.items[k] instanceof TimelineMax === true || o.items[k].el.length === 0) continue;
										a[k] = TweenMax.to(o.items[k].el, o.items[k].d, o.items[k].to);
									}
								}
								if(typeof o.tl === 'object') a.push(o.tl);
								typeof o.t === 'undefined' ? tempTl[i][o.method](a) : tempTl[i][o.method](a, o.t);
                                break;
							case 'call':
								typeof o.t === 'undefined' ? tempTl[i][o.method](o.fx) : tempTl[i][o.method](o.fx, null, null, o.t);
                            default:
                                break;
                        }
                    }
				}
			}
            for(var i=0; i<motionOffsetElems.length; i++) {
				sortTl[i] = typeof +motionOffsetElems[i].data(opt.oElems) === 'number' ? tempTl[+motionOffsetElems[i].data(opt.oElems) - 1] : '움직이지 않을래';
			}
		};

		this.setHandler = function() {
			win.scroll(this.handler.scroll).resize(this.handler.resize);
		};

        this.handler = {
            scroll: function() {
				prevScrollTop = scrollTop;
				_this.scroll();
            },
            resizeTimer: null,
            resize: function() {
                clearTimeout(_this.handler.resizeTimer);
				_this.handler.resizeTimer = setTimeout(function() {
					_this.setMotionOffset();
					_this.handler.scroll();
				}, 100);
            }
        };

		this.scroll = function() {
			scrollTop = win.scrollTop() >= 0 ? (win.scrollTop() <= limitOffset ? win.scrollTop() : limitOffset) : 0;
			opt.rewind === false ? _this.motion() : scrollTop - prevScrollTop >= 0 ? _this.motion() : _this.rewind();
		};

		this.motion = function() {
			for(var i=0; i<LENGTH; i++) {
				if(scrollTop >= motionOffset[i] && motionEnded[i] === false && typeof sortTl[i] === 'object') {
					if(opt.singly === false) {
						sortTl[i].timeScale(1).play();
						motionEnded[i] = true;
					} else {
						if(i === 0 || sortTl[i - 1].isActive() === false && queued === false) {
							sortTl[i].timeScale(1).play();
							motionEnded[i] = true;
						} else if(i > 0 && sortTl[i - 1].isActive() === true) {
							queued = true;
						}
					}
				}
			}
		};

		this.rewind = function() {
			for(var i=LENGTH - 1; i>-1; i--) {
				if(scrollTop <= rewindOffset[i] && motionEnded[i] === true && typeof sortTl[i] === 'object') {
					if(opt.singly === false) {
						sortTl[i].timeScale(2).reverse();
						motionEnded[i] = false;
					} else {
						if(i === LENGTH - 1 || sortTl[i + 1].isActive() === false && queued === false) {
							sortTl[i].timeScale(2).reverse();
							motionEnded[i] = false;
						} else if(i < LENGTH - 1 && sortTl[i + 1].isActive() === true) {
							queued = true;
						}
					}
				}
			}
		};

		this.activate = function() {
            if(active === false) {
                this.setHandler();
                this.handler.scroll();
                active = true;
            }
		};

		this.disable = function() {
			for(var i=0; i<LENGTH; i++) {
				if(typeof sortTl[i] === 'object') sortTl[i].progress(1);
				motionEnded[i] = true;
			}
		};

		this.reset = function() {
			$('[data-' + opt.oElems + ']').each(function(i) {
				motionOffsetElems[i] = $(this);
				motionOffsetElems[i].data({offset: motionOffsetElems[i].offset().top, height: parseFloat(motionOffsetElems[i].css('height'), 10)});
			});
			for(var i=0; i<LENGTH; i++) {
				if(typeof sortTl[i] === 'object') sortTl[i].pause(0);
				motionEnded[i] = false;
				queued = false;
			}
			this.setMotionOffset();
			this.handler.scroll();
		};

		this.initialize();
	};

}(jQuery));

/**************************************************************************************************
 * GIFMotion | GIF 애니메이션 효과를 구현합니다.
 *
 * @class GIFMotion
 * @constructor
 * @version 1.0
 *
 * @param {Array} assets 불러올 자원 배열
 * @param {Object} options 옵션 객체
 *
 **************************************************************************************************/
(function($) {

	'use strict';

	window.GIFMotion = function(assets, options) {

		if(this instanceof GIFMotion === false) {
			return new GIFMotion(assets, options);
		}

		if(typeof assets !== 'object') return false;

		var _this = this,
			opt = {autoPlay: true, fps: 30, loop: 1};

		for(var prop in options) {
			opt[prop] = options[prop];
		}

		var playTimes = 0,
			timer = [];

		var LENGTH = assets.length;

		this.initialize = function() {
			if(opt.autoPlay === true) this.play();
		};

		this.play = function() {
			if(playTimes === opt.loop) return false;
			for(var i=0; i<LENGTH; i++) {
				this.act(i);
			}
		};

		this.act = function(i) {
			timer[i] = setTimeout(function() {
				assets.filter(':visible').css('visibility', 'hidden');
				assets.eq(i).css('visibility', 'visible');
				if(i === LENGTH - 1) {
					playTimes++;
					timer.push(
						setTimeout(function() {
							_this.play();
						}, opt.fps)
					);
					return false;
				}
			}, opt.fps * i);
		};

		this.stop = function() {
			for(var i=0; i<timer.length; i++) {
				clearTimeout(timer[i]);
			}
			assets.filter(':visible').css('visibility', 'hidden');
			assets.eq(0).css('visibility', 'visible');
		};

		this.initialize();
	};

}(jQuery));

(function($) {
    doc.ready(function() {
		function boxloop(index) {
			$('.fran_ttl li').each(function(i) {
				var box = $(this);
				// var $elements = $('.section3 .box');
				setTimeout(function() {
					box.addClass('on');
					box.siblings().removeClass('on');
					// boxloop((index + 1) % $elements.length);
				}, 200 * i);
			});
		}

		new YMotion([
			[
				{el: '.el1_1', set: {opacity: 0, scale: 1.5}, to: {opacity: 1, scale: 1, ease: Expo.easeIn}, d: 0.4},
				{el: '.el1_2', set: {backgroundPositionY: 0}, to: {backgroundPositionY: -35}, d: 0.6},
				{el: '.el1_3', set: {backgroundPositionY: 0}, to: {backgroundPositionY: -35}, d: 0.6, t: '-=0.3'},
				{el: '.el1_4', set: {backgroundPositionY: 0}, to: {backgroundPositionY: -111}, d: 0.6},
			],
			[
				{el: '.el2_1', set: {opacity: 0, y: -50}, to: {opacity: 1, y: 0}, d: 0.6},
				{el: '.el2_2', set: {opacity: 0, y: -20}, to: {opacity: 1, y: 0}, d: 0.2, t: '-=0.2'},
			],
			[
				{el: '.el3_0', set: {opacity: 0}, to: {opacity: 1}, d: 0.6},
				{el: '.el3_num1', set: {backgroundPositionY: "0%"}, to: {backgroundPositionY: "89.8%"}, d: 0.4},
				{el: '.el3_num2', set: {backgroundPositionY: "0%"}, to: {backgroundPositionY: "81.6%"}, d: 0.4},
				{el: '.el3_num3', set: {backgroundPositionY: "0%"}, to: {backgroundPositionY: "89.8%"}, d: 0.4, t:'+=0.2'},
				{el: '.el3_num4', set: {backgroundPositionY: "0%"}, to: {backgroundPositionY: "87.75%"}, d: 0.4},
				{el: '.el3_num5', set: {backgroundPositionY: "0%"}, to: {backgroundPositionY: "81.6%"}, d: 0.4},
				{el: '.el3_num6', set: {backgroundPositionY: "0%"}, to: {backgroundPositionY: "85.7%"}, d: 0.4, t:'+=0.2'},
				{el: '.el3_num7', set: {backgroundPositionY: "0%"}, to: {backgroundPositionY: "87.75%"}, d: 0.4},
				{el: '.el3_num8', set: {backgroundPositionY: "0%"}, to: {backgroundPositionY: "81.6%"}, d: 0.4},
			],
			[
				{el: '.el4_2', set: {opacity: 0}, to: {opacity: 1}, d: 0.6},
				{el: '.el4_3', set: {opacity: 0}, to: {opacity: 1}, d: 0.6},
				{el: '.el4_4', set: {opacity: 0}, to: {opacity: 1}, d: 0.6},
				{el: '.el4_1', set: {opacity: 0}, to: {opacity: 1, repeat: -1, repeatDelay: 0.3, yoyo: true}, d: 0.1}
			],
			[
				{method: 'call', fx: function() {
					boxloop(0);
					// setInterval(function() {
				    //     boxloop(0);
				    // }, 10000);
				}, t: '+=5'},
			],
		]).activate();

		TweenMax.to($('.el2_3'), 0.7, {opacity: 0, yoyo: true, repeat: -1, repeatDelay: 1});
		TweenMax.to($('.el2_4'), 0.8, {opacity: 0, yoyo: true, repeat: -1, repeatDelay: 1});
		TweenMax.to($('.el2_5'), 0.9, {opacity: 0, yoyo: true, repeat: -1, repeatDelay: 1});
		TweenMax.to($('.el2_6'), 1.0, {opacity: 0, yoyo: true, repeat: -1, repeatDelay: 1});

        new FlowSlider($('.bnr_flow.swiper-container'), {
            pps: 50,
            stopOver:false,
        });
		(function() {
			var $headElems = $('.if_sprite_img'),
				diff = 640, //각 섹션 높이값
				length = 16; //섹션 갯수

			var tl = new TimelineMax({repeat: -1});

			for(var i=0, t=0; i<length; i++) {
				tl.set($headElems, {top: diff * i * -1 + 'px'}, t);
				if(i > 0) t = '+=0.09';
			}
		}());
		var custPging = $('.if_paging li');
		new Swiper('.if_slide .swiper-container', {
		    setWrapperSize: true,
		    speed: 500,
		        autoplay: {
		        delay: 5000,
		    },
			effect: 'fade',
			fadeEffect: {
				crossFade: true
			},
		    pagination: {
		    	el: '.if_paging',
		    	type: 'bullets',
		    	clickable: true,
		    	renderBullet: function(index, className){
		    		return '<li class="' + className + '">'+ custPging.eq(index).html() +'</li>';
		    	}
		    },
		});
		new Swiper('.rprt_slide .swiper-container', {
		    slidesPerView: 'auto',
		    loop:true,
			centeredSlides: true,
			spaceBetween: 30,
		    speed: 500,
		        autoplay: {
		        delay: 3000,
		    },
		    navigation: {
		        nextEl: '.rprt_btns.rprt_next',
		        prevEl: '.rprt_btns.rprt_prev',
		    }
		});
		// var counter = new Counting($('.nums_wrap > .num'), {
		// 	type: 'img',
		// 	duration: 50,
        //     // diff: 10,
		// 	unit: 50%,
		// 	delay: 100,
		// 	loop: 4,
		// 	slowFx: true,
		// 	slowV: 4,
		// 	anim: true
		// });
		// counter.play();
		new Swiper('.story_slide .swiper-container', {
		    slidesPerView: 'auto',
		    loop:true,
			centeredSlides: true,
			spaceBetween: 217,
		    speed: 500,
		        autoplay: {
		        delay: 3000,
		    },
		    navigation: {
		        nextEl: '.story_btns.story_next',
		        prevEl: '.story_btns.story_prev',
		    }
		});
    });
}(jQuery));