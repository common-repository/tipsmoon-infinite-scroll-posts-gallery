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

//if you are using in header jquery then start
//jQuery(document).ready(function( $ )

//if you are using jquery in footer start function like this



function load_my_ajax2(id, v2, v3){
	
	
	var post_id=id;
	var v2a=v2;
	var v3a=v3;
	jQuery("#loading_ajax").show();
	jQuery.ajax({
				url: my_ajax_url.ajaxurl ,
				type:'post',
				data: { action:'tipsmoon_scroll_ajax',
			   off_id : post_id,
			   cat_in: v2a,
			   post_not_in: v3a,
			   cache:false
			   			  
				},
				success:function(response) {
					jQuery('#zero1').append(response);	
					 
									
				//jQuery('#zero1').append(response);	
				//jQuery('#ajax_response').html(response);	
				},
				 complete: function(){
     jQuery("#loading_ajax").hide();
      }
				})
	
	// alert("You clicked!")
	
};

  
  
(function($) { 
  
  $(".button").hover(function(){
        $(this).css("background-color", "#CCCCCC");
        }, function(){
        $(this).css("background-color", "");
    }); 

 $(".slider").slider();
 
  
  
  
							
})( jQuery ); //for footer use "( jQuery )" at the end

