/*
Plugin Name: Tipsmoon Infinite Scroll Posts Gallery
Description: Add scroll gallery on home page or any page for all your posts via shortcode
Version: 1.0
Author: Ramzan Ullah
Author URI: http://www.tipsmoon.com
License: 

  This file is part of Tipsmoon Infinite Scroll Posts Gallery.

    Tipsmoon Infinite Scroll Posts Gallery is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Tipsmoon Infinite Scroll Posts Gallery is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Tipsmoon Infinite Scroll Posts Gallery.  If not, see <http://www.gnu.org/licenses/>.

*/

(function($) {

  $.fn.slider = function(options) {  
	  
	  
    var defaults = {duration: 2000,animationDelay: 2000};
	
		
    var settings = $.extend({}, defaults, options);

    return this.each(function() {
      // store some initial variables
      var $slider = $(this);
	  //un ordered list for holding the long chain of frames
     var $sliderList = $slider.children("ul");
	    // list items as frames
		var  $sliderItems = $sliderList.children("li");
		

     
	 
	  
      var $allButtons = $slider.find(".button");
	  var $buttonForward =$slider.find(".forward");
	  var $buttonBack =$slider.find(".back");
	  //button classes
      var $buttons = {forward: $allButtons.filter(".forward"), back: $allButtons.filter(".back")};
	  
	  	   	  
      var $index = $(".index");
	  //getting the width of the first/single item from list items e.g. image
      //var imageWidth = $sliderItems.first().children("img").width();
	  var imageWidth = $sliderItems.first().width();
	  // number of li/img in ul
      var totalImages = $sliderItems.length;
	   var endMargin = -((totalImages - 1) * imageWidth);
	   var offsetCount=4;
	  $("body").on("domChanged", function () {
             totalImages = totalImages+1;
			 endMargin = -((totalImages - 1) * imageWidth);
			 offsetCount=offsetCount+1;
            });
	  //width of total items in list leaving last one (-1)
     
      
	   
	  
      var currentIndex = 1;
      var isPaused = false;



      var animateSlider = function(direction, callback) {
		  
                                                          $sliderList.stop(true, true).animate({
                                                                  "margin-left" : direction + "=" + imageWidth
                                                                  }, settings.duration, function() {
			
			                                                                          var increment = (direction === "+" ? -1 : 1);
                                                                                      updateIndex(currentIndex + increment);
		  		  
                                                            if(callback && typeof callback == "function") {
                                                                                                      //   callback();
                                                                                                          }
		                                                                                               });
                                                          };







      var animateSliderToMargin = function(margin, callback) {
        $sliderList.stop(true, true).animate({
          "margin-left": margin
        }, settings.duration, callback);
      };






      var getLeftMargin = function() {
        return parseInt($sliderList.css("margin-left"), 10);
      };







      var isAtBeginning = function() {
        return getLeftMargin() >= 0;
      };






      var isAtEnd = function() {
        return getLeftMargin() <= endMargin;
      };








      var updateIndex = function(newIndex) {
        currentIndex = newIndex;
        $index.text(currentIndex);
		
      };





//this part of function control the button behaviour at the end of slider and at begining

      var triggerSlider = function(direction, callback) {
                                 var isBackButton = (direction === "+");
		                            if(!isBackButton && isAtEnd()) {
                                          animateSliderToMargin(0, callback);
                                          updateIndex(1);
                               } else if(isBackButton && isAtBeginning()) {
                                               //     animateSliderToMargin(endMargin, callback);
                                                 //    updateIndex(totalImages);
                                               } else {
                                                        animateSlider(direction, callback);
                                                       }
                                                    };

        //function for autmatic call back to repeat slider
      var automaticSlide = function() {
                                    timer = setTimeout(function() {}, settings.animationDelay);
                                                                };
	  
	
	  
	  
      var timer = setTimeout(automaticSlide, settings.animationDelay);

      var resetTimer = function() {
                                  if(timer) {
                                          clearTimeout(timer);
                                            }
                                            timer = setTimeout(automaticSlide, 30000);
       
	      
	   }


		
      


       


      $buttonBack.on("click", function(event) {
                                            resetTimer();
                                            var isBackButton = $(this).hasClass("back");
                                             triggerSlider((isBackButton? "+" : "-"));
											// var index2=$index.text();
											// load_my_ajax2(currentIndex);
											 event.preventDefault();
                                               });


$buttonForward.on("click", function(event) {
                                            resetTimer();
                                            var isBackButton = $(this).hasClass("back");
                                             triggerSlider((isBackButton? "+" : "-"));
											// var index2=$index.text();
											 $("body").trigger("domChanged");
											 load_my_ajax2((offsetCount), categ_id, post_array_id);
											 event.preventDefault();
                                               });
                                              

	  
	  
    });
	







  }
 
  
})(jQuery);
