$(document).ready(function(){
    
    // ================================================================= 
        var placeholderAttr = '';
        $('[placeholder]').focus( function(){
            placeholderAttr = $(this).attr('placeholder');
            $(this).attr('placeholder', '');

        }).blur(function(){
            $(this).attr('placeholder', placeholderAttr);
        });

    // =================================================================
     $('.login-btn').mouseenter(function(){
        $(this).css("background","#273c75");
        
     }).mouseleave(function(){
        $(this).css("background","rgb(19, 34, 78)"); 
        
    });

   // =================================================================
    
     $('form').slideDown(1050);
     $('.log,.sign ,h2').slideDown(1000);

   // =================================================================
    $('.carousel').carousel();
    $('.carousel').carousel({
        interval: 6000
    });

   // =================================================================
    
     
 
 
 
 
 
 
 
 
 
 
    // =================================================================
   
});