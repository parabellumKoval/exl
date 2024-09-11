@extends('layouts.app', ['in_index' => $page->in_index])

@section('meta_title', $page->seo['meta_title'] ?? null)
@section('meta_description', $page->seo['meta_description'] ?? null)
@section('meta_keywords', $page->seo['meta_keywords'] ?? null)

@section('content')
    {!! $page->trueContent !!}

    <x-review.form />
    <x-review.items />
@endsection

@push('footer')
{!! $schema_org !!}
@endpush