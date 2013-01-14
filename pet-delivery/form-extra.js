// extra javascript for form processing
jQuery(document).ready(function($) {
		$( ".dog_size .gfield_radio" ).selectable({
    	selected: function( event, ui ) {
			$(this).find("input").attr('checked', false); //remove previously checked items
			$(this).find("li.ui-selected input").attr('checked', true);
		}
	});

		$("li.gchoice_3_0 input").attr('checked', true);
		$sliderValue="";
		$( "#dog_age" ).slider({
			value:0,
			min: 100,
			max: 400,
			step: 100,
			slide: function( event, ui ) {	
			//$( "#amount" ).val( ui.value );	this field has been commented out of the gravity form 
			},
			stop: function(event, ui) {
            	//console.log(ui.value);
                $sliderValue=ui.value;
				$(".dog_age").find("input").attr('checked', false);
				switch ($sliderValue)
				{
				case 200:
 				  	//var dog_age = "Young";
				  	$("li.gchoice_3_1 input").attr('checked', true);		
				  	break;
				case 300:
 				  	//var dog_age = "Adult";
					$("li.gchoice_3_2 input").attr('checked', true);		
 		 		  	break;
				case 400:
 				  	//var dog_age = "Ol' Timer";	
					$("li.gchoice_3_3 input").attr('checked', true);		
  		 		  	break;
				default:  // slider default
				  	//var dog_age = "Puppy";
				  	$("li.gchoice_3_0 input").attr('checked', true);	
				  	break;
				} 
				//console.log(dog_age);

           }
		});
	
		$("li.gchoice_4_0 input").attr('checked', true);
		$( "#dog_gender" ).slider({
			value:0,
			min: 100,
			max: 200,
			step: 100,
			slide: function( event, ui ) {	
			},
			stop: function(event, ui) {
                $sliderValue=ui.value;
				$(".gender").find("input").attr('checked', false);
				if ($sliderValue == 200) {
					var dog_gender = "Male";
				  	$("li.gchoice_4_1 input").attr('checked', true);		
				} 
				else { //slider default
				  	var dog_gender = "Female";
				  	$("li.gchoice_4_0 input").attr('checked', true);	
				}
			}
		});
	});