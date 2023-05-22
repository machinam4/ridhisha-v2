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
                    <h2 class="text-left">{{ $presenter->firstname . ' ' . $presenter->lastname }}</h2>
                    <p class="m-b-0 text-right">Total Sessions:
                        {{ $presenter->sessions->count() }} <span class="float-left">Total funds:
                            {{ $presenter->players->sum('TransAmount') }}</span></p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>{{ $presenter->firstname . ' ' . $presenter->lastname }}</h5>
                    <ul class="navbar-nav ml-auto">
                        @if ($presenter->insession())
                            <li>
                                <form action="{{ Route('stop_presenter_session', $presenter) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger" type="submit">END
                                        LIVE</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="add-row-table" class="table  table-striped table-bordered nowrap">

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
