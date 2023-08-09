@extends('layouts.app')

@section('page_title', 'Entries List')

@section('header')
    <div>Sample Header</div>
@endsection

@section('content')
    <style>
        table{
            width: 100%;
        }
        td{
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 5px;
            padding-right: 5px;
        }
        thead{
            background: #cfcfcf;
        }
        thead tr td:first-child{
            border-radius: 4px 0px 0px 4px;
        }
        thead tr td:last-child{
            border-radius: 0px 4px 4px 0px;
        }
        tbody tr td:first-child{
            border-radius: 4px 0px 0px 4px;
        }

        tbody tr td:last-child{
            border-radius: 0px 4px 4px 0px;
        }
        tbody tr:nth-child(odd){
            background: #ececec;
        }
        tbody tr:hover{
            background: #e2f2f9;
        }
        .title-header{
            margin-bottom: 30px;
        }
    </style>
    <div class="container">
        <!-- Display validation errors if any -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Display success message if any -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Entry creation form -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('entries.store') }}">
                    <div class="modal-body">
                        <div id="response-message"></div>

                            @csrf
                            <div class="form-group">
                                <label for="title">Name of the Stock</label>
                                <input type="text" class="form-control" id="title" name="stock_name" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Invested Amount</label>
                                <input type="number" class="form-control" id="title" name="investment" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Purchased Nav Value</label>
                                <input type="number" class="form-control" id="title" name="nav_value" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Total Nav Purchased</label>
                                <input type="number" class="form-control" id="title" name="total_nav" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Purchased Date</label>
                                <input type="text" class="form-control" id="title" name="purchase_date" required>
                            </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="entry-form">Create Entry</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
<div class="row">
    <div class="row title-header">
        <div class="col-md-6">
            <h2>List of Shares Purchased</h2>
        </div>
        <div class="col-md-6" style="text-align: right">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add new
            </button>
        </div>
    </div>
      <div class="col-md-12">
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <td>Purchased Date</td>
                    <td>Stock Name</td>
                    <td>Nav Value During Purchase</td>
                    <td>Total Nav Purchased</td>
                    <td>Total Invested</td>
                </tr>
                </thead>
                <tbody>
                @if(!count($entries))
                    <tr>
                        <td colspan="5" class="text-center">No Data Found</td>
                    </tr>
                @endif
                @foreach ($entries as $entry)
                    <tr>
                        <td>{{ $entry->formatted_purchase_date }}</td>
                        <td>{{ $entry->stock_name }}</td>
                        <td>{{ $entry->nav_value }}</td>
                        <td>{{ $entry->total_nav }}</td>
                        <td>{{ $entry->investment}}<br/></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
      </div>
</div>

        @push('scripts')
        <script>
            $(document).ready(function() {
                const createModal = document.querySelector('#createModal')
                $('#entry-form').on('click',function(event) {
                    event.preventDefault();
                    let rc = requiredCheck();
                    let stock_name=$('[name="stock_name"]').val(),
                        investment=$('[name="investment"]').val(),
                        nav_value=$('[name="nav_value"]').val(),
                        total_nav=$('[name="total_nav"]').val(),
                        purchase_date=$('[name="purchase_date"]').val();
                    if(rc) {
                        $.ajax({
                            url: '{{ route("entries.store") }}',
                            method: 'POST',
                            data: {
                                'stock_name': stock_name,
                                'investment': investment,
                                'nav_value': nav_value,
                                'total_nav': total_nav,
                                'purchase_date': purchase_date,
                                // ... other fields ...
                                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                            },
                            success: function (response) {
                                $('.btn-close').click();
                                window.location.reload();
                            },
                            error: function (xhr) {
                                $('#response-message').text('Error: ' + xhr.responseText);
                            }
                        });
                    }
                    else {
                        alert('All fields are required');
                    }
                });
                createModal.addEventListener('hidden.bs.modal', event => {
                    $('input').val('');
                    $('#response-message').text('')
                })
                function requiredCheck(){
                    let chk = true;
                    $('[required]').each(function (){
                        let v = $(this).val();
                        if((v === '')||(chk === false)){
                            chk = false;
                        }
                        else {
                            chk = true;
                        }
                    })
                    return chk;
                }
            });
        </script>
        @endpush
    </div>
@endsection


