<main class="tb-main tb-subject-wrap">
    <div class ="row">
        <div class="col-lg-4 col-md-12 tb-md-40">
            <div class="tb-dbholder tb-packege-setting">
                <div class="tb-dbbox tb-dbboxtitle">
                    @if($editMode)
                        <h5> {{ __('taxonomy.update_subject') }}</h5>
                    @else
                        <h5> {{ __('taxonomy.add_subject') }}</h5>
                    @endif
                </div>
                <div class="tb-dbbox">
                    <form class="tk-themeform">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group">
                                    <label class="tb-label">{{ __('general.name') }}</label>
                                    <input type="text" class="form-control @error('name') tk-invalid @enderror "  wire:model="name" required placeholder="{{ __('general.name') }}">
                                    @error('name')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="tb-label">{{ __('general.description') }}</label>
                                    <textarea class="form-control" placeholder="{{ __('general.description') }}" wire:model="description" id=""></textarea>
                                </div>
                                <div class="form-group tb-dbtnarea">
                                    <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                        @if($editMode)
                                            {{ __('taxonomy.update_subject') }}
                                        @else
                                            {{ __('general.add_now') }}
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('taxonomy.subjects') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred {{ $selectedSubjects ? '' : 'd-none' }}"  @click="$wire.dispatch('showConfirm', { action : 'delete-subject' })" >{{ __('general.delete_selected') }}</a>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model.live="sortby" class="form-control tk-select2">
                                            <option value="asc">{{ __('general.asc')  }}</option>
                                            <option value="desc">{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model.live="perPage" class="form-control tk-select2">
                                            @foreach($perPageOptions as $opt )
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"  autocomplete="off" placeholder="{{ __('taxonomy.search_here') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="tb-disputetable tb-pageslanguage">
                @if(!empty($subjects) && $subjects->count() > 0)
                    <div class="tb-table-wrap">
                        <table class="table tb-table tb-dbholder @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="tb-checkbox">
                                            <input id="checkAll" wire:model.lazy="selectAll"  type="checkbox">
                                            <label for="checkAll">{{ __('general.name') }}</label>
                                        </div>
                                    </th>
                                    <th>{{__('general.description')}}</th>
                                    <th>{{__('general.status')}}</th>
                                    <th>{{__('general.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjects as $single)
                                    <tr>
                                        <td data-label="{{ __('taxonomy.name') }}">
                                            <div class="tb-checkboxwithimg">
                                                <div class="tb-checkbox">
                                                    <input id="subject_id{{ $single->id }}" wire:model.lazy="selectedSubjects" value="{{ $single->id }}" type="checkbox">
                                                    <label for="subject_id{{ $single->id }}">
                                                        <span>
                                                            {!! $single->name !!}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="{{__('general.description')}}"><span>{!! $single->description !!}</span></td>
                                        <td data-label="{{__('general.status')}}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-{{ $single->status == 'active' ? 'active' : 'disabled' }}">{{ $single->status }}</em>
                                            </div>
                                        </td>
                                        <td data-label="{{__('general.actions')}}">
                                            <ul class="tb-action-icon">
                                                <li> <a href="javascript:void(0);" wire:click.prevent="edit({{ $single->id }})"><i class="icon-edit-3"></i></a> </li>
                                                <li> <a href="javascript:void(0);" @click="$wire.dispatch('showConfirm', { id : {{ $single->id }}, action : 'delete-subject' })"  class="tb-delete"><i class="icon-trash-2"></i></a> </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                        {{ $subjects->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
