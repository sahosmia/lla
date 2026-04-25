<main class="tb-main tb-blogwrap" wire:init="loadData">
    <div class="row">
        @include('livewire.pages.admin.blog-categories.update')
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4>{{ __('category.text') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred {{ $selectedCategories ? '' : 'd-none' }}" @click="$wire.dispatch('showConfirm', { action : 'delete-category' })">{{ __('general.delete_selected') }}</a>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select" wire:ignore>
                                        <select class="am-select2" id="sortBy" data-searchable="false">
                                            <option value="asc">{{ __('general.asc') }}</option>
                                            <option value="desc">{{ __('general.desc') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select" wire:ignore>
                                        <select class="form-control am-select2" id="perPage" data-searchable="false">
                                            @foreach($per_page_opt as $opt)
                                                <option value="{{ $opt }}">{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search" autocomplete="off" placeholder="{{ __('category.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-db-categoriestable">
                @if($categories->count() > 0)
                    <div class="tb-table-wrap">
                        <table class="table tb-table tb-dbholder">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="tb-checkbox">
                                            <input id="checkAll" wire:model.lazy="selectAll" type="checkbox">
                                            <label for="checkAll">{{ __('category.title') }}</label>
                                        </div>
                                    </th>
                                    <th>{{ __('category.description') }}</th>
                                    <th>{{ __('general.status') }}</th>
                                    <th>{{ __('general.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $single)
                                    <tr>
                                        <td data-label="{{ __('category.title') }}">
                                            <div class="tb-namewrapper">
                                                <div class="tb-checkbox">
                                                    <input id="category_id{{ $single->id }}" wire:model.lazy="selectedCategories" value="{{ $single->id }}" type="checkbox">
                                                    <label for="category_id{{ $single->id }}">
                                                        <span>
                                                            @if(!empty($single->image))
                                                                @php
                                                                    $image = unserialize($single->image);
                                                                    $image_path = $image['file_path'];
                                                                    $image_name = $image['file_name'];
                                                                @endphp
                                                                <img src="{{ url(Storage::url($image_path)) }}" alt="{{ $image_name }}">
                                                            @endif
                                                            {!! $single->name !!}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('category.description') }}"><span>{!! $single->description !!}</span></td>
                                        <td data-label="{{ __('general.status') }}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-{{ $single->status == 'active' ? 'active' : 'disabled' }}">{{ $single->status }}</em>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('general.actions') }}">
                                            <ul class="tb-action-icon">
                                                <li><a href="javascript:void(0);" wire:click="edit({{ $single->id }})"><i class="icon-edit-3"></i></a></li>
                                                <li>    
                                                    <a href="javascript:void(0);" 
                                                    @click="$wire.dispatch('showConfirm', { id: {{ $single->id }}, action: 'delete-category' })" 
                                                    class="tb-delete">
                                                    <i class="icon-trash-2"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $categories->links('pagination.custom') }}
                @else
                <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')"/>
                @endif
            </div>
        </div>
    </div>
</main>
@push('styles')
    @vite([
        'public/css/combotree.css', 
    ])
@endpush

@push('scripts')
    <script defer src="{{ asset('js/combotree.js')}}"></script>
    <script>
        var categoryInstance = null;

        document.addEventListener('livewire:navigated', function() {

            let title           = '{{ __("general.confirm") }}';
            let listenerName    = 'delete-category-confirm';
            let content         = '{{ __("general.confirm_content") }}';
            let action          = 'deleteConfirmRecord'; 
            
            window.addEventListener('initDropDown', function(event){
                let parentId = event.detail.parentId;
                if( event.detail.categories_tree.length ){
                    initDropDown(event.detail.categories_tree, parentId);
                }
            });

            jQuery('#sortBy').on('change', function() {
                let sortByValue = jQuery(this).val();
                @this.set('sortby', sortByValue);
            });

            jQuery('#perPage').on('change', function() {
                let perPageValue = jQuery(this).val();
                @this.set('per_page', perPageValue);
            });

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


            function initDropDown(categories, parentId = null){

                // jQuery('input[id^="category_dropdown-"]').parent('.form-group').removeClass('d-none');
                if(categoryInstance != null){
                    categoryInstance.clearSelection();
                    categoryInstance.destroy();
                }

                let settings = {
                    source : categories,
                    isMultiple: false,
                    collapse: false
                }

                if(parentId){
                    settings['selected'] = [parentId.toString()]
                }
                setTimeout(() => {  
                    categoryInstance = $('input[id^="category_dropdown-"]').comboTree(settings);
                }, 100);
            }
                
                // confirmAlert({title,listenerName, content, action});

            

                // if( window.categories_tree.length ){
                //     initDropDown(window.categories_tree);
                // }

                

                jQuery(document).on('change', 'input[id^="category_dropdown-"]', function(event){
                    if(categoryInstance){
                        let id = categoryInstance.getSelectedIds();
                        if(id){
                            @this.set('parentId', id[0], true);
                        }
                    }
                });
                // iniliazeSelect2Scrollbar();
        });
        
    </script>
@endpush
