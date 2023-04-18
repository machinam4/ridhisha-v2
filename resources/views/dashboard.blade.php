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
                            {{-- if admin --}}
                            @if (auth()->user()->role === 'admin')
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
                                <tfoot>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tfoot>
                                </tbody>
                            @else
                                {{-- if presenter --}}
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Session Start</th>
                                        <th>Session End</th>
                                        <th>Duration</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dailyTotals as $session)
                                        <tr>
                                            <td>{{ $session->created_at->format('d-M-Y') }}</td>
                                            <td>{{ $session->created_at->format('H:i:s') }}</td>
                                            @if ($session->created_at->diffInMinutes($session->updated_at) === 0)
                                                <td class="fw-bold text-warning">Ongoing</td>
                                                <td>{{ $session->created_at->diffInMinutes(now()) }}
                                                    &nbsp;Minutes
                                                </td>
                                            @else
                                                <td>{{ $session->updated_at->format('H:i:s') }}</td>
                                                <td>{{ $session->created_at->diffInMinutes($session->updated_at) }}
                                                    &nbsp;Minutes
                                                </td>
                                            @endif

                                            <td>
                                                <h5 class=" text-success">{{ $session->players->sum('TransAmount') }}</h5>
                                            </td>
                                        </tr>
                                    @endforeach
                                <tfoot>
                                    <th>Date</th>
                                    <th>Session Start</th>
                                    <th>Session End</th>
                                    <th>Duration</th>
                                    <th>Amount</th>
                                </tfoot>
                                </tbody>
                                {{-- end table --}}
                            @endif
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
                    [2, 'desc']
                ],
            });
        })
    </script>
    {{-- <script src="{{asset('assets/js/pages/data-api-custom.js')}}"></script> --}}
@endsection
