<main class="tb-main am-dispute-system am-blogs-system">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('blogs.blogs') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred {{ $selectedBlogs ? '' : 'd-none' }}" @click="$wire.dispatch('showConfirm', { action : 'delete-blog' })">{{ __('general.delete_selected') }}</a>
                                </div>
                                <a href="{{route('admin.create-blog')}}" class="tb-btn tb-menubtn">
                                    {{ __('blogs.add_blog') }} <i class="icon-plus"></i>
                                </a>
                                
                                <div class="tb-actionselect">
                                    <div class="tb-select" wire:ignore>
                                        <select id="filter_sort" class="form-control tk-select2">
                                            <option value="asc" {{ $sortby == 'asc' ? 'selected' : '' }}>{{ __('general.asc') }}</option>
                                            <option value="desc" {{ $sortby == 'desc' ? 'selected' : '' }}>{{ __('general.desc') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_per_page" class="form-control tk-select2">
                                            @foreach($perPageOptions as $opt)
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search" autocomplete="off" placeholder="{{ __('taxonomy.search_here') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if(!empty($blogs) && $blogs->count() > 0)
                        <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="tb-checkbox">
                                            <input id="checkAll" wire:model.lazy="selectAll" type="checkbox">
                                            <label for="checkAll">{{ __('general.title') }}</label>
                                        </div>
                                    </th>
                                    <th>{{__('Description')}}</th>
                                    <th>{{__('blogs.category')}}</th>
                                    <th>{{__('general.status')}}</th>
                                    <th>{{__('general.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $single)
                                    <tr>
                                        <td data-label="{{ __('title') }}">
                                            <div class="tb-checkboxwithimg">
                                                <div class="tb-checkbox">
                                                    <input id="blog_id{{ $single->id }}" wire:model.lazy="selectedBlogs" value="{{ $single->id }}" type="checkbox">
                                                    <label for="blog_id{{ $single->id }}">
                                                        <img src="{{ url(Storage::url($single->image)) }}" alt="{{ $single->title }}" width="100"> 
                                                        <span>
                                                            {!! $single->title !!}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('description') }}">
                                            <span class="fw-form-description">{{ \Illuminate\Support\Str::limit(strip_tags($single->description), 100) }}</span>
                                        </td>
                                        @if (!empty($single->categories))
                                            <td data-label="{{__('blogs.category')}}">
                                                @foreach ($single->categories as $key => $category)
                                                    <em class="am-blogs-category_em">{{ $category?->name }}{{ $key < count($single->categories) - 1 ? ',' : '' }}</em>
                                                @endforeach        
                                            </td>
                                        @endif
                                        <td data-label="{{__('general.status')}}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-{{ $single->status == 'published' ? 'active' : 'disabled' }}">{{ $single->status }}</em>
                                            </div>
                                        </td>
                                        <td data-label="{{__('general.actions')}}">
                                            <ul class="tb-action-icon">
                                                <li> <a href="{{ route('admin.update-blog', $single->id) }}"><i class="icon-edit-3"></i></a> </li>
                                                <li> <a href="{{ route('blog-details', ['slug' => $single->slug, 'source' => 'admin']) }}" target="_blank"><i class="icon-eye"></i></a> </li>
                                                <li>    
                                                    <a href="javascript:void(0);" 
                                                    @click="$wire.dispatch('showConfirm', { id: {{ $single->id }}, action: 'delete-blog' })" 
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
                        {{ $blogs->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')"/>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</main>
@push('styles')
    @vite([
        'public/summernote/summernote-lite.min.css',
    ])
@endpush

@push('scripts')
    <script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>

    <script type="text/javascript" data-navigate-once>
        document.addEventListener('livewire:navigated', function() {
            component = @this;
        });

        document.addEventListener('livewire:initialized', function() {
            jQuery('#filter_sort').on('change', function (e) {
                var selectedSort = $(this).val();
                component.set('sortby', selectedSort);
            });

            jQuery('#filter_per_page').on('change', function (e) {
                var selectedSort = $(this).val();
                component.set('perPage', selectedSort);
            });
        });
        
        
    </script>
@endpush
