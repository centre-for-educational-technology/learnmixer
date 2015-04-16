(function($) {
  Drupal.behaviors.lm_collection_editor = {
    attach: function(context, settings) {
      function lmCollectionEditorAttachListeners(elem) {
        elem.find('.add-new-textblock').on('click', function(event){
          // var textblock = $('.lm-textblock-to-clone').clone();
          // textblock.removeAttr('style');
          // textblock.removeClass('lm-hide-textblock');

          // textblock.attr('id', 'testid');

          var structelem = $(this).data('structelem');
          var collection = $(this).data('collection');
          $.ajax({
            url: Drupal.settings.basePath + Drupal.settings.pathPrefix + 'collection/add/textblock/'+structelem+'/'+collection,
            type: 'POST',
            dataType: 'json',
            cache: false,
            success: function(response){
              var textblock = response;

              $('.new-mct-in-chapter').append(textblock);
              CKEDITOR.replace('textarea-id-to-ck', {
                toolbar :
                  [
                    { name: 'basicstyles', items : [ 'Bold','Italic', 'Underline' ] },
                    { name: 'paragraph', items : [ 'NumberedList','BulletedList' ] },
                  ]
              });
            }
          });
        });
      }

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
          $('.submit-structure-elem').css('display', 'block');
          // võibolla chapteri ja kollektsiooni alla lisamiseks erinevad endpointid.

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
              if(response.success){
                $('.popover-markup>.trigger').popover('toggle');

                $('.collection-new-elements').css('display', 'block');

                var tmp = $(response.html);
                lmCollectionEditorAttachListeners(tmp);

                $('.collection-new-elements').append(tmp);
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
