@extends('layouts.frontend-app')
@section('content')
<div class="am-find-tutors-area">
    <div class="am-searchhead">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="am-breadcrumb">
                        <li><a href="{{ url('/') }}">{{ __('sidebar.home') }}</a></li>
                        <li><em>/</em></li>
                        <li class="active"><span>{{ __('sidebar.find_tutor') }}</span></li>
                    </ol>
                    <div class="am-searchhead_title">
                        <h2>{{ __('sidebar.discover_tutor_text') }}</h2>
                        <p>{{ __('sidebar.discover_tutor_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="am-searchfilter_wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-searchfilteritems">
                        <div class="am-searchfilter_left">
                            <div class="am-searchinput">
                                <input type="text" value="{{ $filters['keyword'] ?? '' }}"
                                    placeholder="{{ __('general.search_by_keyword') }}" class="form-control" id="keyword">
                                <span class="am-searchinput_icon">
                                    <i class="am-icon-search-02"></i>
                                </span>
                            </div>
                            <span class="am-select">
                                <span class="am-select_title">{{ __('general.sort_by') }}:</span>
                                <select class="am-select2" id="sort_by" data-searchable="false"
                                    data-class="am-sort_dp_option" data-placeholder="{{ __('general.sort_by') }}">
                                    <option> </option>
                                    <option value="newest" {{ (($filters['sort_by'] ?? '') == 'newest' ? 'selected' : '') }}>{{ __('general.newest_first') }}</option>
                                    <option value="oldest" {{ (($filters['sort_by'] ?? '') == 'oldest' ? 'selected' : '') }}>{{ __('general.oldest_first') }}</option>
                                    <option value="asc" {{ (($filters['sort_by'] ?? '') == 'asc' ? 'selected' : '') }}>{{ __('general.sort_by_a_z') }}</option>
                                    <option value="desc" {{ (($filters['sort_by'] ?? '') == 'desc' ? 'selected' : '') }}>{{ __('general.sort_by_z_a') }}</option>
                                </select>
                            </span>
                            <span class="am-select am-languageselect">
                                <span class="am-select_title">{{ __('general.language') }}:</span>
                                <select class="am-select2" id="language_id" data-searchable="true" multiple
                                    data-class="am-sort_dp_option" data-placeholder="{{ __('general.select_lang') }}">
                                    <option> </option>
                                    @foreach ($languages as $lang)
                                    <option value="{{ $lang->id }}" {{ in_array($lang->id, $filters['language_id'] ??
                                        []) ? 'selected' : '' }}>{{ $lang->name }}</option>
                                    @endforeach
                                </select>
                            </span>
                        </div>
                        <div class="am-clearfilterbtn d-none">
                            <a href="javascript:void(0);" id="clear_filters">{{ __('general.clear_all_filter') }}
                                <i class="am-icon-multiply-02"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="am-tutorsearch_section">
        <div class="container">
            <div class="row">
                <livewire:components.search-tutor :filters="$filters" wire:key="tutors-list-{{ time() }}" />
            </div>
        </div>
    </div>
</div>
@push('styles')
@vite([
'public/css/flags.css',
'public/css/videojs.css'
])
@endpush
@push('scripts')
<script src="{{ asset('js/video.min.js') }}"></script>
<script>
    var filter_record           = @js($filters);
    function applySearchFilter(clearFilter = true){
        $('.tutors-skeleton').toggleClass('d-none');
        let params = new URLSearchParams(window.location.search);
        for (let key in filter_record) {
            if (filter_record.hasOwnProperty(key)) {
                if (filter_record[key] && (!Array.isArray(filter_record[key]) || filter_record[key].length > 0)) {
                    params.set(key, filter_record[key]);
                } else {
                    params.delete(key);
                }
            }
        }
        let newUrl = `${window.location.pathname}?${params.toString()}`;
        window.history.replaceState({}, '', newUrl);
        clearFilters(clearFilter);
        Livewire.dispatch('tutorFilters', {filters: filter_record});
    }

    document.addEventListener('DOMContentLoaded', function () {
                address = '';
                window.session_type = '';
      
                var applyFilter         = true;
                let timeout;
                setTimeout(() => {
                    clearFilters();
                }, 500);

                jQuery('.am-select2').each((index, item) => {
                    let _this = jQuery(item);
                    searchable = _this.data('searchable');
                    let params = {
                        dropdownCssClass: _this.data('class'),
                        placeholder: _this.data('placeholder'),
                        allowClear: true
                    }
                    if(!searchable){
                        params['minimumResultsForSearch'] = Infinity;
                    }
                    _this.select2(params);
                });

                

                jQuery(document).on('input', '#keyword',function (event){
                    clearTimeout(timeout);
                    filter_record[event.target.id] = event.target.value
                    timeout = setTimeout(() => applySearchFilter(), 300);
                });

                jQuery(document).on('click', '#clear_filters',function (e){
                    filter_record = {}
                    $('#keyword').val('');
                    $('#language_id')?.val(null)?.trigger('change');
                    $('#clear_filters').parent().addClass('d-none');
                    applySearchFilter(false);
                    let newUrl = `${window.location.pathname}`;
                    window.history.replaceState({}, '', newUrl);
                });

                jQuery(document).on('change', '#sort_by, #per_page', function (e){
                    let value = $('#'+e.target.id).select2("val");
                    filter_record[e.target.id] = value?.length > 0 ? value : null;
                    applySearchFilter()
                });

                jQuery(document).on('change', '#language_id', function (e){
                    let value = $('#language_id').select2("val");
                    if(value?.length > 0){
                        filter_record['language_id'] = value[0]?.length > 0 ? value : [];
                    } else {
                        filter_record['language_id'] = [];
                    }
                    applySearchFilter()
                });

                
               
            });
            function clearFilters(clearFilter = true) {
                const allClear = !Object.values(filter_record).some(value => value?.length > 0 );
                $('#clear_filters').parent().toggleClass('d-none', allClear || !clearFilter);
            }
</script>
@endpush
@endsection
@if(session()->get('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.dispatch('showAlertMessage', {
            type: 'error',
            message: "{{ session()->get('error') }}"
        });
    });
</script>
@endif