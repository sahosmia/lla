<main class="tb-main am-dispute-system am-enrollment-system">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4>{{ __('trainingcalendar::trainingcalendar.all_registrations') }} ({{ $registrations->total() }})</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform" onsubmit="event.preventDefault();">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.400ms="keyword" autocomplete="off" placeholder="{{ __('general.search') }}...">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if(!$registrations->isEmpty())
                        <table class="table tb-table tb-dbholder @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.training') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.name') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.email') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.phone') }}</th>
                                    <th>{{ __('trainingcalendar::trainingcalendar.tutor') }}</th>
                                    <th>{{ __('courses::courses.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $registration)
                                    <tr>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.id') }}">
                                            <div class="tb-varification_userinfo">
                                                <span>
                                                    <strong>{{ $registration->training?->id }}</strong><br>
                                                </span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.training') }}">
                                            <div class="tb-varification_userinfo">
                                                <span>
                                                    <strong>{{ $registration->training?->title }}</strong><br>
                                                    <small class="text-muted">{{ ucfirst($registration->training?->type) }}</small>
                                                </span>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.name') }}">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    <div class="avatar-placeholder-circle">
                                                        {{ substr($registration->name ?? 'S', 0, 1) }}
                                                    </div>
                                                </strong>
                                                <span>{{ $registration->name }}</span>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.email') }}">
                                            <span>{{ $registration->email }}</span>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.phone') }}">
                                            <span>{{ $registration->phone }}</span>
                                        </td>

                                        <td data-label="{{ __('trainingcalendar::trainingcalendar.tutor') }}">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    @if(!empty($registration->training?->tutor?->profile?->image))
                                                        <img src="{{ asset('storage/' . $registration->training->tutor->profile->image) }}" alt="Tutor" />
                                                    @else
                                                        <div class="avatar-placeholder-circle bg-indigo">
                                                            {{ substr($registration->training?->tutor?->profile?->first_name ?? 'T', 0, 1) }}
                                                        </div>
                                                    @endif
                                                </strong>
                                                <span>
                                                    {{ ($registration->training?->tutor?->profile?->first_name ?? '') . ' ' . ($registration->training?->tutor?->profile?->last_name ?? '') }}
                                                </span>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('courses::courses.actions') }}">
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text">{{ __('courses::courses.view_details') }}</span>
                                                        <a href="{{ route('trainingcalendar.detail', $registration->training?->slug) }}" target="_blank">
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
                        
                        <div class="mt-4">
                            {{ $registrations->links('pagination.custom') }}
                        </div>
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                    @endif
                </div>
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
        background: #f1f5f9;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        border: 1px solid #e2e8f0;
    }
    .avatar-placeholder-circle.bg-indigo {
        background: #e0e7ff;
        color: #4f46e5;
    }
    .tb-varification_userinfo strong img {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endpush