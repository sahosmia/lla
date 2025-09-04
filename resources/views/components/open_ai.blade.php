@php
    if(!empty(auth()?->user()?->profile->image) && Storage::disk(getStorageDisk())->exists(auth()?->user()?->profile?->image)) {
        $userImage = resizedImage(auth()?->user()?->profile?->image, 36, 36);
    } else {
        $userImage = resizedImage('placeholder.png', 36, 36);
    }
@endphp
<div class="modal fade am-aichat_popup" id="aiModal" tabindex="-1" role="dialog" aria-labelledby="aiModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="workreap-aicontent-profile_content-72ModalLabel">
            <img src="{{ asset('images/ai-icon.svg') }}" alt="OpenAI">
            {{ __('general.write_with_ai') }}
        </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="am-icon-multiply-02"></i></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="am-aichat">
          <ul class="am-aichat_list">
            <li class="am-ai_empty">
              <figure class="am-ai_empty_img">
                <img src="{{ asset('images/ai-icon.svg') }}" alt="OpenAI">
              </figure>
              <p>{{ __('general.write_with_ai') }}</p>
            </li>
          </ul>
          <div class="am-aichat_input">
            <input type="text" placeholder="{{ __('general.ai_input_placeholder') }}" class="form-control" id="ai-user-input">
            <button type="button" class="btn btn-primary am-aibtn_request am-aidisabled"><i class="am-icon-send-04"></i></button>
          </div>
        </div>
    </div>
  </div>
</div>

