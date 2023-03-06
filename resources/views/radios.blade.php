@extends('base')
@section('page-title', 'Radio Stations')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/datatables.min.css') }}">
    <!-- modal-window-effects css  -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/modal-window-effects/css/md-modal.css') }}">
@endsection
@section('contents')
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- Add rows table start -->
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Radio Stations</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary m-b-20 md-trigger" data-modal="modal-11">+ Add Radio Station</button>
                    <div class="dt-responsive table-responsive">
                        <table id="add-row-table" class="table  table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Mpesa ShortCode</th>
                                    <th>Account</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($radios as $radio)
                                    <tr>
                                        <td>{{ $radio->name }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($radio->mpesas as $mpesa)
                                                    <li>{{ $mpesa->shortcode }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $radio->account }}</td>
                                        <td>{{ $radio->created_at }}</td>
                                        <td>
                                            <button class="btn btn-warning md-trigger"
                                                data-modal="modal-edit-{{ $radio->id }}">Edit</button>
                                            {{-- Add radio ModaL --}}
                                            <div class="md-modal md-effect-11" id="modal-edit-{{ $radio->id }}">
                                                <div class="md-content">
                                                    <h3 class="bg-primary">Edit {{ $radio->name }}</h3>
                                                    <div>
                                                        {{-- <div class="alert alert-primary">
                                                            <div class="media align-items-center">
                                                                <i class="feather icon-alert-circle h2"></i>
                                                                <div class="media-body ml-3">
                                                                    Basic HTML form components with custom style.
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <form action="{{ Route('update_radio', $radio) }}" method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label class="form-label">Name</label>
                                                                <input type="text" name="name"
                                                                    value="{{ $radio->name }}" class="form-control"
                                                                    placeholder="Enter name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Account</label>
                                                                <input type="text" name="account"
                                                                    value="{{ $radio->account }}" class="form-control"
                                                                    placeholder="Enter account">
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-success mt-2 mb-2">Submit</button>
                                                        </form>
                                                        <div>

                                                            <button class="btn btn-light md-close">Cancel</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Add radio ModaL --}}
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteItem({{ $radio }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add rows table end -->

    </div>
    <!-- [ Main Content ] end -->

    {{-- Add radio ModaL --}}
    <div class="md-modal md-effect-11" id="modal-11">
        <div class="md-content">
            <h3 class="bg-primary">Add radio</h3>
            <div>
                {{-- <div class="alert alert-primary">
                    <div class="media align-items-center">
                        <i class="feather icon-alert-circle h2"></i>
                        <div class="media-body ml-3">
                            Basic HTML form components with custom style.
                        </div>
                    </div>
                </div> --}}
                <form action="{{ Route('add_radio') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Account</label>
                        <input type="text" name="account" class="form-control" placeholder="Enter account">
                    </div>
                    <button type="submit" class="btn btn-success mt-2 mb-2">Submit</button>
                </form>
                <div>

                    <button class="btn btn-light md-close">Cancel</button>
                </div>

            </div>
        </div>
    </div>
    {{-- Add radio ModaL --}}
@endsection

@section('page-js')
    <!-- datatable Js -->
    <script src="{{ asset('assets/plugins/data-tables/js/datatables.min.js') }}"></script>
    <!-- modal-window-effects Js -->
    <script src="{{ asset('assets/plugins/modal-window-effects/js/classie.js') }}"></script>
    <script src="{{ asset('assets/plugins/modal-window-effects/js/modalEffects.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script>
        // [ sweet-warning ]
        function deleteItem(item) {
            swal({
                    title: "Delete " + item.name + "?",
                    text: "Once deleted, you will not be able to recover this item!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.get('radios/delete/' + item.id, function(data) {
                            swal("Poof! Your imaginary file has been deleted!", {
                                icon: "success",
                            });
                            location.reload()
                        })
                    }
                });
        };
    </script>
@endsection
