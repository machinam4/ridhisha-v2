@extends('base')
@section('page-title', 'M-pesa Shortcodes')
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
                    <h5>M-pesa Shortcodes</h5>
                    @error('secret')
                        <div class="alert alert-danger mt-3">
                            <div class="media align-items-center">
                                <i class="feather icon-alert-circle h2"></i>
                                <div class="media-body ml-3">
                                    {{ $message }}
                                </div>
                            </div>
                        </div>
                    @enderror
                </div>
                <div class="card-body">
                    <button class="btn btn-primary m-b-20 md-trigger" data-modal="modal-11">+ Add M-Pesa Shortcode</button>
                    <div class="dt-responsive table-responsive">
                        <table id="add-row-table" class="table  table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>Mpesa ShortCode</th>
                                    <th>Radio Stations</th>
                                    <th>Type</th>
                                    <th>Organization Name</th>
                                    <th>M-pesa Username</th>
                                    <th>Date Added</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mpesas as $mpesa)
                                    <tr>
                                        <td>{{ $mpesa->shortcode }}</td>
                                        <td>
                                            @foreach ($mpesa->radio as $radio)
                                                <ul>
                                                    <li>{{ $radio->radio->name }}</li>
                                                </ul>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($mpesa->type === 'till')
                                                Till / Buy Goods
                                            @else
                                                Paybill
                                            @endif
                                        </td>
                                        <td>{{ $mpesa->name }}</td>
                                        <td>{{ $mpesa->username }}</td>
                                        <td>{{ $mpesa->created_at }}</td>
                                        <td>
                                            <a type="button" class="btn btn-success"
                                                href="{{ Route('registerurl', $mpesa) }}">Register Url</a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteItem({{ $mpesa }})">Delete</button>

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

    {{-- Add mpesa ModaL --}}
    <div class="md-modal md-effect-11" id="modal-11">
        <div class="md-content">
            <h3 class="bg-primary">Add M-pesa</h3>
            <div>
                <form action="{{ Route('add_mpesa') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="exampleSelect1">Type</label>
                        <select class="form-control" id="exampleSelect1" name="type">
                            <option value="paybill">Paybill</option>
                            <option value="till">Till / Buy Goods</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ShortCode / HeadOffice</label>
                        <input type="text" name="shortcode" class="form-control" placeholder="Enter shortcode">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Organization Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Administrator Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Consumer Key</label>
                        <input type="password" name="key" class="form-control" placeholder="Consumer key">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Consumer Secret</label>
                        <input type="password" name="secret" class="form-control" placeholder="Consumer Secret">
                    </div>
                    <div class="form-group">
                        <label class="form-label">PassKey</label>
                        <input type="password" name="passkey" class="form-control" placeholder="passkey">
                    </div>
                    <button type="submit" class="btn btn-success mt-2 mb-2">Submit</button>
                </form>
                <div>

                    <button class="btn btn-light md-close">Cancel</button>
                </div>

            </div>
        </div>
    </div>
    {{-- Add mpesa ModaL --}}
@endsection

@section('page-js')
    <!-- datatable Js -->
    <script src="{{ asset('assets/plugins/data-tables/js/datatables.min.js') }}"></script>
    <!-- modal-window-effects Js -->

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
                        $.get('mpesas/delete/' + item.id, function(data) {
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
