@extends('layouts.app', ['in_index' => $page->in_index])

@section('meta_title', $page->seo['meta_title'] ?? null)
@section('meta_description', $page->seo['meta_description'] ?? null)
@section('meta_keywords', $page->seo['meta_keywords'] ?? null)

@section('content')
  @if(!isset($page->extras['breadcrumbs']) || $page->extras['breadcrumbs'] === '1')
    {{ Breadcrumbs::render('page', $page) }}
  @endif

  {!! $page->trueContent !!}

@endsection

@push('footer')
{!! $schema_org !!}
@endpush
