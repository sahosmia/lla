<?php

use Livewire\Volt\Component;
use Diglactic\Breadcrumbs\Breadcrumbs;

new class extends Component
{

};
?>

<header class="am-header">
    {{ Breadcrumbs::render() }}
    <form class="am-header_form">
        <fieldset>
            <div class="form-group" @click="$dispatch('toggle-spotlight')">
                <i class="am-icon-search-02"></i>
                <input type="text" class="form-control" placeholder="{{ __('general.quick_search') }}">
                <span>{{ __('general.ctrl_k') }}</span>
            </div>
        </fieldset>
    </form>
    <div class="am-header_user">
        <x-frontend.user-menu />
    </div>
</header>