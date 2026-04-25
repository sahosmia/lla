<div class="cr-topic-main cr-forum-topic">
    @if($comments->count() > 0)
        @foreach ($comments as $comment)
        <ul class="cr-david-list">
            @include('courses::livewire.discussion-forum.comments', ['comment' => $comment])
        </ul>
        @endforeach
    @endif

    <div class="cr-topic-content-reply">
        <h3 class="cr-forum-tag-title">{{ __('courses::courses.post_comment') }}</h3>
        <div class="cr-forum-topic-description">
            <div class="cr-forum-invalid @error('description') cr-invalid @enderror">
                <div class="cr-custom-editor am-custom-textarea" wire:ignore>
                    <textarea class="form-control cr-summernote" id="default-editor" placeholder="{{ __('courses::courses.enter_description') }}"></textarea>                    
                </div>
                @error('description')
                    <span class="am-error-msg">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="cr-submit-main">
            <a href="javascript:void(0)" class="cr-bookmark cr-submit" wire:click="addComment" wire:loading.class="cr-btn_disable">{{ __('courses::courses.submit') }}</a>
        </div>
    </div>    
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    @vite([
        'public/summernote/summernote-lite.min.css', 
    ])
@endpush
@push('scripts')
<script defer src="{{ asset('summernote/summernote-lite.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:initialized', function() {
            let target = '#default-editor';

            $('#default-editor').summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
                height: 400,
                width: '100%',
                callbacks: {
                    onChange: function(contents, $editable) {
                        @this.set('description', contents, false);
                    },
                    onPaste: function (e) {
                        e.preventDefault();
                        // Get plain text from clipboard
                        let bufferText = (
                            (e.originalEvent || e).clipboardData || window.clipboardData
                        ).getData('Text');

                        let characters = jQuery(target)
                            .summernote('code')
                            .replace(/(<([^>]+)>)/gi, '');
                        let totalCharacters = characters.length;
                        let t = e.currentTarget.innerText;

                        // Calculate max characters that can be pasted
                        let maxPaste = Math.min(
                            bufferText.length,
                            charLimit - t.length
                        );
                        let maxText = bufferText.substring(0, maxPaste);
                        // Insert plain text at cursor position
                        if (maxPaste > 0) {
                            const selection = window.getSelection();
                            const range = selection.getRangeAt(0);
                            range.deleteContents();
                            range.insertNode(document.createTextNode(maxText));
                        }

                        // Update character count
                        let remainingChar = totalCharacters + maxText.length;
                        charLeft(remainingChar, '.characters-count');
                        jQuery('.characters-count').text(
                            charLimit - remainingChar + ' / ' + charLimit
                        );
                    },
                }
            });

            jQuery(document).on('summernote.change', '.cr-summernote', function(we, contents, $editable) {
                let _this = $(this);
                @this.set('description', contents, false);
                
            });
        });

        document.addEventListener('commentAdded', function() {
            $('#default-editor').summernote('reset');
        });

        function toggleReplySection(commentId) {
            const allReplySections = document.querySelectorAll('.cr-topic-content');
            @this.set('parentId', commentId, false);
            allReplySections.forEach(section => {
                if (section.id !== `reply-section-${commentId}`) {
                    section.style.display = 'none';
                }
            });
            const replySection = document.getElementById(`reply-section-${commentId}`);
            if (replySection) {
                replySection.style.display = replySection.style.display === 'none' ? 'block' : 'none';
            } else {
                const replySection = `
                    <div id="reply-section-${commentId}" class="cr-topic-content cr-close-${commentId}" wire:key="post-reply-section-${commentId}">
                        <h3 class="cr-forum-tag-title">Reply</h3>
                        <div class="cr-forum-topic-description">
                            <div class="am-custom-editor am-custom-textarea" wire:ignore>
                                <textarea class="form-control cr-summernote" id="post-reply-editor-${commentId}" placeholder="{{ __('courses::courses.enter_description') }}"></textarea>
                            </div>
                        </div>
                        <div class="cr-submit-main">
                            <a href="javascript:void(0)" class="cr-bookmark cr-submit" wire:key="post-reply-button-${commentId}" wire:click="addComment" wire:loading.class="cr-btn_disable">{{ __('courses::courses.submit_reply') }}</a>
                        </div>
                        
                        <a href="javascript:void(0);" class="cr-removemodal" onclick="closeModal(${commentId})"><i class="cr-icon-multiply-02"></i></a>
                    </div>
                `;

                const postElement = document.getElementById(`reply-count-${commentId}`).closest('.cr-villy-about');
                const replyElement = postElement.querySelector('.cr-villy-stats');
                replyElement.insertAdjacentHTML('afterend', replySection);
                // setTimeout(() => {
                //     let target = `#post-reply-editor-${commentId}`;
                //     $(target).summernote(summernoteConfigs(target,'.characters-count'));
                //     // $(`#post-reply-editor-${commentId}`).summernote(summernoteConfigs(target,'.characters-count'));
                // }, 100);

                $(`#post-reply-editor-${commentId}`).summernote({
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline']],
                        ['fontsize', ['fontsize']],
                        ['para', ['ul', 'ol', 'paragraph']],
                    ],
                    height: 200,
                    width: '100%',
                    callbacks: {
                        onChange: function(contents, $editable) {
                            @this.set('description', contents, false);
                        },
                        onPaste: function (e) {
                            e.preventDefault();
                            // Get plain text from clipboard
                            let bufferText = (
                                (e.originalEvent || e).clipboardData || window.clipboardData
                            ).getData('Text');

                            let characters = jQuery(`#post-reply-editor-${commentId}`)
                                .summernote('code')
                                .replace(/(<([^>]+)>)/gi, '');
                            let totalCharacters = characters.length;
                            let t = e.currentTarget.innerText;

                            // Calculate max characters that can be pasted
                            let maxPaste = Math.min(
                                bufferText.length,
                                charLimit - t.length
                            );
                            let maxText = bufferText.substring(0, maxPaste);
                            // Insert plain text at cursor position
                            if (maxPaste > 0) {
                                const selection = window.getSelection();
                                const range = selection.getRangeAt(0);
                                range.deleteContents();
                                range.insertNode(document.createTextNode(maxText));
                            }

                            // Update character count
                            let remainingChar = totalCharacters + maxText.length;
                            charLeft(remainingChar, '.characters-count');
                            jQuery('.characters-count').text(
                                charLimit - remainingChar + ' / ' + charLimit
                            );
                        },
                    }
                });
            }
        }
        function closeModal(id) {
            const modal = document.querySelector(`.cr-close-${id}`); 
            if (modal) {
                modal.style.display = 'none'; 
            }
        }
    </script>
@endpush