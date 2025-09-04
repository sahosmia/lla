<?php $__env->startSection('content'); ?>
<div class="am-find-tutors-area">
    <div class="am-searchhead">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="am-breadcrumb">
                        <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('sidebar.home')); ?></a></li>
                        <li><em>/</em></li>
                        <li class="active"><span><?php echo e(__('sidebar.find_tutor')); ?></span></li>
                    </ol>
                    <div class="am-searchhead_title">
                        <h2><?php echo e(__('sidebar.discover_tutor_text')); ?></h2>
                        <p><?php echo e(__('sidebar.discover_tutor_desc')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="am-searchfilter_wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-searchfilter_tabs">
                        <ul class="am-searchfilter_tabslist">
                            <li>
                                <a href="javascript:void(0);" data-type="" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-session-tab', 'active'=>
                                    $filters['session_type'] == '']); ?>"><?php echo e(__('tutor.all_sessions')); ?></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-type="one" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-session-tab', 'active'=>
                                    $filters['session_type'] == 'one']); ?>"><?php echo e(__('tutor.private_sessions')); ?></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-type="group" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-session-tab', 'active'=>
                                    $filters['session_type'] == 'group']); ?>"><?php echo e(__('tutor.group_sessions')); ?></a>
                            </li>
                        </ul>
                        <div class="am-clearfilterbtn d-none">
                            <a href="javascript:void(0);" id="clear_filters"><?php echo e(__('general.clear_all_filter')); ?>

                                <i class="am-icon-multiply-02"></i>
                            </a>
                        </div>
                    </div>
                    <div class="am-searchfilter">
                        <div class="am-searchfilter_item">
                            <span class="am-searchfilter_title"><?php echo e(__('subject.subject_group')); ?></span>
                            <span class="am-select">
                                <select id="group_id" class="am-select2" data-searchable="true"
                                    data-class="am-filter-dropdown"
                                    data-placeholder="<?php echo e(__('subject.choose_subject_group')); ?>">
                                    <option> </option>
                                    <?php $__currentLoopData = $subjectGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($group->id); ?>" <?php echo e($group->id == ($filters['group_id'] ?? '') ?
                                        'selected' : ''); ?>><?php echo e($group->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </span>
                        </div>
                        <div class="am-searchfilter_item">
                            <span class="am-searchfilter_title"><?php echo e(__('subject.choose_subject_label')); ?></span>
                            <span class="am-select">
                                <select id="subject_id" class="am-select2" multiple data-searchable="true"
                                    data-class="am-filter-dropdown"
                                    data-placeholder="<?php echo e(__('subject.choose_subject_label')); ?>">
                                    <option> </option>
                                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subject->id); ?>" <?php echo e(in_array($subject->id, $filters['subject_id'] ??
                                        []) ? 'selected' : ''); ?>><?php echo e($subject?->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </span>
                        </div>
                        <?php if(isPaidSystem()): ?>
                            <div class="am-searchfilter_item">
                                <span class="am-searchfilter_title"><?php echo e(__('calendar.max_price')); ?></span>
                                <input type="text" placeholder="<?php echo e(getCurrencySymbol()); ?>0.00" class="form-control"
                                    id="max_price" value="<?php echo (!empty($filters['max_price']) ? (getCurrencySymbol().$filters['max_price']) : ''); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="am-searchfilter_item">
                            <span class="am-searchfilter_title"><?php echo e(__('general.tutor_location')); ?></span>
                            <span class="am-select">
                                <?php if(!empty(setting('_api.google_places_api_key'))): ?>
                                <input type="text" class="form-control" id="map_location" value="<?php echo e($filters['country'] ?? ''); ?>"
                                    placeholder="<?php echo e(__('general.enter_tutor_location')); ?>">
                                <?php else: ?>
                                <select class="am-select2" id="tutor_country" data-searchable="true"
                                    data-class="am-sort_dp_option am-sort-location" data-placeholder="<?php echo e(__('general.search_by_country')); ?>">
                                    <option> </option>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($country->id); ?>" <?php echo e($country->id == ($filters['country'] ?? '') ?
                                        'selected' : ''); ?>><?php echo e($country->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                    <div class="am-searchfilteritems">
                        <div class="am-searchfilter_left">
                            <div class="am-searchinput">
                                <input type="text" value="<?php echo e($filters['keyword'] ?? ''); ?>"
                                    placeholder="<?php echo e(__('general.search_by_keyword')); ?>" class="form-control" id="keyword">
                                <span class="am-searchinput_icon">
                                    <i class="am-icon-search-02"></i>
                                </span>
                            </div>
                            <span class="am-select">
                                <span class="am-select_title"><?php echo e(__('general.sort_by')); ?>:</span>
                                <select class="am-select2" id="sort_by" data-searchable="false"
                                    data-class="am-sort_dp_option" data-placeholder="<?php echo e(__('general.sort_by')); ?>">
                                    <option> </option>
                                    <option value="newest" <?php echo e((($filters['sort_by'] ?? '') == 'newest' ? 'selected' : '')); ?>><?php echo e(__('general.newest_first')); ?></option>
                                    <option value="oldest" <?php echo e((($filters['sort_by'] ?? '') == 'oldest' ? 'selected' : '')); ?>><?php echo e(__('general.oldest_first')); ?></option>
                                    <option value="asc" <?php echo e((($filters['sort_by'] ?? '') == 'asc' ? 'selected' : '')); ?>><?php echo e(__('general.sort_by_a_z')); ?></option>
                                    <option value="desc" <?php echo e((($filters['sort_by'] ?? '') == 'desc' ? 'selected' : '')); ?>><?php echo e(__('general.sort_by_z_a')); ?></option>
                                </select>
                            </span>
                            <span class="am-select am-languageselect">
                                <span class="am-select_title"><?php echo e(__('general.language')); ?>:</span>
                                <select class="am-select2" id="language_id" data-searchable="true" multiple
                                    data-class="am-sort_dp_option" data-placeholder="<?php echo e(__('general.select_lang')); ?>">
                                    <option> </option>
                                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lang->id); ?>" <?php echo e(in_array($lang->id, $filters['language_id'] ??
                                        []) ? 'selected' : ''); ?>><?php echo e($lang->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="am-tutorsearch_section">
        <div class="container">
            <div class="row">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.search-tutor', ['filters' => $filters]);

$__html = app('livewire')->mount($__name, $__params, 'tutors-list-'.e(time()).'', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php if(!empty(setting('_lernen.help_section_media')) ||
                !empty(setting('_lernen.help_section_title')) ||
                !empty(setting('_lernen.help_section_description')) ||
                !empty(setting('_lernen.help_section_bullets')) ||
                !empty(setting('_lernen.or_section_title')) ||
                !empty(setting('_lernen.or_section_description'))
                ): ?>
                <div class="col-12 col-lg-4 col-xl-3">
                    <div class="am-besttutor">
                        <?php if(!empty(setting('_lernen.help_section_media')[0]['path'])): ?>
                        <div class="am-besttutor_video">
                            <video width="560" height="180"
                                src="<?php echo e(url(Storage::url(setting('_lernen.help_section_media')[0]['path']))); ?>" controls
                                class="video-js" data-setup='{}' preload="auto"></video>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty(setting('_lernen.help_section_title')) ||
                        !empty(setting('_lernen.help_section_description')) ||
                        !empty(setting('_lernen.help_section_bullets')) ||
                        !empty(setting('_lernen.or_section_title')) ||
                        !empty(setting('_lernen.or_section_description'))
                        ): ?>
                        <div class="am-besttutor_footer">
                            <div class="am-besttutor_footer_tips">
                                <?php if(!empty(setting('_lernen.help_section_title'))): ?>
                                <h4><?php echo e(setting('_lernen.help_section_title')); ?></h4>
                                <?php endif; ?>
                                <?php if(!empty(setting('_lernen.help_section_description'))): ?>
                                <p><?php echo e(setting('_lernen.help_section_description')); ?></p>
                                <?php endif; ?>
                                <?php if(!empty(setting('_lernen.help_section_bullets'))): ?>
                                <ul class="am-besttutor_info_list">
                                    <?php $__currentLoopData = setting('_lernen.help_section_bullets'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bullet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><span><?php echo e($bullet['help_section']); ?></span></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')([
'public/css/flags.css',
'public/css/videojs.css'
]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/video.min.js')); ?>"></script>
<?php if( !empty(setting('_api.google_places_api_key'))): ?>
    <script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(setting('_api.google_places_api_key')); ?>&libraries=places&loading=async&callback=initializePlaceApi"></script>
<?php endif; ?>
<script>
    var filter_record           = <?php echo \Illuminate\Support\Js::from($filters)->toHtml() ?>;
    
    <?php if(setting('_api.enable_google_places') == '1'): ?>
        var selectedCountry     = <?php echo json_encode($selectedCountry, 15, 512) ?>;
        var searchOnlyCities    = <?php echo json_encode($searchOnlyCities, 15, 512) ?>;

        function initializePlaceApi() {
            var tutorAddress = document.getElementById('map_location');
            if (!tutorAddress) {
                setTimeout(initializePlaceApi, 500); 
                return;
            }
            var options = {};
            if (selectedCountry) {
                options.componentRestrictions = { country: selectedCountry };
            }
            if (searchOnlyCities == '1') {
                options.types = ['(cities)'];
            }
            if(typeof google != 'undefined' && typeof google.maps.places != 'undefined'){
                var autocompleteTutor = new google.maps.places.Autocomplete(tutorAddress, options);
                google.maps.event.addListener(autocompleteTutor, 'place_changed', function () {
                    var place = autocompleteTutor.getPlace();
                    var address = place.formatted_address;
                    place.address_components?.forEach((item) => {
                        if(item.types.includes('country')){
                            filter_record['country'] = item.long_name
                        }
                    });
                    filter_record['address'] = address;
                    applySearchFilter()
                });
            }
        }
    <?php endif; ?>
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

                

                jQuery(document).on('input', '#max_price, #keyword',function (event){
                    clearTimeout(timeout);
                    filter_record[event.target.id] = event.target.value
                    timeout = setTimeout(() => applySearchFilter(), 300);
                });

                 jQuery(document).on('change', '#tutor_country',function (e){
                    filter_record['country'] = $('#tutor_country')?.select2("val");
                   applySearchFilter()
                });

                jQuery(document).on('click', '#clear_filters',function (e){
                    filter_record = {}
                    $('#keyword').val('');
                    $('#max_price').val('');
                    $('#map_location')?.val('');
                    $('#availability')?.val(null).trigger('change');
                    $('#group_id')?.val(null).trigger('change');
                    $('#subject_id')?.val(null).trigger('change');
                    $('#tutor_country')?.val(null)?.trigger('change');
                    $('#language_id')?.val(null)?.trigger('change');
                    $('#clear_filters').parent().addClass('d-none');
                    applySearchFilter(false);
                    let newUrl = `${window.location.pathname}`;
                    window.history.replaceState({}, '', newUrl);
                });

                jQuery(document).on('click', '.am-session-tab',function (e){
                    let _this = jQuery(this);
                    jQuery('.am-session-tab').removeClass('active');
                    _this.addClass('active');
                    filter_record['session_type'] = _this.data('type');
                    applySearchFilter(false);
                });

                jQuery(document).on('change', '#group_id, #availability, #sort_by, #per_page', function (e){
                    let value = $('#'+e.target.id).select2("val");
                    filter_record[e.target.id] = value?.length > 0 ? value : null;
                    applySearchFilter()
                });

                jQuery(document).on('change', '#subject_id', function (e){
                    let value = $('#subject_id').select2("val");
                    if(value?.length > 0){
                        filter_record['subject_id'] = value[0]?.length > 0 ? value : [];
                    } else {
                        filter_record['subject_id'] = [];
                    }
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php if(session()->get('error')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.dispatch('showAlertMessage', {
            type: 'error',
            message: "<?php echo e(session()->get('error')); ?>"
        });
    });
</script>
<?php endif; ?>
<?php echo $__env->make('layouts.frontend-app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/frontend/find-tutors.blade.php ENDPATH**/ ?>