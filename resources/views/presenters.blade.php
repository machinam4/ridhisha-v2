@extends('base')
@section('page-title', 'Presenters')
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
                    <h5>Presenters</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary m-b-20 md-trigger" data-modal="modal-11">+ Add Presenter</button>
                    <div class="dt-responsive table-responsive">
                        <table id="add-row-table" class="table  table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>Names</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Radio</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($presenters as $presenter)
                                    <tr>
                                        <td>{{ $presenter->firstname }} {{ $presenter->lastname }}</td>
                                        <td>{{ $presenter->username }}</td>
                                        <td>{{ $presenter->email }}</td>
                                        <td>{{ $presenter->radio->name }}</td>
                                        <td>{{ $presenter->created_at }}</td>
                                        <td>
                                            <button class="btn btn-warning md-trigger"
                                                data-modal="modal-edit-{{ $presenter->id }}">Edit</button>
                                            {{-- Add presenter ModaL --}}
                                            <div class="md-modal md-effect-11" id="modal-edit-{{ $presenter->id }}">
                                                <div class="md-content">
                                                    <h3 class="bg-primary">Edit
                                                        {{ $presenter->firstname . ' ' . $presenter->lastname }}</h3>
                                                    <div>
                                                        <form action="{{ Route('update_presenter', $presenter) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label class="form-label">First Name</label>
                                                                <input type="text" name="firstname"
                                                                    value="{{ $presenter->firstname }}"
                                                                    class="form-control" placeholder="Enter first name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Last Name</label>
                                                                <input type="text" name="lastname"
                                                                    value="{{ $presenter->lastname }}" class="form-control"
                                                                    placeholder="Enter last name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Username</label>
                                                                <input type="text" name="username"
                                                                    value="{{ $presenter->lastname }}" class="form-control"
                                                                    placeholder="Enter Login Username">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Email address</label>
                                                                <input type="email" name="email"
                                                                    value="{{ $presenter->email }}" class="form-control"
                                                                    placeholder="Enter email">
                                                            </div>
                                                            {{-- <div class="form-group">
                                                                <label class="form-label" for="exampleSelect1">Radio
                                                                    Station</label>
                                                                <select class="form-control" id="exampleSelect1"
                                                                    name="radio_id">
                                                                    @foreach ($radios as $radio)
                                                                        <option value="{{ $radio->id }}"
                                                                            @selected($radio->id === $presenter->radio->id)>
                                                                            {{ $radio->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div> --}}
                                                            <button type="submit"
                                                                class="btn btn-success mt-2 mb-2">Submit</button>
                                                        </form>
                                                        <div>

                                                            <button class="btn btn-light md-close">Cancel</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Add presenter ModaL --}}
                                            <button type="button" class="btn btn-success"
                                                onclick="window.location='{{ Route('presenter_view', $presenter) }}';">View
                                                Records</button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteItem({{ $presenter }})">Delete</button>
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

    {{-- Add presenter ModaL --}}
    <div class="md-modal md-effect-11" id="modal-11">
        <div class="md-content">
            <h3 class="bg-primary">Add Presenter</h3>
            <div>
                <form action="{{ Route('add_presenter') }}" method="post">
                    @csrf
                    <input type="hidden" name="role" value="presenter">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" name="firstname" class="form-control" placeholder="Enter first name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lastname" class="form-control" placeholder="Enter last name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
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
                        <label class="form-label" for="exampleSelect1">Radio Station</label>
                        <select class="form-control" id="exampleSelect1" name="radio_id">
                            @foreach ($radios as $radio)
                                <option value="{{ $radio->id }}">{{ $radio->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success mt-2 mb-2">Submit</button>
                </form>
                <div>

                    <button class="btn btn-light md-close">Cancel</button>
                </div>

            </div>
        </div>
    </div>
    {{-- Add presenter ModaL --}}
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
                    title: "Delete " + item.firstname + " " + item.lastname + "?",
                    text: "Once deleted, you will not be able to recover this item!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.get('presenters/delete/' + item.id, function(data) {
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
