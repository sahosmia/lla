<div wire:ignore.self class="modal am-modal fade am-dispute_modal" id="dispute-reason-popup" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="am-modal-header">
                <h2>{{ __('dispute.raise_dispute') }}</h2>
                <span class="am-closepopup" data-bs-dismiss="modal">
                    <i class="am-icon-multiply-01"></i>
                </span>
            </div>
            <div class="am-modal-body">
                <form class="am-themeform">
                    <fieldset>
                        <div class="form-group">
                            <label class="am-important" for="selectedReason">{{ __('dispute.select_reason') }}</label>
                            <div @class(['form-control_wrap', 'am-invalid' => $errors->has('selectedReason')])>
                                <span class="am-select" wire:ignore>
                                    <select data-componentid="@this" class="am-custom-select" placeholder="{{ __('dispute.select_a_dispute_reason') }}" data-searchable="true" wire:key="{{ time() }}" data-parent="#dispute-reason-popup" id="selectedReason" data-wiremodel="selectedReason">
                                        <option value="">{{ __('dispute.select_a_dispute_reason') }}</option>
                                        @foreach ($disputeReason as $reason)
                                            <option value="{{ $reason }}" {{ $reason == $selectedReason ? 'selected' : '' }}>{{ $reason }}</option>
                                        @endforeach
                                    </select>
                                </span>
                            </div>
                            <x-input-error field_name="selectedReason" />
                        </div>
                        <div @class(['form-group', 'am-invalid' => $errors->has('description')])>
                            <x-input-label class="am-important" for="description" :value="__('education.description')" />
                            <div class="am-custom-editor" wire:ignore>
                                    <textarea id="description" class="form-control" placeholder="{{ __('dispute.add_dispute_reason') }}"></textarea>
                                <span class="characters-count"></span>
                            </div>
                            <x-input-error field_name="description" />
                        </div>
                        
                        <div class="form-group am-form-btn-wrap">
                            <button wire:target="saveDisputeReason" wire:loading.class="am-btn_disable" wire:click.prevent="saveDisputeReason({{ $booking['id'] ?? null }}, {{ $booking['student_id'] ?? null }}, {{ $booking['tutor_id'] ?? null }}, '{{ $booking['start_time'] ?? null }}')" class="am-btn">{{ __('dispute.submit') }}</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@push('styles')
@vite([
'public/summernote/summernote-lite.min.css',
])
@endpush
@push('scripts')
    <script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>
@endpush
<script type="text/javascript">
document.addEventListener('livewire:initialized', function() { 
    var component = '';
    document.addEventListener('livewire:navigated', function() {
        component = @this;
    });
    $(document).on('show.bs.modal','#dispute-reason-popup', function () {
        var initialContent = component.get('description');
        $('#description').summernote('destroy');
        $('#description').summernote(summernoteConfigs('#description'));
        $('#description').summernote('code', initialContent);
        $(document).on('summernote.change', '#description', function(we, contents, $editable) {             
            component.set("description",contents, false);
        });
        $('#selectedReason').select2({
            dropdownParent: $('#dispute-reason-popup')
        });
        // Reset the selected reason to ensure it's not retained between modal opens
        $('#selectedReason').val(null).trigger('change');
    });
    jQuery(document).on('change', '.am-custom-select', function(e){
        component.set('selectedReason', jQuery('.am-custom-select').select2("val"), false);
    });
});
</script>
