<main class="tb-main am-dispute-system am-review-system">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('general.all_reviews') .' ('. $allTutorReviews->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="sort_by" data-wiremodel="sortby">
                                            <option value="asc" {{ $sortby=='asc' ? 'selected' : '' }}>{{ __('general.asc')
                                                }}</option>
                                            <option value="desc" {{ $sortby=='desc' ? 'selected' : '' }}>{{
                                                __('general.desc') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"
                                        autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if( !$allTutorReviews->isEmpty() )
                    <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                        <thead>
                            <tr>
                                <th>{{ __('#' )}}</th>
                                <th>{{ __('general.reviewer' )}}</th>
                                <th>{{ __('general.review_date' )}}</th>
                                <th>{{__('general.review_or_text')}}</th>
                                <th>{{__('general.tutor')}}</th>
                                <th>{{__('general.reviewed_on')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allTutorReviews as $single)
                            <tr>
                                <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                                <td data-label="{{ __('general.reviewer' )}}">
                                    <div class="tb-varification_userinfo">
                                        <strong class="tb-adminhead__img">
                                            @if (!empty($single?->profile?->image) && Storage::disk(getStorageDisk())->exists($single?->profile?->image))
                                                <img src="{{ resizedImage($single?->profile?->image,34,34) }}" alt="{{$single?->profile?->image}}" />
                                            @else
                                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $single?->profile?->image }}" />
                                            @endif
                                        </strong>
                                        <span>{{ $single?->profile?->full_name }}</span>
                                    </div>
                                </td>
                                <td data-label="{{ __('general.created_date' )}}"><span>{{ $single?->created_at?->format('F d, Y')}}</span></td>
                                <td data-label="{{__('general.review_or_text')}}">
                                    <div class="am-review-msg">
                                        <span><i class="icon-star"></i> {{ number_format($single?->rating, 1) }}/5.0</span>
                                        <div class="am-custom-tooltip">
                                            <span class="am-tooltip-text am-tooltip-review">
                                                <span>{{ $single?->comment }}</span>
                                            </span>
                                            <p>{{ $single?->comment }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="{{__('general.tutor')}}">
                                    <div class="tb-varification_userinfo">
                                        <strong class="tb-adminhead__img">
                                            @if (!empty($single?->tutor?->profile?->image) && Storage::disk(getStorageDisk())->exists($single?->tutor?->profile?->image))
                                                <img src="{{ resizedImage($single?->tutor?->profile?->image,34,34) }}" alt="{{$single?->tutor?->profile?->image}}" />
                                            @else
                                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $single?->tutor?->profile?->image }}" />
                                            @endif
                                        </strong>
                                        <span>{{ $single?->tutor?->profile?->full_name }}</span>
                                    </div>
                                </td>
                                @if($single?->ratingable_type == 'Modules\Courses\Models\Course')
                                    <td data-label="{{__('general.reviewed_on')}}">
                                        <div class="tb-varification_userinfo">
                                            <strong class="tb-adminhead__img">
                                                @if (!empty($single?->ratingable?->media?->path) && Storage::disk(getStorageDisk())->exists($single?->ratingable?->media?->path))
                                                    <img src="{{ resizedImage($single?->ratingable?->media?->path,34,34) }}" alt="Course Image" />
                                                @else
                                                    <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $single?->ratingable?->media?->path }}" />
                                                @endif
                                            </strong>
                                            <span>{{ $single?->ratingable?->title }}</span>
                                        </div>
                                    </td>
                                @else
                                    <td data-label="{{__('general.reviewed_on')}}">
                                        <div class="tb-varification_userinfo">
                                            <strong class="tb-adminhead__img">
                                                @if (!empty($single?->ratingable?->slot?->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($single?->ratingable?->slot?->subjectGroupSubjects?->image))
                                                    <img src="{{ resizedImage($single?->ratingable?->slot?->subjectGroupSubjects?->image,34,34) }}" alt="Subject Image" />
                                                @else
                                                    <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $single?->ratingable?->slot?->subjectGroupSubjects?->image }}" />
                                                @endif
                                            </strong>
                                            <span>{{ $single?->ratingable?->slot?->subjectGroupSubjects?->subject?->name }}</span>
                                        </div>
                                    </td`>
                                @endif

                                <td data-label="{{__('general.actions')}}">
                                    <div class="am-custom-tooltip">
                                        <span class="am-tooltip-text am-tooltip-textimp">
                                            <span>{{__('general.remove_review')}}</span>
                                        </span>
                                        <i @click="$wire.dispatch('showConfirm', { id : {{ $single->id }}, action : 'delete-review', title: '{{ __('general.delete_review') }}', 
                                            content: '{{ __('general.delete_review_content') }}', icon: 'delete' })" class="icon-trash-2"></i>
                                    </div> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $allTutorReviews->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')"  :title="__('general.no_record_title')"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
