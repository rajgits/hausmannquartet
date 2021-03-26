// close photo preview block
function closePhotoPreview() {
    $('#photo_preview').hide();
    $('#photo_preview .pleft').html('empty');
    $('#photo_preview .pright').html('empty');
};

// display photo preview block
/*function getPhotoPreviewAjx(id) {
	
    $.post('photos_ajax.php', {action: 'get_info', id: id},
        function(data){
            $('#photo_preview .pleft').html(data.data1);
            $('#photo_preview .pright').html(data.data2);
            $('#photo_preview').show();
        }, "json"
    );
};*/


function getPhotoPreviewAjx(id) { 
					$.ajax({
							type: 'POST', 
							url: 'photos_ajax.php',
                            data:{"action":"get_info","id": id}, 

                            dataType: 'JSON',

                            beforeSend: function()

                            {
								//document.getElementById("oading-image").innerHTML="Posting";
								 $('#loading').show(); 

                              

                            },

                            success: function(data)
							{
                            	console.log(data); 

                                if (data)
								{
									 $('#photo_preview .pleft').html(data.data1);
							         $('#photo_preview .pright').html(data.data2);
							          $('#loading').hide(); 
							          
							         $('#photo_preview').show();
							         

                                }

                            }

                        });
                } 







// submit comment
/*function submitComment(id) {
  
    var sText = $('#text').val();

    if (sText) {
        $.post('comments.php', { action: 'accept_comment', comments: sText }, 
            function(data){ 
            console.log(data);  
           
                if (data != '1') {
                	console.log(data); 
                    $('#comments_list').fadeOut(1000, function () { 
                        $(this).html(data);
                        $(this).fadeIn(1000); 
                    }); 
                } else {
                    $('#comments_warning2').fadeIn(1000, function () { 
                        $(this).fadeOut(1000); 
                    }); 
                }
            }
        );
    } else {
        $('#comments_warning1').fadeIn(1000, function () { 
            $(this).fadeOut(1000); 
        }); 
    }
};*/


function submitComment(pid) { 

	console.log(pid);
	
  var sText = $('#text').val();
   					
   					$.ajax({
							
                            type: 'POST', 

                            url: 'comments.php',
                            action: 'accept_comment', 
                             data:{"action":"accept_comment","comments":sText,"post_id":pid}, 

                            //dataType: 'JSON',

                            beforeSend: function()

                            {
								document.getElementById("popsubmit_coment").innerHTML="Posting";

                              

                            },

                            success: function(data)

                            {
                            	console.log(data); 

                                if (data)
								{
									//	console.log(data); 
				                    	$('#comments_list').fadeOut(1000, function () { 
				                    	document.getElementById("text").value = "";
				                    	document.getElementById("popsubmit_coment").innerHTML="Post";
				                        $(this).html(data);
				                        $(this).fadeIn(1000); 
				                    }); 

                                }

                               

                            }

                        });


        }




// init
$(function(){ 
	


    $('#photo_preview .photo_wrp').click(function (event) {
    	
        //vent.preventDefault();

        //return false;
    });
    
    $('#photo_preview .close-sr').click(function (event) { 
        closePhotoPreview();
    });
    
    
    
   

    
    // display photo preview ajaxy
    $('.gallery .port img').click(function (event) {
        if (event.preventDefault) event.preventDefault();
//getPhotoPreviewAjx
 if (event.preventDefault) event.preventDefault();

        getPhotoPreviewAjx($(this).attr('id'));
    });
})