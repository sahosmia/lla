<div class="am-blogs_main">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if(!empty(setting('_front_page_settings.blog_pre_heading')) 
                        || !empty(setting('_front_page_settings.blog_heading')) 
                        || !empty(setting('_front_page_settings.blog_description'))
                        || !empty(setting('_front_page_settings.search_placeholder'))
                        || !empty(setting('_front_page_settings.search_button_text')))
                        <section class="am-works am-blogs"> 
                            <div class="am-page-title-wrap">
                                <div class="am-content_box">
                                    @if(!empty(setting('_front_page_settings.blog_pre_heading')))
                                        <span>{!! setting('_front_page_settings.blog_pre_heading') !!}</span>
                                    @endif
                                    @if(!empty(setting('_front_page_settings.blog_heading')))
                                        <h3>{!! setting('_front_page_settings.blog_heading') !!}</h3>
                                    @endif
                                    @if(!empty(setting('_front_page_settings.blog_description')))
                                        <p>{!! setting('_front_page_settings.blog_description') !!}</p>
                                    @endif
                                    <form class="am-learning_search">
                                        @if(!empty(setting('_front_page_settings.search_placeholder')))
                                            <div class="am-learning_search_input">
                                                <input wire:model.live.debounce.500ms="keyword" type="text" placeholder="{!! setting('_front_page_settings.search_placeholder') !!}">
                                                <i class="am-icon-search-02"></i>
                                            </div>
                                        @endif
                                        @if(!empty(setting('_front_page_settings.search_button_text')))
                                            <button class="am-learning_search_btn am-btn am-disabled">{!! setting('_front_page_settings.search_button_text') !!}</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="am-allblogs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-allblogs_wrap am-blogs-main">
                        @if(!empty(setting('_front_page_settings.all_blogs_heading')))
                            <h2>{!! setting('_front_page_settings.all_blogs_heading') !!}</h2>
                        @endif
                        <div class="am-blogs-select-main">
                            @if($keyword || $category_id || $orderBy != 'desc')
                                <div class="am-clear-filter" wire:click='clearFilters'>
                                    <span>{{__('blogs.clear_all_filtes')}} <i class="am-icon-multiply-02"></i></span>
                                </div>
                            @endif
                            <div class="am-blogs-select">
                                <span class="am-select" wire:ignore>
                                    <select class="am-select2" id="category_id" data-searchable="true"
                                        data-class="am-sort_dp_option" data-placeholder="{{ __('blogs.select_category') }}"> 
                                        <option value="">{{ __('blogs.select_category') }}</option>
                                        @foreach($categories as $category)
                                            <option {{ $category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </span>
                            </div>
                            <div class="am-blogs-select">
                                <span class="am-select" wire:ignore>
                                    <select class="am-select2" id="sort_by" data-searchable="false"
                                        data-class="am-sort_dp_option" data-placeholder="{{ __('blogs.sort_by') }}">
                                        <option value="">{{ __('blogs.sort_by') }}</option>
                                        <option value="asc" {{ request()->sort_by == 'asc' ? 'selected' : '' }}>{{ __('blogs.oldest_first') }}</option>
                                        <option value="desc" {{ request()->sort_by == 'desc' ? 'selected' : '' }}>{{__('blogs.newest_first')}}</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                @if($blogs->isNotEmpty())
                    @foreach($blogs as $blog)
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="am-allblogs_items am-blog-items">
                                <figure>
                                    @if(!empty($blog->image) && Storage::disk(getStorageDisk())->exists($blog->image))
                                        <img src="{{ resizedImage($blog->image, 416, 290) }}" alt="{{ $blog->title }}">
                                    @else
                                        <img src="{{ Storage::disk(getStorageDisk())->exists('blog-default.png') ? url(Storage::url('blog-default.png')) : asset('demo-content/placeholders/blog-default.png') }}" alt="{{ $blog->title }}">
                                    @endif
                                </figure>
                                <div class="am-allblogs_items_content">
                                    <div class="am-allblogs_items_content_date">
                                        <div class="am-blog-categories-content">
                                            @if (!empty($blog->categories))
                                                @foreach ($blog->categories as $key => $category)
                                                    <em>{{ $category?->name }}{{ $key < count($blog->categories) - 1 ? ',' : '' }}</em>
                                                @endforeach        
                                            @endif
                                        </div>
                                        <span>{{ $blog->updated_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="am-allblogs_items_content_title">
                                        <div class="am-blogs-check">
                                            <a target="_blank" href="{{ route('blog-details', $blog->slug) }}">
                                                <h4>{{ $blog->title }}</h4>
                                            </a>
                                            <a target="_blank" href="{{ route('blog-details', $blog->slug) }}">
                                                <span><i class="am-icon-arrow-top-right"></i></span>
                                            </a>    
                                        </div>
                                    </div>
                                    @php
                                        $description = strip_tags($blog->description);
                                        $shortDescription = Str::words($description, 50, '...');
                                    @endphp
                                    <p>{{ $shortDescription }}</p>
                                    @if (!empty($blog->tags))
                                        <ul class="am-allblogs_items_content_tags">
                                            @foreach ($blog->tags as $tag)
                                                <li><span>{{ $tag->name }}</span></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row">
                        <div class="am-blog-result">
                            <em><svg xmlns="http://www.w3.org/2000/svg" width="44" height="59" viewBox="0 0 44 59" fill="none">
                                    <path d="M37.3999 15.2007C39.8299 15.2007 41.7998 17.1706 41.7998 19.6007V48.2C41.7998 53.0601 37.86 56.9999 33 56.9999H11.0001C6.14004 56.9999 2.2002 53.06 2.2002 48.2V10.8009C2.2002 5.94082 6.14003 2.00098 11.0001 2.00098H24.2C26.63 2.00098 28.6 3.9709 28.6 6.40091V10.8008C28.6 13.2308 30.5699 15.2007 32.9999 15.2007H37.3999Z" stroke="#EAEAEA" stroke-width="3.29995" stroke-miterlimit="10"/>
                                    <path d="M21.5108 2H25.0236C27.3137 2 29.5136 2.89274 31.156 4.48862L39.1271 12.2338C40.8325 13.8908 41.7947 16.1674 41.7947 18.5451V26.2655" stroke="#EAEAEA" stroke-width="3.29995" stroke-miterlimit="10"/>
                                    <path d="M20.3476 43.7978C26.7265 43.7978 31.8975 38.6268 31.8975 32.248C31.8975 25.8693 26.7265 20.6982 20.3476 20.6982C13.9688 20.6982 8.79774 25.8693 8.79774 32.248C8.79774 38.6268 13.9688 43.7978 20.3476 43.7978Z" stroke="#EAEAEA" stroke-width="2.47496" stroke-miterlimit="10"/>
                                    <path d="M18.5666 30.8638C18.0822 31.6924 17.1825 32.2521 16.1584 32.2521C15.1249 32.2521 14.2284 31.6924 13.7471 30.8638" stroke="#EAEAEA" stroke-width="2.09005" stroke-miterlimit="10" stroke-linecap="round"/>
                                    <path d="M26.95 30.8638C26.4669 31.6972 25.5644 32.2609 24.5366 32.2609C23.4995 32.2609 22.6002 31.6972 22.1202 30.8638" stroke="#EAEAEA" stroke-width="2.09005" stroke-miterlimit="10" stroke-linecap="round"/>
                                    <path d="M20.3917 36.9302H20.4045" stroke="#EAEAEA" stroke-width="2.78674" stroke-linecap="round"/>
                                    <path d="M35.1916 47.0968L31.8916 43.7969" stroke="#EAEAEA" stroke-width="2.47496" stroke-miterlimit="10" stroke-linecap="round"/>
                                </svg>
                            </em>
                            <h4>{{ __('blogs.no_results_found') }}</h4>
                            <span>{{ __('blogs.no_results_found_description') }}</span>
                        </div>
                    </div>
                @endif
                
                @if($blogs->hasPages() && $blogs->isNotEmpty())
                    <div class="col-12">
                        {{ $blogs->links('pagination.pagination', ['blog' => true]) }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

@push('scripts')

<script>
    document.addEventListener('livewire:navigated', function() {

        component = @this;

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

        jQuery(document).on('change', '#sort_by', function (e){
            let value = $('#sort_by').select2("val");
            component.set('orderBy', value);
        });

        jQuery(document).on('change', '#per_page', function (e){
            let value = $('#per_page').select2("val");
            component.set('perPage', value);
        });

        jQuery(document).on('change', '#category_id', function (e){
            let value = $('#category_id').select2("val");
            component.set('category_id', value);
        });

        component.on('clear_filters', function() {
            $('#sort_by').val('desc').trigger('change');
            $('#per_page').val(null).trigger('change');
            $('#category_id').val(null).trigger('change');
        });
    });
</script>
@endpush
