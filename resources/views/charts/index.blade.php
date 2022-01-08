@extends('layouts.master')
@section('title', 'Distribution Summary')

@push('style')
S
@endpush

@push('custom-scripts')
@endpush

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="p-4 pr-5 border-bottom bg-light d-sm-flex justify-content-between">
        <h4 class="card-title mb-0">Pie chart</h4>
        <div id="pie-chart-legend" class="mr-4"></div>
      </div>
      <div class="card-body d-flex">
        <canvas class="my-auto" id="pieChart" height="130"></canvas>
      </div>
    </div>
</div>
@endsection