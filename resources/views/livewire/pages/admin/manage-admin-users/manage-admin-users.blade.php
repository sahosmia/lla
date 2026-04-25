<main class="tb-main am-dispute-system am-user-system" wire:init="loadData"> 
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('general.all_sub_admins') .' ('. $users->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:void(0)" id="add_user_click" class="tb-btn add-new"
                                       wire:click="openModel()">{{__('general.add_new_sub_admin')}}
                                        <i class="icon-plus"></i></a>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="filter_user"
                                            data-wiremodel="filterUser">
                                            <option value="" {{ $filterUser=='' ? 'selected' : '' }}>{{ __('general.all_sub_admins') }}
                                            </option>
                                            <option value="active" {{ $filterUser=='active' ? 'selected' : '' }}>{{
                                                __('Active') }}</option>
                                            <option value="inactive" {{ $filterUser=='inactive' ? 'selected' : '' }}>{{
                                                __('Inactive') }}</option>
                                        </select>
                                    </div>
                                </div>
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
                    @if( !$users->isEmpty() )
                    <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                        <thead>
                            <tr>
                                <th>{{ __('#' )}}</th>
                                <th>{{ __('Name' )}}</th>
                                <th>{{ __('general.email' )}}</th>
                                <th>{{ __('general.created_date' )}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $single)
                            <tr>
                                <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                                <td data-label="{{ __('Name' )}}">
                                    <div class="tb-varification_userinfo">
                                        <strong class="tb-adminhead__img">
                                            @if (!empty($single->profile->image) && Storage::disk(getStorageDisk())->exists($single->profile->image))
                                                <img src="{{ resizedImage($single->profile->image,34,34) }}" alt="{{$single->profile->image}}" />
                                            @else
                                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $single->profile->image }}" />
                                            @endif
                                        </strong>
                                        <span>{{ $single->profile->full_name }}</span>
                                        @if($single->roles()->first()->name == 'tutor')
                                            <a href="{{ route('tutor-detail',['slug' => $single->profile->slug]) }}" class="am-custom-tooltip">
                                                <span class="am-tooltip-text">
                                                    <span>{{ __('general.visit_profile') }}</span>
                                                </span>
                                                <i class="icon-external-link"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="{{ __('general.email' )}}"><span>{{ $single->email }}</span></td>
                                <td data-label="{{ __('general.created_date' )}}"><span>{{ $single->created_at->format('F d,
                                        Y')}}</span></td>
                               
                    
                                <td @click="$wire.dispatch('showConfirm', { id : {{ $single->id }}, content: `{{ $single->status == 'active' ? __('general.disable_user') : __('general.enable_user') }}`, type: '{{ $single->status }}', action : 'update-status' })"
                                    data-label="{{__('general.status')}}">
                                    <em class="tk-project-tag {{  $single->status == 'active' ? 'tk-hourly-tag' : 'tk-fixed-tag' }}">{{
                                        $single->status}}</em>
                                </td>
                                <td  data-label="{{__('general.actions')}}">
                                    <div class="am-custom-tooltip">
                                        <span class="am-tooltip-text am-tooltip-textimp">
                                            <span>{{__('general.remove_user')}}</span>
                                        </span>
                                        <i @click="$wire.dispatch('showConfirm', { id : {{ $single->id }}, content: '{{ __('general.delete_admin') }}', action : 'delete-user' })" class="icon-trash-2"></i>
                                    </div> 
                                    <div class="am-custom-tooltip am-tooltip-textimp">
                                        <a href="javascript:void(0);" wire:click="editAdminUser({{ $single->id }})"><i class="icon-edit-3"></i></a>
                                    </div> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')"  :title="__('general.no_record_title')"/>
                    @endif
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade tb-addonpopup" id="tb-add-user" aria-labelledby="tb_user_info_label"
            role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg tb-modaldialog" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h5 id="tb_user_info_label">{{__('general.sub_admin_information')}}</h5>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <form class="tb-themeform" wire:submit.prevent="addUser" id="add_user_form">
                            <fieldset>
                                <div class="form-group-wrap">
                                    <div class="form-group">
                                        <label class="tb-label tb-important">{{__('general.first_name')}}</label>
                                        <input type="text"
                                            class="form-control @error('form.first_name') tk-invalid @enderror"
                                            wire:model="form.first_name" placeholder="{{__('general.name_placeholder')}}">
                                        @error('form.first_name')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label tb-important">{{__('general.last_name')}}</label>
                                        <input type="text"
                                            class="form-control @error('form.last_name') tk-invalid @enderror"
                                            wire:model="form.last_name"
                                            placeholder="{{__('general.lastname_placeholder')}}">
                                        @error('form.last_name')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>                  
                                    <div class="form-group">
                                        <label class="tb-label tb-important">{{__('general.email')}}</label>
                                        <input type="text" class="form-control @error('form.email') tk-invalid @enderror"
                                            wire:model="form.email" placeholder="{{__('general.email_placeholder')}}">
                                        @error('form.email')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label @if(empty($form->adminId)) tb-important @endif">{{__('general.password')}}</label>
                                        <input type="password" wire:model="form.password"
                                            class="form-control @error('form.password') tk-invalid @enderror"
                                            placeholder="{{__('general.password_placeholder')}}">
                                        @error('form.password')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group am-knowlanguages @error('form.permissions') am-invalid @enderror">
                                        <x-input-label for="Slots" class="tb-label tb-important" :value="__('general.permissions')" />
                                        <div id="user_lang" class="am-multiple-select-wrap">
                                            <span class="am-select am-multiple-select">
                                                <select data-componentid="@this" data-parent="#tb-add-user"  data-disable_onchange="true" class="languages am-select2" data-searchable="true" id="permissions" data-wiremodel="form.permissions" multiple placeholder="{{ __('general.permissions') }}" >
                                                    <option value="" disabled>{{ __('general.permissions') }}</option>
                                                    @foreach ( $permissions as $id => $permission)
                                                        <option value="{{ $id }}" @if( in_array( $id, $form->permissions) ) selected @endif>{{ $permission }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="languageList">
                                                    @if (!empty( $form->permissions))
                                                        <ul class="tu-labels">
                                                            @foreach ( $form->permissions as $permission_id )
                                                                <li><span>{{ $permissions[$permission_id] }} <a href="javascript:void(0);" class="removeSelectedLang" data-id="{{ $permission_id }}"><i class="icon-x"></i></a></span></li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </span>
                                        </div>
                                        @error('form.permissions')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group tb-formbtn">
                                        <button class="tb-btn" type="submit" wire:target="addUser" wire:loading.class="tb-btn_disable">{{__('general.save_update')}}</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script type="text/javascript">
    var component = '';
    document.addEventListener('livewire:navigated', function() {
        component = @this;
    });
    document.addEventListener('livewire:initialized', function() {
        document.addEventListener('loadPageJs', (event) => {
            component.dispatch('initSelect2', {target:'.am-select2'});
        })

        $(document).on("change", ".languages", function(e){
            component.set('form.permissions', $(this).select2("val"), false);
            populateLanguageList();
        });

        $( "body" ).delegate( ".removeSelectedLang", "click", function() {
            let id = $(this).attr('data-id');
            var newArray = [];
            new_data = $.grep($('.languages').select2('data'), function (value) {
                if(value['id'] != id)
                    newArray.push(value['id']);
            });
            $('.languages').val(newArray).trigger('change');
            populateLanguageList();
        });

        function populateLanguageList(){
            let languages = $('.languages').select2('data');
            var lang_html = '<ul class="tu-labels">';
            $.each(languages,function(index,elem){
                    lang_html += `<li><span>${elem.text} <a href="javascript:void(0);" class="removeSelectedLang" data-id="${elem.id}"><i class="icon-x"></i></a></span></li>`;
            });
            lang_html += '</ul>';
            $('.languageList').html(lang_html);
        }
    });   
</script>
@endpush