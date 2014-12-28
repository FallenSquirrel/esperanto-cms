var Form = function(router, templating, admin, translator)
{
  var self = this;

  var MessageType = {
    Info: 'info',
    Error: 'error',
    Success: 'success'
  };

  this.initDataPicker = function(form)
  {
    $(form).find('input.datetimepicker').datetimepicker({
      timeFormat: 'hh:mm',
      timeText: 'Zeit',
      hourText: 'Std.',
      minuteText: 'Min.',
      currentText: 'Jetzt',
      closeText: 'Fertig',
      dateFormat: 'dd.mm.yy',
      stepMinute: 10
    });
  };

  this.initRadioAndCheckbox = function (form) {
    $(form).find('input[type=radio],input[type=checkbox]').iCheck({
      checkboxClass: 'icheckbox-esperanto',
      radioClass: 'icheckbox-esperanto'
    });
  };

  this.initSelect = function (form) {
    $(form).find('select').select2();
  };

  this.destroyWysiwyg = function(content) {
    content.find('.wysiwyg').each(function() {
      tinymce.remove('#'.$(this).attr('id'));
    });
  };

  this.initWysiwyg = function(form)
  {
    var addTinymce = function(element) {
      var bodyHeight = 300;
      if(typeof $(element).attr("height") != "undefined") {
        bodyHeight = $(this).attr("height");
      }
      $(element).tinymce({
        // Location of TinyMCE script
        script_url : '/js/lib/tinymce/tinymce.min.js',
//        content_css: "/css/editor.css",
        menubar: false,
        // General options
        plugins: ["advlist autolink lists link image charmap print preview anchor",
          "searchreplace visualblocks code fullscreen",
          "insertdatetime media table contextmenu paste"],
        // Theme options
        toolbar1: "undo redo | bold italic underline strikethrough subscript superscript removeformat | link",
        toolbar2: "table | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code",
        force_br_newlines : true,
        force_p_newlines : false,
        forced_root_block : "",
        cleanup : false,
        cleanup_on_startup : false,
        font_size_style_values : "xx-small,x-small,small,medium,large,x-large,xx-large",
        convert_fonts_to_spans : true,
        height : bodyHeight,
        relative_urls : false,
        oninit: function(ed) {
          $(ed.contentAreaContainer).droppable({
            accept: ".imgList li.imgContainer",
            drop: function(event, ui) {
              var draggedImg = ui.draggable.find("img");
              var src = '';
              if(typeof draggedImg.attr("largesrc") == "undefined") {
                src = draggedImg.attr("src")
              } else {
                src = draggedImg.attr("largesrc");
              }
              ed.execCommand('mceInsertContent', false, "<img src=\""+src+"\" />");
            }
          });
        }
      });
    };

    $(form).find('.wysiwyg').each(function(index, element) {
      addTinymce(element);
    });
  };

  this.initSave = function (form) {
    $(form).find('.save').click(function() {
      $(this).trigger('formSaveBefore', form);

      form = $(form);
      var data = form.serialize();
      var action = form.attr('action');
      $.ajax({
        type: 'POST',
        data: data,
        url: action,
        success: function(data) {
          $(form).trigger('formSaveAfter', form);
        },
        error: function(jqXHR) {
          var data = JSON.parse(jqXHR.responseText);

          if(data.code == 400) {
            var getErrors = function(data, errors) {
              if(typeof errors == 'undefined') {
                errors = [];
              }

              for (var key in data) {
                if(data.hasOwnProperty(key)) {

                  if(key == 'errors') {
                    for (var error in data[key]) {
                      if (data[key].hasOwnProperty(error) && typeof data[key][error] == 'string') {
                        errors.push(data[key][error]);
                      }
                    }
                  }

                  if (typeof data[key] == 'object') {
                    getErrors(data[key], errors);
                  }

                }
              }

              return errors
            };

            var errors = getErrors(data.errors);
            var message = '<b>' + errors.join('<br /><br />') + '</b>';
            admin.overlayMessage(message, MessageType.Error);
          } else {
            admin.overlayMessage(translator.trans('error.occurred'), MessageType.Error);
          }
        }
      });
    });
  };

  this.initPreviewButton = function(form) {
    $('.btn.preview',form).on('click',function(e) {
      e.preventDefault();
      e.stopPropagation();
      var link = $(form).data('preview-url');
      admin.iframeOverlay(form,link,{
        submit: true
      });
    });
  };

  this.initDelete = function(form)
  {
    $(form).find('.delete').click(function() {
      var url = $(form).data('delete-url');
      if(confirm(translator.trans('form.delete.question'))) {
        $.ajax({
          type: 'POST',
          data: {
            _method: 'DELETE'
          },
          url: url,
          success: function() {
            $(form).trigger('formSaveAfter', form);
          },
          error: function() {
            alert(translator.trans('error.occurred'));
          }
        });
      }
    });
  };

  var init = function() {
    $(document).on('formOpenAfter', function(event, form) {
      self.initDataPicker(form);
      self.initRadioAndCheckbox(form);
      self.initPreviewButton(form);
      self.initWysiwyg(form);
      self.initSave(form);
      self.initDelete(form);
      self.initSelect(form);
    });

    $(document).on('formCloseAfter', function(event, content) {
      self.destroyWysiwyg(content);
    });
  };

  init();
};