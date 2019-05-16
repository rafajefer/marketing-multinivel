$(document).ready(function(){
   
   /*
   $elementos = $("span[data-user-id]");
   foreach($elementos as $e) {
      
      alert($("span[data-user-id]").attr('data-user-id'));
   }
    * */
   
   $("td span[data-user-id]").each(function(){
      var user_qtde = $(this).text();
      var user_id = $(this).attr('data-user-id');
      
      if(user_qtde > 0) {
         $('span[data-user-id='+user_id+']').bind('click', function(){
           //$('tr.user-filhos').toggleClass("d-none");
           //$(this).parent().parent().addClass("bg-dark");
           var elementoClicado = $(this).attr("data-user-id");
           var elementosFilhos = $("tr[data-user-filho-id]").attr("data-user-filho-id");
           alert(elementoClicado+"="+elementosFilhos);
           if(elementoClicado == elementosFilhos) {
              
            $("tr[data-user-filho-id]").toggleClass("d-none");
           }
         });
      }
      
   });
    
});