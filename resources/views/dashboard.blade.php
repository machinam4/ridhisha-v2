@extends('base')
@section('page-title', 'Dashboard')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/datatables.min.css') }}">
@endsection
@section('contents')
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- Add rows table start -->
        <div class="col-sm-12 col-md-12">
            <div class="col-md-3">
                <div class="card bg-c-blue order-card">
                    <div class="card-body">
                        <h6 class="m-b-20">Total Today</h6>
                        <h2 class="text-left"><span id="totalAmount">{{ $totalToday }}</span></h2>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</h5>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="add-row-table" class="table  table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dailyTotals as $total)
                                    <tr>
                                        <td>{{ $total->TransTime }}</td>
                                        <td>{{ $total->TransAmount }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>Date</td>
                                    <td>Amount</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add rows table end -->
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('page-js')
    <!-- datatable Js -->
    <script src="{{ asset('assets/plugins/data-tables/js/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var t = $('#add-row-table').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        })
    </script>
    {{-- <script src="{{asset('assets/js/pages/data-api-custom.js')}}"></script> --}}
@endsection
