<main class="tb-main tb-emailtemplatewrap">
    <div class ="row">
        @include('livewire.pages.admin.email-templates.update')
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('email_template.all_templates') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" >
                                    <div class="tb-select">
                                        <select class="am-select2 form-control" data-componentid="@this" data-live="true" data-searchable="false" data-wiremodel="sortby" id="sortby">
                                            <option value="asc">{{ __('general.asc')  }}</option>
                                            <option value="desc">{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" >
                                    <div class="tb-select">
                                        <select class="am-select2 form-control" data-componentid="@this" data-live="true" data-searchable="false" data-wiremodel="per_page" id="per_page">
                                            @foreach($per_page_opt as $opt )
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
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
            <div class="tb-disputetable tb-pagesemail">
                @if( !$listed_templated->isEmpty() )
                    <div class="tb-table-wrap">
                        <table class="table tb-table tb-dbholder @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th>{{ __('email_template.email_title') }} </th>
                                    <th>{{__('email_template.role_type')}}</th>
                                    <th>{{__('general.status')}}</th>
                                    <th>{{__('general.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listed_templated as $single)
                                    <tr>
                                        <td data-label="{{ __('email_template.email_title') }}"><span>{!! $single->title !!}</span></td>
                                        <td data-label="{{__('email_template.role_type')}}"><span>{{ ucfirst($single->role) }}</span></td>
                                        <td data-label="{{__('general.status')}}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-{{ $single->status == 'active' ? 'active' : 'disabled' }}">{{ $single->status == 'active' ? __('general.active') : __('general.deactive') }}</em>
                                            </div>
                                        </td>
                                        <td data-label="{{__('general.actions')}}">
                                            <ul class="tb-action-icon">
                                                <li> <a href="javascript:void(0);"  wire:click.prevent="edit({{ $single->id }})"><i class="icon-edit-3"></i></a> </li>
                                                <li> <a href="javascript:;"  @click="$wire.dispatch('showConfirm', { id : {{ $single->id }}, action : 'delete-template' })" class="tb-delete"><i class="icon-trash-2"></i></a> </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $listed_templated->links('pagination.custom') }}
                @else
                    <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                @endif
            </div>
        </div>
    </div>
</main>
