<div class="tb-translator tb-translatorwrap">
    <div class="am-insights_title">
        <h2>{{__('general.language_translations')}}</h2>
    </div>
    <div class="tb-langtranswrap">
        <form class="tb-themeform tb-langtrans-form">
            <fieldset>
                <div class="form-group-wrap">
                    <div class="form-group">
                        <label class="tb-label">{{__('general.languages')}}</label>
                        <div class="tk-error @error('targetLang') tk-invalid @enderror">
                            <div class="tb-select" wire:ignore>
                                <select data-componentid="@this" class="am-select2 form-control" data-searchable="true" data-live='true' id="target-language" data-wiremodel="targetLang" placeholder="{{ __('general.select_language') }}">
                                    <option value="">{{ __('general.select_language') }}</option>
                                    @foreach ($selectedLanguages as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                        @error('targetLang')
                            <div class="tk-errormsg">
                                <span>{{$message}}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="tb-label">{{__('general.translation_method')}}</label>
                        <div class="tb-switchbtn">
                            <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes">{{$translationMethod ? __('general.continue_with_queue_job') : __('general.continue_without_queue_job')}} </span></label>
                            <input class="tb-checkaction" wire:model.live="translationMethod" type="checkbox" id="status" checked="">
                        </div>
                    </div>
                    @if($translationMethod)
                        <div class="form-group">
                            <div  class="am-translationprogress"
                                x-data="{
                                    init() {
                                        const savedId = sessionStorage.getItem('translate_job_id');
                                        if (savedId && !window.location.search.includes('job_id=')) {
                                            window.location.href = '?job_id=' + savedId;
                                            }
                            
                                        Livewire.on('jobStarted', jobId => {
                                            sessionStorage.setItem('translate_job_id', jobId);
                                            window.location.href = '?job_id=' + jobId;
                                            });
                                    }
                                    }"
                                x-init="init()">
                                @if ($running && $progress <= 100)
                                    <div wire:poll.2000ms="pollProgress" class="am-uploadedfil">
                                        <div class="uploadbar-wrap">
                                            <span id="file-name" class="uploaded-zip">{{__('general.translation_in_progress')}}</span>
                                            <div class="uploadbar progress">
                                                <div 
                                                    id="progress-bar"
                                                    class="progress-bar progress-bar-striped progress-bar-animated"
                                                    role="progressbar"
                                                    style="width: {{ $progress }}%;"
                                                    aria-valuenow="{{ $progress }}"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                                >
                                                    {{ $progress }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif    
                    @if(!$running)
                        <div class="form-group">
                            <button type="button" wire:target="translateLangFiles" wire:loading.class="tb-btn_disable" class="tb-btn" wire:click="translateLangFiles">{{__('general.translate')}}</button>
                        </div>
                    @endif
                </div>
            </fieldset>
        </form>
        @if($translationMethod)
            <div class="am-insights_notice">
                <strong>{{__('general.note')}}</strong>
                <div class="am-alertmsg">
                    <strong>{{__('general.translation_in_background')}}</strong>
                    <p>{{__('general.translation_in_background_note')}}</p>

                    <strong>{{__('general.why_this_is_recommended')}}</strong>
                    <ul>
                        <li>{{__('general.why_this_is_recommended_1')}}</li>

                        <li>{{__('general.why_this_is_recommended_2')}}</li>
                    </ul>
                    <p>{{ __('general.need_a_language') }}<em>{{ __('general.site_management') }}</em> {{ __('general.and_enable_it_under') }} <strong>{{__('general.multi_language_selection')}}</strong> </p>
                    
                </div>
            </div>
        @else
            <div id="instant-mode" class="am-insights_notice">
                <strong>{{__('general.note')}}</strong>
                <div class="am-alertmsg">
                    <strong>{{__('general.instant_mode')}}</strong>
                    <p>{{ __('general.instant_mode_note') }} <strong>{{ __('general.not_refresh_close_or_leave') }}</strong></p>
        
                    <p>{{__('general.need_a_language')}}<em>{{__('general.site_management')}}</em> {{__('general.and_enable_it_under')}} <strong>{{__('general.multi_language_selection')}}</strong></p>
            
                </div>
            </div>
        @endif
    </div>
</div>