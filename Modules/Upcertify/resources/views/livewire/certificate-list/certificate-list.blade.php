<div class="uc-certificates" wire:init="loadData">
    <div class="uc-certificates_header">
        <div class="uc-certificates_title">
            <h2>{{ __('upcertify::upcertify.all_certificates') }}</h2>
            <p>{{ __('upcertify::upcertify.browse_certificates') }}</p>
        </div>
        <div class="uc-certificates_btn">
            <a href="javascript:void(0);" class="uc-btn" @click="openModal('#uc-create-certificate-popup')">{{ __('upcertify::upcertify.create_certificate') }} <i class="uc-btn_icon"> <x-upcertify::icons.plus /> </i></a>
        </div>
    </div>
    <div class="uc-certificates_list">
        @if( $isLoading )
            <ul class="uc-certificates_list_items">
                @for ($i = 0; $i < 7; $i++)
                    <li class="uc-skeleton">
                        <figure class="uc-template_item">
                        </figure>
                    </li>
                @endfor
            </ul>
        @elseif( $templates->count() > 0 )
            <ul class="uc-certificates_list_items">
                @foreach( $templates as $template )
                    <li>
                        <div class="uc-certificates_item">
                            <figure class="uc-certificates_item_img @if( empty($template->thumbnail_url) ) uc-certificates_item_empty @endif">
                                @if( !empty($template->thumbnail_url) )
                                    <img src="{{ Storage::url($template->thumbnail_url).'?v='.time() }}" alt="{{ __('courses::courses.promotional_video') }}">
                                @endif
                            </figure>
                            <div class="uc-certificates_item_content">
                                <h3>{{ $template->title }}</h3>
                                <div class="uc-certificates_item_actions">
                                    <a href="javascript:void(0);" class="uc-certificates_item_actions_btn"><i><x-upcertify::icons.ellipsis-horizontal /></i></a>
                                    <ul class="uc-certificates_item_actions_dropdown">
                                        <li>
                                            <a href="{{ route('upcertify.update', ['id' => $template->id, 'tab' => 'general', 'as_template' => true]) }}"><i><x-upcertify::icons.template /></i>{{ __('upcertify::upcertify.use_template') }}</a>
                                        </li>
                                        @if(!empty($template->user_id))
                                            <li>
                                                <a href="{{ route('upcertify.update', ['id' => $template->id, 'tab' => 'media']) }}"><i><x-upcertify::icons.pen /></i>{{ __('upcertify::upcertify.edit_template') }}</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="uc-delete-template" data-id="{{ $template->id }}"><i><x-upcertify::icons.trash /></i>{{ __('upcertify::upcertify.delete_template') }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            {{ $templates->links('upcertify::pagination.pagination') }}
        @else
            <div class="uc-certificates_list_empty">
                <img src="{{ asset('modules/upcertify/images/empty-view.svg') }}" alt="{{ __('upcertify::upcertify.no_data_found') }}">
                <h3>{{ __('upcertify::upcertify.no_data_found') }}</h3>
                <p>{{ __('upcertify::upcertify.no_data_found_description') }}</p>
                <a href="javascript:void(0);" class="uc-btn" @click="openModal('#uc-create-certificate-popup')">{{ __('upcertify::upcertify.create_certificate') }} <i class="uc-btn_icon"> <x-upcertify::icons.plus /> </i></a>
            </div>
        @endif
    </div>

    <div id="uc-create-certificate-popup" class="uc-modal uc-addmediapopup" wire:ignore.self>
        <div class="uc-modaldialog">
            <div class="uc-modal_wrap">
                <div class="uc-modal_title">
                    <h2>{{ __('upcertify::upcertify.create_certificate') }}</h2>
                    <a href="javascript:void(0);" class="uc-removemodal" @click="closeModal"><x-upcertify::icons.close /></a>
                </div>
                <div class="uc-modal_body">
                    <form class="uc-themeform">
                        <fieldset>
                            <div class="form-group">
                                <label for="title" class="uc-important">{{ __('upcertify::upcertify.title') }}</label>
                                <div class="form-group-wrap @error('title') uc-invalid @enderror">
                                    <input class="form-control" type="text" placeholder="{{ __('upcertify::upcertify.enter_title') }}" wire:model="title" wire:keydown.enter="createNow">
                                    @error('title')
                                        <span class="uc-error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group form-group-btns">
                                <button type="button" class="uc-white-btn close-modal" @click="closeModal">{{ __('upcertify::upcertify.cancel') }}</button>
                                <button type="button" class="uc-btn" wire:loading.class="uc-btn_disable" wire:click.prevent="createNow">
                                    <span wire:loading.remove wire:target="createNow">{{ __('upcertify::upcertify.create') }}</span>
                                    <span wire:loading wire:target="createNow">{{ __('upcertify::upcertify.creating') }}</span>
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Alert Popup -->
    <div id="uc-deletepopup" class="uc-modal uc-deletepopup" wire:ignore.self>
        <div class="uc-modaldialog">
            <div class="uc-modal_wrap">
                <div class="uc-modal_body">
                    <span class="uc-closepopup" @click="closeModal">
                        <x-upcertify::icons.close />
                    </span>
                    <div class="uc-deletepopup_icon delete-icon">
                        <span><x-upcertify::icons.trash /></span>
                    </div>
                    <div class="uc-deletepopup_title">
                        <h3>{{ __('upcertify::upcertify.confirm') }}</h3>
                        <p>{{ __('upcertify::upcertify.are_you_sure') }}</p>
                    </div>
                    <div class="uc-deletepopup_btns">
                        <a href="javascript:void(0);" class="uc-btn uc-btnsmall uc-cancel" @click="closeModal">{{ __('upcertify::upcertify.no') }}</a>
                        <a href="javascript:void(0);" class="uc-btn uc-btn-del uc-confirm-yes">{{ __('upcertify::upcertify.yes') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            //delete Template
            jQuery(document).on('click', '.uc-delete-template', function (e) {
                var _this = jQuery(this);
                var id = _this.data('id');
                openModal('#uc-deletepopup');
                var confirmDeleteTemplate = document.querySelector('.uc-confirm-yes');
                const deleteHandler = async function () {
                    let _deleteButton = jQuery(this);
                    _deleteButton.addClass('uc-btn_disable');
                    try {
                        await @this.call('deleteTemplate', id);
                    } catch (error) {
                        console.error('Error deleting template:', error);
                    } finally {
                        _deleteButton.removeClass('uc-btn_disable');
                        closeModal('#uc-deletepopup');
                        confirmDeleteTemplate.removeEventListener('click', deleteHandler);
                    }
                };
                confirmDeleteTemplate.addEventListener('click', deleteHandler);
            });
        });
    </script>
@endpush