<script>
jQuery(document).ready(function() {
    var targetSelector;
    var isSummernote;
    var parentModelId;
    let aiLoaderTemplate = `<li class="am-ai_loader"><div class="am-ai-reply">
                <figure class="am-ai-reply_avatar">
                    <img src="{{ asset('images/ai-icon.svg') }}" alt="AI Response">
                </figure>
                <div class="am-ai-reply_content">
                    <span class="am-ai-typing-animation">
                        <span class="am-ai-dot"></span>
                        <span class="am-ai-dot"></span>
                        <span class="am-ai-dot"></span>
                    </span>
                  </div>
            </div></li>`;      
    jQuery(document).on('keyup', '#ai-user-input', function(e) {
      let _target = jQuery('.am-aibtn_request');
      if(jQuery(this).val().length > 3) {
        _target.removeClass('am-aidisabled');
        if (e.key === 'Enter') {
          _target.click();
        }
      } else {
        _target.addClass('am-aidisabled');
      }
    });

    jQuery(document).on('click', '.am-aibtn_request', function() {
      let _this = jQuery(this);
      let promptType = jQuery('.am-ai-btn').data('prompt-type');
      var input = jQuery('#ai-user-input').val();
        $.ajax({
            url: '{{ route("openai.submit") }}',
            type: 'POST',
            data: {
                _token: jQuery('meta[name="csrf-token"]').attr('content'),
                aiInput: input,
                promptType: promptType
            },
            dataType: 'json',
            beforeSend: function() {
                appendUserQuery(input);
                disableAiBtnInput();
                $('#ai-user-input').val('');
                jQuery('.am-aichat_list').append(aiLoaderTemplate);
            },
            complete: function() {
              jQuery('.am-aichat_list li.am-ai_loader').remove();
              enableAiBtnInput();
            },
            success: function(response) {
              if(response.error) {
                showAlert({
                  message: response.message,
                  type: 'error'
                });
                resetAiModal();
              } else {
                setTimeout(function() {
                    appendAiResponse(response.data.response);
                    enableAiBtnInput();
                }, 100);
              }
            },
            error: function(xhr) {
                showAlert({
                  message: xhr.responseJSON?.message ?? '{{ __("general.something_went_wrong") }}',
                  type: 'error'
                });
                resetAiModal();
            }
        });
    });

    jQuery(document).delegate('.am-ai_replace', 'click', function() {
        var responseText = jQuery(this).parent().siblings('.am-ai-reply_content').text();
        if (targetSelector && isSummernote) {
            jQuery(targetSelector).summernote('code', responseText);
        } else if (targetSelector) {
            jQuery(targetSelector).val(responseText);
        }
        jQuery(targetSelector).trigger('change');
        resetAiModal();
        if(parentModelId) {
          jQuery('#'+parentModelId).modal('show');
        }
    });

    jQuery(document).delegate('.am-ai_insert', 'click', function() {
        var responseText = jQuery(this).parent().siblings('.am-ai-reply_content').text();
        if (targetSelector && isSummernote) {
            var oldContent = jQuery(targetSelector).summernote('code')
            setTimeout(function() {
              jQuery(targetSelector).summernote('code', oldContent + responseText);
            }, 100);
        } else if (targetSelector) {
            jQuery(targetSelector).val(jQuery(targetSelector).val() + responseText);
        }
        jQuery(targetSelector).trigger('change');
        resetAiModal();
        if(parentModelId) {
          jQuery('#'+parentModelId).modal('show');
        }
    });

    jQuery(document).delegate('.am-ai_copy', 'click', function() {
      let _this = jQuery(this);
      var responseText = jQuery(this).parent().siblings('.am-ai-reply_content').text();
      navigator.clipboard.writeText(responseText.trim()).then(function() {
        _this.html('<i class="am-icon-copy-01" aria-hidden="true"></i>{{ __("general.copied") }}');
        setTimeout(function() {
          _this.html('<i class="am-icon-copy-01" aria-hidden="true"></i>{{ __("general.copy") }}');
        }, 1000);
      });
    });

    jQuery(document).delegate('.am-ai_regenerate', 'click', function() {
      let input = jQuery(this).parents('.am-user-reply.am-ai-reply_ai_reply').prev('li.am-ai-reply_ai-user_reply').find('.am-ai-reply_content').text();
      jQuery('#ai-user-input').val(input);
      jQuery('.am-aibtn_request').click();
    });

    function appendAiResponse(response) {
      let aiResponseTemplate = `<li class="am-user-reply am-ai-reply_ai_reply">
              <div class="am-ai-reply">
                <figure class="am-ai-reply_avatar">
                  <img src="{{ asset('images/ai-icon.svg') }}" alt="AI Response">
                </figure>
                <div class="am-ai-reply_content">
                  ${response}
                </div>
                <div class="am-ai-reply_tags">
                  <a href="javascript:;" class="am-btn am-ai_replace"><i class="am-icon-arrow-up" aria-hidden="true"></i>{{ __('general.replace') }}</a>
                  <a href="javascript:;" class="am-btn am-ai_insert"><i class="am-icon-arrow-bottom-left" aria-hidden="true"></i>{{ __('general.insert') }}</a>
                  <a href="javascript:;" class="am-btn am-ai_copy"><i class="am-icon-copy-01" aria-hidden="true"></i>{{ __('general.copy') }}</a>
                  <a href="javascript:;" class="am-btn am-ai_regenerate">{{ __('general.regenerate') }}</a>
                </div>
              </div>
            </li>`;
        jQuery('.am-aichat_list').append(aiResponseTemplate);
        jQuery('.am-aichat_list').animate({ scrollTop: jQuery('.am-aichat_list')[0].scrollHeight }, 'slow');
    }

    function appendUserQuery(input) {
      let userQueryTemplate = `<li class="am-user-reply am-ai-reply_ai-user_reply">
                <div class="am-ai-reply">   
                    <figure class="am-ai-reply_avatar">
                      <img src="{{ $userImage }}" alt="User Image">
                    </figure>
                    <div class="am-ai-reply_content">${input}</div>
                </div>
            </li>`;
      jQuery('.am-aichat_list').append(userQueryTemplate);
      jQuery('.am-aichat_list').animate({ scrollTop: jQuery('.am-aichat_list')[0].scrollHeight }, 'slow');
    }

    function disableAiBtnInput() {
      jQuery('.am-aibtn_request').addClass('am-aidisabled');
      jQuery('#ai-user-input').attr('disabled', true);
    }

    function enableAiBtnInput() {
      jQuery('.am-aibtn_request').addClass('am-aidisabled');
      jQuery('#ai-user-input').attr('disabled', false);
      jQuery('#ai-user-input').focus();
    }

    function resetAiModal() {
      jQuery('.am-aichat_list li:not(:first-child)').remove();
      jQuery('#ai-user-input').val('');
      enableAiBtnInput()
      $('#aiModal').modal('hide');
    }

    // jQuery(document).on('click', '.am-ai-generate', function() {
    //   targetSelector = $(this).data('target-selector');
    //   isSummernote = $(this).data('target-summernote');
    //   parentModelId = $(this).data('parent-model-id');
    //   jQuery('#aiModal').modal('show');
    // });

    jQuery('#aiModal').on('shown.bs.modal', function (event) {
      var button = jQuery(event.relatedTarget);
      var buttonData = button.data();
      targetSelector = buttonData.targetSelector;
      isSummernote = buttonData.targetSummernote;
      parentModelId = buttonData.parentModelId;
    });

    jQuery('#aiModal').on('hidden.bs.modal', function (event) {
      if(parentModelId) {
          jQuery('#'+parentModelId).modal('show');
        }
      targetSelector = null;
      isSummernote = null;
      parentModelId = null;
    });
});
</script>