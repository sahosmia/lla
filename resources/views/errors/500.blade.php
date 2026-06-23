@extends('errors::minimal')

@section('title', __('Server Error'))
@section('heading', __('general.505_title'))
@section('code', '500')
@section('message', __('Server Error'))
@section('message_desc', json_decode($exception->getMessage()) )
