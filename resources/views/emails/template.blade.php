<x-email.layout>
    <x-slot name="logo">
        <x-email.logo />
    </x-slot>
    <x-slot name="content">
        {!! $greeting ?? '' !!} <br /> <br />                               
        {!! $content ?? '' !!}
    </x-slot>
    <x-slot name="signature">
        {!! nl2br($signature) ?? '' !!}
    </x-slot>
    <x-slot name="copyright">
        {!! nl2br($copyright) ?? '' !!}
    </x-slot>
</x-email.layout>