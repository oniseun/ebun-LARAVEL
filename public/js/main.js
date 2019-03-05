function open_dialog(pageURL, title, w, h)
{
  var left = (screen.width - w) / 2;
  var top = (screen.height - h) / 4;
  var targetWin = window.open(pageURL, title,
    'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' +
     w + ', height=' + h + ', top=' + top + ', left=' + left);
}

function xloader(href,container,loading_text)
{
  container = $(container);
  var return_data ;
  $.ajax({
               url: href,
               dataType: "text",
               beforeSend: function()
               {
                 container.html(loading_text);
               } ,
              success:function(data)
                {
                  container.html(data);
                },
              error:function()
              {
                container.html(
                '<div class="alert alert-danger"><span class="alert-close">&times;</span>\n\
                 <b>internal error:</b>Please check your internet connection and try again</div>');
              }

          });

  }

function search_data($form,return_data_container,loading_text)
{
   $form.ajaxSubmit( {

        data: $form.serialize,
        beforeSend: function()
        {
          $(return_data_container).html(loading_text);
        } ,
        complete: function(){} ,
        success: function(data)
        {
          $(return_data_container).html(data);
        } ,
        error: function()
        {
            $(return_data_container).html(
            '<div class="alert alert-danger"><span class="alert-close">&times;</span>\n\
             <b>internal error:</b>Please check your internet connection and try again</div>');
         }

        });

}

function load_next_data(get_url, list_container, button_wrapper_to_remove, loading_text){


  $.ajax({
               url: get_url,
               dataType: "text",
               beforeSend: function()
               {
                 button_wrapper_to_remove.html(loading_text);
               },
              success:function(data)
                {
                  button_wrapper_to_remove.remove();
                  list_container.append(data);
                },
              error:function()
              {
                list_container.append(
                '<div class="alert alert-danger"><span class="alert-close">&times;</span>\n\
                 <b>internal error:</b>Please check your internet connection and try again</div>');
              }

          });
      };

$(function()
{
  // open dialog
  $("body").on('click','[open-dialog-url]',
  function(e)
  {
    e.preventDefault();
      var url = $(this).attr('open-dialog-url');
      var height = $(this).attr('dialog-height');
      var width = $(this).attr('dialog-width');

      open_dialog(url, url, width, height);
  });

});


function reset_form(form_object)
{
  //form_object[0].reset();
  form_object.trigger("reset");
}

 function  send_form_data(form_object, return_container,load_selector)
 {
        form_object.ajaxSubmit({

                       data: form_object.serialize,

                       beforeSend: function()
                                  {
                                     form_object.find(return_container).html(load_selector);
                                   },
                       complete:function(){ },
                       success:function(data)
                              {
                                form_object.find(return_container).html(data);


                               // reset
                               if(form_object.hasClass('reset-on-success') && form_object.find(' .alert-success').length > 0)
                               {
                                       reset_form(form_object);
                                }

                              },

                       error:function()
                              {
                                   //
                                   form_object.find(return_container).html(
                                   '<div class="alert alert-danger"><span class="alert-close">&times;</span>\n\
                                    <b>internal error:</b>Please check your internet connection and try again</div>');
                               }

                      });


 }
