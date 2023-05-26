@extends('base')
@section('page-title', 'Radios')
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
                    <h5>Radios</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary m-b-20 md-trigger" data-modal="modal-11">+ Add Radio</button>
                    <div class="dt-responsive table-responsive">
                        <table id="add-row-table" class="table  table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>Names</th>
                                    <th>Username</th>
                                    <th>ShortCode</th>
                                    <th>Account</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($radios as $radio)
                                    <tr>
                                        <td>{{ $radio->name }}</td>
                                        <td>{{ $radio->username }}</td>
                                        <td>{{ $radio->shortcode }}</td>
                                        <td>{{ $radio->account }}</td>
                                        <td>{{ $radio->created_at }}</td>
                                        <td>
                                            <button class="btn btn-warning md-trigger"
                                                data-modal="modal-edit-{{ $radio->id }}">Edit</button>
                                            {{-- Add radio ModaL --}}
                                            <div class="md-modal md-effect-11" id="modal-edit-{{ $radio->id }}">
                                                <div class="md-content">
                                                    <h3 class="bg-primary">Edit
                                                        {{ $radio->name }}</h3>
                                                    <div>
                                                        <form action="{{ Route('update_radio', $radio) }}" method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label class="form-label">Radio Name</label>
                                                                <input type="text" name="name"
                                                                    value="{{ $radio->name }}" class="form-control"
                                                                    placeholder="Enter first name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Username</label>
                                                                <input type="text" name="username"
                                                                    value="{{ $radio->username }}" class="form-control"
                                                                    placeholder="Enter Login Username">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label" for="exampleSelect1">Mpesa</label>
                                                                <select class="form-control" id="exampleSelect1"
                                                                    name="shortcode">
                                                                    @foreach ($mpesas as $mpesa)
                                                                        <option value="{{ $mpesa->shortcode }}"
                                                                            @selected($mpesa->shortcode == $radio->shortcode)>
                                                                            {{ $mpesa->shortcode }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label" for="exampleSelect1">Type</label>
                                                                <select class="form-control" id="exampleSelect1"
                                                                    name="shortcode">
                                                                    <option value="paybill" @selected($radio->type == 'paybill')>
                                                                        Paybill</option>
                                                                    <option value="till" @selected($radio->type == 'till')>
                                                                        Till/Buy Goods</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Account</label>
                                                                <input type="text" name="account"
                                                                    value="{{ $radio->account }}" class="form-control"
                                                                    placeholder="Enter Account">
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
                                            <button type="button" class="btn btn-success"
                                                onclick="window.location='{{ Route('radio_view', $radio) }}';">View
                                                Records</button>
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
            <h3 class="bg-primary">Add Radio</h3>
            <div>
                <form action="{{ Route('add_radio') }}" method="post">
                    @csrf
                    <input type="hidden" name="role" value="radio">
                    <div class="form-group">
                        <label class="form-label">Radio Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter first name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter Login Username">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                            placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="exampleSelect1">Mpesa</label>
                        <select class="form-control" id="exampleSelect1" name="shortcode">
                            @foreach ($mpesas as $mpesa)
                                <option value="{{ $mpesa->shortcode }}">{{ $mpesa->shortcode }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="exampleSelect1">Type</label>
                        <select class="form-control" id="exampleSelect1" name="shortcode">
                            <option value="paybill">Paybill</option>
                            <option value="till">Till/Buy Goods</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Account</label>
                        <input type="text" name="account" class="form-control" placeholder="Enter Account">
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
