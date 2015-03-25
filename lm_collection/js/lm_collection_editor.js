(function($) {
  Drupal.behaviors.lm_collection_editor = {
    attach: function(context, settings) {
      $('.popover-markup>.trigger').popover({

        html: true,
        title: function (){
          return $(this).parent().find('.head').html();
        },
        content: function (){
          return $(this).parent().find('.content').html();
        }
      });

      $('.popover-markup').on({
        click: function(){
          var collection = $(this).parent().find(':input').data('collection');
          var value = $(this).parent().find(':input').val();
          $.ajax({
            url: Drupal.settings.basePath + Drupal.settings.pathPrefix + 'collection/add/structelem/'+collection+'/'+collection,
            type: 'POST',
            dataType: 'json',
            data: {
              'structelemTitle': value
            },
            cache: false,
            success: function(response){
              console.log(response);
              if(response.success){

//@todo - Toolbox for adding microcontent. Decent bootstrap HTML. (panels etc).

                $('.popover-markup>.trigger').popover('hide');
                $('.collection-new-elements').css('display', 'block');
                $('.collection-new-elements').append('<h4>'+value+'</h4>');
              }else{
                alert('Something went wrong');
              }

            }

          });
        }
      },'.submit-structure-elem');

      // $('.add-structure-elem').on('click', function(){

      //   if($(this).data('first')==true) {

      //   }
      // });
    }
  }
})(jQuery);
