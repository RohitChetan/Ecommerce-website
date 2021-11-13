
<title>Rc Brand Slider: Responsive Logo Carousel Examples</title>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery.rcbrand.js"></script>
<style>
    
/*www.oguzhansengul.com*/
    #rcbrandDemo1, #rcbrandDemo2, #rcbrandDemo3 {
    display:none;
    }
    
    .rc-rcbrand-demo {
        position:relative;
        margin-bottom: 20px;
    }
    .rc-rcbrand-ul {
        position:relative;
        width:100%x;
        margin:0px;
        padding:0px;
        list-style-type:none;   
        text-align:center;  
        overflow: auto;
    }
    
    .rc-rcbrand-inner {
        position: relative;
        overflow: hidden;
        float:left;
        width:100%;
        background: #ffffff;;
        border:1px solid #ccc;
        border-radius:5px;
        -moz-border-radius:5px;
        -webkit-border-radius:5px;  
    }
    
    .rc-rcbrand-item {
        float:left;
        margin:0px;
        padding:0px;
        cursor:pointer;
        position:relative;
        line-height:0px;
    }
    .rc-rcbrand-item img {
        max-width: 100%;
        cursor: pointer;
        position: relative;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    
    .rc-rcbrand-nav-left,
    .rc-rcbrand-nav-right {
        padding:5px 10px;
        border-radius:50%;    
        position: absolute;
        cursor: pointer;
        z-index: 4;
        top: 50%;
        transform: translateY(-50%);   
        background: rgb(255, 102, 0, 0.5);
        color: #fff;     
    }
    
    .rc-rcbrand-nav-left {
        left: 10px;
    }
    
    .rc-rcbrand-nav-left:before {
        content: "<"
    }
    
    .rc-rcbrand-nav-left.disabled {
        opacity: 0.4;
    }
    
    .rc-rcbrand-nav-right {
        right: 5px;    
    }
    
    .rc-rcbrand-nav-right:before {
        content: ">"
    }
    
    .rc-rcbrand-nav-right.disabled {
        opacity: 0.4;
    }
</style>


   
        <ul id="rcbrand2">
            <li><img src="images/wordpress.png" /></li>
            <li><img src="images/html5.png" /></li>
            <li><img src="images/css3.png" /></li>
            <li><img src="images/windows.png" /></li>
            <li><img src="images/jquery.png" /></li>
            <li><img src="images/js.png" /></li>
        </ul>
    
<script type="text/javascript">

$(window).load(function() {

    
    $("#rcbrand2").rcbrand({
        visibleItems: 3,
        itemsToScroll: 1,
        autoPlay: {
            enable: true,
            interval: 3000,
            pauseOnHover: true
        }
    });

    $("#rcbrand3").rcbrand({
        infinite: false
    });

});


/*www.oguzhansengul.com*/
(function ($) {

    $.fn.rcbrand = function (options) {

        var defaults = $.extend({
            visibleItems: 4,
            itemsToScroll: 3,
            animationSpeed: 400,
            infinite: true,
            navigationTargetSelector: null,
            autoPlay: {
                enable: false,
                interval: 5000,
                pauseOnHover: true
            },
            responsiveBreakpoints: { 
                portrait: { 
                    changePoint:480,
                    visibleItems: 1,
                    itemsToScroll: 1
                }, 
                landscape: { 
                    changePoint:640,
                    visibleItems: 2,
                    itemsToScroll: 2
                },
                tablet: { 
                    changePoint:768,
                    visibleItems: 3,
                    itemsToScroll: 3
                }
            },
            loaded: function(){ },
            before: function(){ },
            after: function(){ },
            resize: function(){ }
        }, options);
               
        
        var object = $(this);
        var settings = $.extend(defaults, options);        
        var itemsWidth;
        var canNavigate = true; 
        var itemCount; 
        var itemsVisible = settings.visibleItems; 
        var itemsToScroll = settings.itemsToScroll;
        var responsivePoints = [];
        var resizeTimeout;
        var autoPlayInterval;        
          
        
        var methods = {
                
            init: function() {
                return this.each(function () {
                    methods.appendHTML();
                    methods.setEventHandlers();                  
                    methods.initializeItems();                    
                });
            },           
            
            initializeItems: function() {
                
                var obj = settings.responsiveBreakpoints;
                for(var i in obj) { responsivePoints.push(obj[i]); }
                responsivePoints.sort(function(a, b) { return a.changePoint - b.changePoint; });
                var childSet = object.children();
                childSet.first().addClass("index");
                itemsWidth = methods.getCurrentItemWidth();
                itemCount = childSet.length;
                childSet.width(itemsWidth);
                if(settings.infinite) {
                    methods.offsetItemsToBeginning(Math.floor(childSet.length / 2)); 
                    object.css({
                        'left': -itemsWidth * Math.floor(childSet.length / 2)
                    }); 
                }
                $(window).trigger('resize');              
                object.fadeIn();
                settings.loaded.call(this, object);
                
            },          
            
            appendHTML: function() {
                
                object.addClass("rc-rcbrand-ul");
                object.wrap("<div class='rc-rcbrand-demo'><div class='rc-rcbrand-inner'></div></div>");
                object.find("li").addClass("rc-rcbrand-item");
                
                if(settings.navigationTargetSelector && $(settings.navigationTargetSelector).length > 0) {
                    $("<div class='rc-rcbrand-nav-left'></div><div class='rc-rcbrand-nav-right'></div>").appendTo(settings.navigationTargetSelector);
                } else {
                    settings.navigationTargetSelector = object.parent();
                    $("<div class='rc-rcbrand-nav-left'></div><div class='rc-rcbrand-nav-right'></div>").insertAfter(object);    
                }
                    
                if(settings.infinite) {    
                    var childSet = object.children();
                    var cloneContentBefore = childSet.clone();
                    var cloneContentAfter = childSet.clone();
                    object.prepend(cloneContentBefore);
                    object.append(cloneContentAfter);
                }
                
            },
            setEventHandlers: function() {
                var self = this;
                var childSet = object.children();
                
                $(window).on("resize", function(event){
                    canNavigate = false;
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(function(){
                        canNavigate = true;
                        methods.calculateDisplay();
                        itemsWidth = methods.getCurrentItemWidth();
                        childSet.width(itemsWidth);
                        
                        if(settings.infinite) {
                            object.css({
                                'left': -itemsWidth * Math.floor(childSet.length / 2)
                            });        
                        } else {
                            methods.clearDisabled();
                            $(settings.navigationTargetSelector).find(".rc-rcbrand-nav-left").addClass('disabled');
                            object.css({
                                'left': 0
                            });
                        }
                        
                        settings.resize.call(self, object);

                    }, 100);
                    
                });                    
                
                $(settings.navigationTargetSelector).find(".rc-rcbrand-nav-left").on("click", function (event) {
                    methods.scroll(true);
                });
                
                $(settings.navigationTargetSelector).find(".rc-rcbrand-nav-right").on("click", function (event) {
                    methods.scroll(false);
                });
                
                if(settings.autoPlay.enable) {

                    methods.setAutoplayInterval();

                    if (settings.autoPlay.pauseOnHover === true) {
                        object.on({
                            mouseenter : function() {
                                canNavigate = false;
                            },
                            mouseleave : function() {
                                canNavigate = true;
                            }
                        });        
                    }            
                    
                }
                
                object[0].addEventListener('touchstart', methods.touchHandler.handleTouchStart, false);        
                object[0].addEventListener('touchmove', methods.touchHandler.handleTouchMove, false);                
                
            },                 
            
            calculateDisplay: function() {
                var contentWidth = $('html').width();
                var largestCustom = responsivePoints[responsivePoints.length-1].changePoint; 
                
                for(var i in responsivePoints) {
                    
                    if(contentWidth >= largestCustom) { 
                        itemsVisible = settings.visibleItems;
                        itemsToScroll = settings.itemsToScroll;
                        break;
                    }
                    else { 
                    
                        if(contentWidth < responsivePoints[i].changePoint) {
                            itemsVisible = responsivePoints[i].visibleItems;
                            itemsToScroll = responsivePoints[i].itemsToScroll;
                            break;
                        }
                        else {
                            continue;
                        }
                    }
                }
                
            },                             
            
            scroll: function(reverse) {

                if(typeof reverse === 'undefined') { reverse = true }

                if(canNavigate == true) {
                    canNavigate = false;
                    settings.before.call(this, object);
                    itemsWidth = methods.getCurrentItemWidth();
                    
                    if(settings.autoPlay.enable) {
                        clearInterval(autoPlayInterval);
                    }
                    
                    if(!settings.infinite) {
                        
                        var scrollDistance = itemsWidth * itemsToScroll;
                        
                        if(reverse) {                            
                            object.animate({
                                'left': methods.calculateNonInfiniteLeftScroll(scrollDistance)
                            }, settings.animationSpeed, function(){
                                settings.after.call(this, object);
                                canNavigate = true;
                            });                            
                            
                        } else {
                            object.animate({
                                'left': methods.calculateNonInfiniteRightScroll(scrollDistance)
                            },settings.animationSpeed, function(){
                                settings.after.call(this, object);
                                canNavigate = true;
                            });                                    
                        }
                        
                        
                        
                    } else {                    
                        object.animate({
                            'left' : reverse ? "+=" + itemsWidth * itemsToScroll : "-=" + itemsWidth * itemsToScroll
                        }, settings.animationSpeed, function() {
                            settings.after.call(this, object);
                            canNavigate = true;
                            
                            if(reverse) { 
                                methods.offsetItemsToBeginning(itemsToScroll); 
                            } else {
                                methods.offsetItemsToEnd(itemsToScroll);
                            }
                            methods.offsetSliderPosition(reverse); 
                            
                        });
                    }
                    
                    if(settings.autoPlay.enable) {
                        methods.setAutoplayInterval();
                    }
                    
                }
            },
            
            touchHandler: {

                xDown: null,
                yDown: null,
                handleTouchStart: function(evt) {                                         
                    this.xDown = evt.touches[0].clientX;                                      
                    this.yDown = evt.touches[0].clientY;
                }, 
                handleTouchMove: function (evt) {
                    if (!this.xDown || !this.yDown) {
                        return;
                    }

                    var xUp = evt.touches[0].clientX;                                    
                    var yUp = evt.touches[0].clientY;

                    var xDiff = this.xDown - xUp;
                    var yDiff = this.yDown - yUp;
                    if (Math.abs( xDiff ) > 0) {
                        if ( xDiff > 0 ) {
                            methods.scroll(false);
                        } else {
                            methods.scroll(true);
                        }                       
                    }
                    this.xDown = null;
                    this.yDown = null;
                    canNavigate = true;
                }
            },            
            
            getCurrentItemWidth: function() {
                return (object.parent().width())/itemsVisible;
            },            
            
            offsetItemsToBeginning: function(number) {
                if(typeof number === 'undefined') { number = 1 }
                for(var i = 0; i < number; i++) {
                    object.children().last().insertBefore(object.children().first());
                }    
            },                
            
            offsetItemsToEnd: function(number) {
                if(typeof number === 'undefined') { number = 1 }
                for(var i = 0; i < number; i++) {
                    object.children().first().insertAfter(object.children().last());    
                }
            },            
            
            offsetSliderPosition: function(reverse) {
                var left = parseInt(object.css('left').replace('px', ''));
                if (reverse) { 
                    left = left - itemsWidth * itemsToScroll; 
                } else {
                    left = left + itemsWidth * itemsToScroll;
                }
                object.css({
                    'left': left
                });
            },

            getOffsetPosition: function() {
                return parseInt(object.css('left').replace('px', ''));    
            },
            
            calculateNonInfiniteLeftScroll: function(toScroll) {
                
                methods.clearDisabled();
                if(methods.getOffsetPosition() + toScroll >= 0) {
                    $(settings.navigationTargetSelector).find(".rc-rcbrand-nav-left").addClass('disabled');
                    return 0;
                } else {
                    return methods.getOffsetPosition() + toScroll;
                }
            },
            
            calculateNonInfiniteRightScroll: function(toScroll){
                
                methods.clearDisabled();
                var negativeOffsetLimit = (itemCount * itemsWidth) - (itemsVisible * itemsWidth);
                
                if(methods.getOffsetPosition() - toScroll <= -negativeOffsetLimit) {
                    $(settings.navigationTargetSelector).find(".rc-rcbrand-nav-right").addClass('disabled');
                    return -negativeOffsetLimit;        
                } else {
                    return methods.getOffsetPosition() - toScroll;
                }
            },
            
            setAutoplayInterval: function(){
                autoPlayInterval = setInterval(function() {
                    if (canNavigate) {
                        methods.scroll(false);
                    }
                }, settings.autoPlay.interval);                    
            },
            
            clearDisabled: function() {
                var parent = $(settings.navigationTargetSelector);
                parent.find(".rc-rcbrand-nav-left").removeClass('disabled');
                parent.find(".rc-rcbrand-nav-right").removeClass('disabled');
            }                        
            
        };

        if (methods[options]) {     
            return methods[options].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof options === 'object' || !options) {    
            return methods.init.apply(this);  
        } else {
            $.error(method);
        }        
};

})(jQuery);
</script>

