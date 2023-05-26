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
            <div class="card bg-c-blue order-card">
                <div class="card-body">
                    <h6 class="m-b-20"><a href="{{ url()->previous() }}" type="submit"
                            class="btn btn-success mt-2 mb-2">Back</a></h6>
                    <h2 class="text-left">{{ $radio->name }}</h2>
                    <p class="m-b-0 text-right">Shortcode: {{ $radio->shortcode }} <span class="float-left">Account :
                            {{ $radio->account }}</span></p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>{{ $radio->name }}</h5>
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
                                @foreach ($dailyTotals as $totals)
                                    <tr>
                                        <td>{{ $totals->TransTime }}</td>
                                        <td>{{ $totals->TransAmount }}</td>
                                    </tr>
                                @endforeach
                            <tfoot>
                                <th>Date</th>
                                <th>Amount</th>
                            </tfoot>
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
