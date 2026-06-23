<main class="tb-main am-dispute-system am-courses-system">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4>{{ __('trainingcalendar::trainingcalendar.all_trainings') }} ({{ $trainings->total() }})</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform" onsubmit="event.preventDefault();">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.400ms="keyword"
                                        autocomplete="off" placeholder="{{ __('general.search') }}...">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if (!$trainings->isEmpty())
                        <table class="tb-table table tb-dbholder">
                            <thead>
                                <tr>
                                    <th>{{ __('courses::courses.id') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.title') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.tutor') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.event_datetime') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.registered_count') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.status') }}</th>
                                    <th>{{ __('courses::courses.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainings as $training)
                                    <tr>
                                        <td data-label="{{ __('courses::courses.id') }}">
                                            <span>{{ $training->id }}</span>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.title') }}">
                                            <div class="tb-varification_userinfo">
                                                <span>
                                                    <strong>{{ $training->title }}</strong><br>
                                                    <small class="text-muted">{{ ucfirst($training->type) }}</small>
                                                </span>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.tutor') }}">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    @if(!empty($training->tutor?->profile?->image))
                                                        <img src="{{ asset('storage/' . $training->tutor->profile->image) }}" alt="Tutor" />
                                                    @else
                                                        <div class="avatar-placeholder-circle bg-indigo">
                                                            {{ substr($training->tutor?->profile?->first_name ?? 'T', 0, 1) }}
                                                        </div>
                                                    @endif
                                                </strong>
                                                <span>
                                                    {{ $training->tutor?->profile?->full_name ?? (($training->tutor?->profile?->first_name ?? '') . ' ' . ($training->tutor?->profile?->last_name ?? '')) }}
                                                </span>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.event_datetime') }}">
                                            <span>{{ $training->event_datetime ? \Carbon\Carbon::parse($training->event_datetime)->format('M d, Y • h:i A') : '-' }}</span>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.registered_count') }}">
                                            <span>
                                                <strong>{{ $training->paid_registrations_count ?? 0 }}</strong> / {{ $training->max_seats ?? '∞' }}
                                            </span>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.status') }}">
                                            <div class="am-status-tag">
                                                <em @class([
                                                    'tk-project-tag',
                                                    'tk-active' => $training->status == 'published',
                                                    'tk-hourly-tag' => $training->status == 'draft',
                                                    'tk-fixed-tag' => $training->status == 'cancelled',
                                                ])>{{ ucfirst($training->status) }}</em>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('courses::courses.actions') }}">
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text">{{ __('courses::courses.view_details') }}</span>
                                                        <a href="{{ route('trainingcalendar.detail', $training->slug) }}" target="_blank">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text">Delete</span>
                                                        <a href="javascript:void(0);" @click="$wire.dispatch('showConfirm', { id : {{ $training->id }}, action : 'delete-training' })" class="tb-delete">
                                                            <i class="icon-trash-2"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                    @endif
                </div>
                {{ $trainings->links('pagination.custom') }}
            </div>
        </div>
    </div>
</main>



@push('styles')
<style>
    .avatar-placeholder-circle {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #e0e7ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        border: 1px solid #c7d2fe;
    }
    .tb-varification_userinfo strong img {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endpush