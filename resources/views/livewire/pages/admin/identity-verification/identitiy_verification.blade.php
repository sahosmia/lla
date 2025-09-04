<main class="tb-main am-dispute-system am-identitiy-system">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('general.all_identity_verification') .' ('. $users->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control" data-searchable="false" data-live='true' id="verification" data-wiremodel="verification" >
                                            <option value="" {{ $verification == '' ? 'selected' : '' }} >{{ __('identity.all_users')  }}</option>
                                            <option value="verified" {{ $verification == 'verified' ? 'selected' : '' }} >{{ __('identity.verified_users')  }}</option>
                                            <option value="non_verified" {{ $verification == 'non_verified' ? 'selected' : '' }} >{{ __('identity.non_verified_users')  }}</option>
                                        </select>
                                    </div>
                                </div>
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
                    @if( !$users->isEmpty() )
                        <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th>{{ __('#' )}}</th>
                                    <th>{{ __('general.name' )}}</th>
                                    <th>{{ __('identity.country')}}</th>
                                    <th>{{ __('identity.gaurdian_info' )}}</th>
                                    <th>{{ __('identity.school_info' )}}</th>
                                    <th>{{ __('identity.identity_document' )}}</th>
                                    <th>{{ __('identity.status' )}}</th>
                                    <th>{{__('identity.action' )}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $single)
                                    <tr>
                                        <td data-label="{{ __('#' )}}"><span>{{ $single?->id }}</span></td>
                                        <td data-label="{{ __('Name' )}}">
                                            <div class="tb-varification_userinfo">
                                                <a href="javascript:void(0);" class="identity-image" data-image="{{ Storage::url($single?->personal_photo) ?? '' }}">
                                                    <strong class="tb-adminhead__img">
                                                        @if (!empty($single?->personal_photo) && Storage::disk(getStorageDisk())->exists($single?->personal_photo))
                                                            <img src="{{ resizedImage($single?->personal_photo,34,34) }}" alt="{{$single?->personal_photo}}" />
                                                        @else
                                                            <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34) }}" alt="{{ $single?->personal_photo }}" />
                                                        @endif
                                                    </strong>
                                                </a>
                                                <span>{{ $single->name }}</span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('identity.country' )}}"><span>{{ $single?->address?->country?->name ? $single?->address?->country?->name : '-' }}</span></td>
                                        <td data-label="{{ __('identity.gaurdian_info' )}}">
                                            <span>
                                                {{ $single?->parent_name ?? '-' }}
                                                <span>{{ $single?->parent_phone}}</span>
                                                <span>{{ $single?->parent_email}}</span>
                                                <span>{{$single->parent_verified_at && "Verified"}}</span>
                                            </span>
                                        </td>
                                        <td data-label="{{ __('identity.school_info' )}}">
                                            <span>
                                                {{ $single?->school_id ?? '-' }}
                                                <span>{{ $single?->school_name}}</span>
                                            </span>
                                        </td>
                                        <td data-label="{{ __('identity.identity_document' )}}">
                                            <a href="javascript:void(0);" class="identity-image" data-type="attachment" data-image="{{ $single?->attachments ? Storage::url($single->attachments) : '' }}">
                                                <strong class="tb-adminhead__img">
                                                    @if (!empty($single?->attachments) && Storage::disk(getStorageDisk())->exists($single?->attachments))
                                                        <img src="{{ resizedImage($single?->attachments,34,34) }}" alt="{{$single?->attachments}}" />
                                                    @elseif (!empty($single?->transcript) && Storage::disk(getStorageDisk())->exists($single?->transcript))
                                                        <img src="{{ resizedImage($single?->transcript,34,34) }}" alt="{{$single?->transcript}}" />
                                                    @else
                                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34) }}" alt="{{ $single?->attachments }}" />
                                                    @endif
                                                </strong>
                                            </a>
                                        </td>
                                        <td data-label="{{ __('identity.status' )}}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag {{ $single?->status == 'accepted' ? 'tk-hourly-tag' : 'tk-fixed-tag' }}">{{ $single?->status }}</em>
                                            </div>
                                        </td>
                                        <td  data-label="{{__('identity.action')}}">
                                            <div class="am-resume_item_title">
                                                <div class="am-itemdropdown">
                                                    <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z" fill="#585858"/><path d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z" fill="#585858"/><path d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z" fill="#585858"/></svg></i>
                                                    </a>
                                                    <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        @if($single?->status != 'accepted')
                                                            <li @click="$wire.dispatch('showConfirm', { id : {{ $single->user_id }}, type : 'accepted' , action : 'verified-template' })">
                                                                <span>{{ __('identity.accept' )}}</span>
                                                            </li>
                                                        @endif
                                                        <li @click="$wire.dispatch('showConfirm', { id : {{ $single->user_id }}, type : 'rejected' , action : 'verified-template' })">
                                                            <span>{{ __('identity.reject' )}}</span>
                                                        </li>
                                                    </ul>   
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->links('pagination.custom') }}
                    @else
                    <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="identity-verification-image" tabindex="-1" aria-labelledby="identityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="identityModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <figure class="am-identity-image-placeholder am-noload-shimmer" id="identity-image-placeholder">
                        <img id="modal-identity-img" src="" alt="Image" class="img-fluid rounded" style="display: none;"/>
                    </figure>
                </div>
                <div class="am-deletepopup_btns">
                    <a href="javascript:void(0);" class="am-btn am-btnsmall am-cancel" data-bs-dismiss="modal">{{ __('general.cancel') }}</a>
                    <a href="javascript:void(0);" id="download-btn" class="am-btn am-btn-success am-confirm-yes">{{ __('identity.download') }}</a>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".identity-image").forEach(function (element) {
        element.addEventListener("click", function () {
            let imageUrl = this.getAttribute("data-image");
            let imageType = this.getAttribute("data-type");

            let title = (imageType === "attachment") ? "{{ __('identity.identity_document') }}" : "{{ __('identity.personal_photo') }}";
            let imgElement = document.getElementById("modal-identity-img");
            let placeholder = document.getElementById("identity-image-placeholder");

            if (imageUrl) {
                imgElement.style.display = "none"; 
                placeholder.classList.add("am-noload-shimmer");

                imgElement.onload = function () {
                    placeholder.classList.remove("am-noload-shimmer"); 
                    imgElement.style.display = "block"; 
                };

                imgElement.src = imageUrl;
                document.getElementById("identityModalLabel").textContent = title;

                let buttonContainer = document.querySelector(".am-deletepopup_btns");
                if (imageType === "attachment") {
                    buttonContainer.style.display = "flex";
                    document.getElementById("download-btn").setAttribute("wire:click", `download('${imageUrl}')`);
                } else {
                    buttonContainer.style.display = "none";
                }

                var modal = new bootstrap.Modal(document.getElementById("identity-verification-image"));
                modal.show();
            }
        });
    });
});
</script>
@endpush