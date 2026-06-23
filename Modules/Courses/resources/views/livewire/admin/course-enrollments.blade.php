<main class="tb-main am-dispute-system am-enrollment-system">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('courses::courses.course_enrolments') .' ('. $orders->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control" data-searchable="false" data-live='true' id="sort_by" data-wiremodel="sortby" >
                                            <option value="asc" {{ $sortby == 'asc' ? 'selected' : '' }} >{{ __('general.asc')  }}</option>
                                            <option value="desc" {{ $sortby == 'desc' ? 'selected' : '' }} >{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if( !$orders->isEmpty() )
                        <table class="table tb-table tb-dbholder @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th>{{ __('courses::courses.id') }}</th>
                                    <th>{{ __('courses::courses.transaction_id') }}</th>
                                    <th>{{ __('courses::courses.course_title') }}</th>
                                    <th>{{ __('courses::courses.student_name') }}</th>
                                    <th>{{ __('courses::courses.tutor_name') }}</th>
                                    <th>{{ __('courses::courses.amount') }}</th>
                                    <th>{{ __('courses::courses.tutor_payout') }}</th>
                                    <th>{{ __('courses::courses.status') }}</th>
                                    <th>{{ __('courses::courses.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    @php
                                      
                                       $options = $order?->options ?? [];
                                       $courseTitle = $options['title'] ?? '';
                                       $image = $options['image'] ?? '';
                                       $tutor_payout = $order?->price - getCommission($order?->price);
                                    @endphp
                                    <tr>
                                        <td data-label="{{ __('courses::courses.id') }}"><span>{{ $order?->order_id }}</span></td>
                                        <td data-label="{{ __('courses::courses.transaction_id') }}"><span>{{$order?->orders?->transaction_id }}</span></td>
                                        <td data-label="{{ __('courses::courses.course_title' )}}">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    @if (!empty($image) && Storage::disk(getStorageDisk())->exists($image))
                                                        <img src="{{ resizedImage($image,34,34) }}" alt="{{$image}}" />
                                                    @else
                                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34) }}" alt="{{ $image }}" />
                                                    @endif
                                                </strong>
    
                                                <span>{{ $order?->orderable?->title }}<br>
                                                    <small>{{ $order->orderable?->category?->name ?? '' }}</small>
                                                </span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('booking.student_name' )}}">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    @if (!empty($order?->orders?->userProfile?->image) && Storage::disk(getStorageDisk())->exists($order?->orders?->userProfile?->image))
                                                    <img src="{{ resizedImage($order?->orders?->userProfile?->image,34,34) }}" alt="{{$order?->orders?->userProfile?->image}}" />
                                                    @else
                                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $order?->orderable?->student?->image }}" />
                                                    @endif
                                                </strong>
                                                <span>{{ $order?->orders?->userProfile?->full_name }}</span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('booking.tutor_name' )}}">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                   
                                                    @if (!empty($order?->orderable?->instructor->profile?->image) && Storage::disk(getStorageDisk())->exists($order?->orderable?->instructor->profile?->image))
                                                    <img src="{{ resizedImage($order?->orderable?->instructor->profile?->image,34,34) }}" alt="{{$order?->orderable?->instructor->profile?->image}}" />
                                                    @else 
                                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34) }}" alt="{{ $order?->orderable?->instructor->profile?->image }}" />
                                                    @endif
                                                </strong>
                                                <span>{{ $order?->orderable?->instructor->profile?->full_name }}</span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('courses::courses.amount') }}">
                                            <span>{!! formatAmount($order?->price) !!}</span>
                                        </td>
                                        <td data-label="{{ __('courses::courses.tutor_payout') }}">
                                            <span>{!! formatAmount($tutor_payout) !!}</span>
                                        </td>
                                        <td data-label="{{ __('courses::courses.status' )}}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag {{ $order?->orders?->status == 'complete' ? 'tk-hourly-tag' : 'tk-fixed-tag' }}">{{ $order?->orders?->status}}</em>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('courses::courses.course_enrolments_detail') }}">
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text">{{ __('courses::courses.view_details') }}</span>
                                                        <a href="{{ route('courses.course-detail', ['slug' => $order->orderable->slug]) }}" target="_blank">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
    
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                            {{ $orders->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
