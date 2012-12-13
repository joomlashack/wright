if (typeof jQuery != 'undefined' && typeof MooTools != 'undefined' ) { 
// both present , kill jquery slide for carousel class
(function($) { 
       $(document).ready(function(){
        $('.carousel').each(function(index, element) {
                $(this)[index].slide = null;
               });
         });
 })(jQuery);
}