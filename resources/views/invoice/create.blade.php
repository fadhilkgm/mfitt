@extends('layouts.master')

@section('title', 'Invoice | ')
@section('content')
@include('partials.header')
@include('partials.sidebar')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Add Invoice</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Invoice</li>
            <li class="breadcrumb-item"><a href="#">Add Invoice</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Invoice</h3>
                <div class="tile-body">
                    <form method="POST" action="{{ route('invoice.store') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label class="control-label">Customer Name </label>
                                <input type="text" id="customer-name-input" name="customer_name"
                                    placeholder="Customer Name" value="{{ old('customer_name') }}"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    autocomplete="off">
                                <div id="customer-suggestions" style="display: none;" class="suggestions"></div>
                                <input type="hidden" id="customer-id" name="customer_id"
                                    value="{{ old('customer_id') }}">
                                @error('customer_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <input type="hidden" id="customers-data" value="{{ json_encode($customers) }}">
                            <div class="form-group col-md-3">
                                <label class="control-label">Mobile Number </label>
                                <input name="customer_phone" id="customer-phone"
                                    class="form-control @error('customer_phone') is-invalid @enderror" type="text"
                                    placeholder="Mobile Number" value="{{ old('customer_phone') }}">
                                @error('customer_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Place </label>
                                <input name="place" id="place" class="form-control @error('place') is-invalid @enderror"
                                    type="text" placeholder="Place" value="{{ old('place') }}">
                                @error('place')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Payment Method</label>
                                <select name="payment_method" class="form-control">
                                    <option value="Cash">Cash</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Date</label>
                                <input name="date" class="form-control datepicker" value="{{ date('Y-m-d') }}"
                                    type="date">
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 30%;">Product</th>
                                    <th scope="col" style="width: 15%;">Unit</th>
                                    <th scope="col" style="width: 10%;">quantity</th>
                                    <th scope="col" style="width: 10%;">Price</th>
                                    <th scope="col" style="width: 10%;">Amount</th>
                                    <th scope="col" style="width: 20%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="product-row">
                                        <input type="text" name="product_name[]" placeholder="Product Name"
                                            class="form-control productname" autocomplete="off">
                                        <div class="custom-suggestions suggestions" style="display: none;"></div>
                                        <input type="hidden" name="product_id[]" class="product-id">
                                        <input type="hidden" id="products-data" value="{{ json_encode($products) }}">
                                    </td>
                                    <td><select name="unit[]" class="form-control unit">
                                            <option value="">Select Unit</option>
                                            <option value="M">Meter</option>
                                            <option value="In">Inch</option>
                                            <option value="Ft">Feet</option>
                                            <option value="Pc">Piece</option>
                                        </select></td>
                                    <td><input type="number" name="quantity[]" class="form-control count"
                                            style="width: 80px;" value="1"></td>
                                    <td><input type="text" name="price[]" placeholder="Price" class="form-control price"
                                            style="width: 100px;"></td>
                                    <td><input type="text" name="amount[]" placeholder="Amount"
                                            class="form-control amount" style="width: 100px;"></td>
                                    <td>
                                        <a class="btn btn-danger text-white remove ">
                                            <i class="fa fa-remove"></i>
                                        </a>
                                        <a class="btn btn-success text-white ml-2 addRow">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"></td>
                                    <td><b>Discount</b><br><input type="text" name="discount" class="form-control dis"
                                            value="0" style="width: 100px;"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td><b>Paid Amount</b><br><input type="text" class="form-control paid" name="paid"
                                            placeholder="Paid">
                                    </td>
                                    <td><b>Balance Amount</b><br><input type="text" class="form-control balance"
                                            name="balance" placeholder="Balance"></td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td><b>Total</b></td>
                                    <td><b class="total"></b> <input type="hidden" class="total-input" name="total">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary mr-2" type="submit">Submit</button>
                            <a href="{{ route('invoice.index') }}" class="btn btn-info">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>









</main>

@endsection
@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="{{asset('/')}}js/multifield/jquery.multifield.min.js"></script>




<script type="text/javascript">
    $(document).ready(function () {
        const products = JSON.parse($('#products-data').val());

        $(document).on('input keyup', '.productname', function () {
            const $input = $(this);
            const query = $input.val().toLowerCase();
            const $suggestionsContainer = $input.siblings('.custom-suggestions');
            $suggestionsContainer.empty();

            if (query) {
                const filteredProducts = products.filter(product =>
                    product.name.toLowerCase().includes(query)
                );

                filteredProducts.forEach(product => {
                    const suggestionItem = $('<div>').text(product.name);
                    suggestionItem.on('click', function () {
                        $input.val(product.name);
                        $input.siblings('.product-id').val(product.id);
                        $suggestionsContainer.empty();

                        $.ajax({
                            type: 'GET',
                            url: "{!! URL::route('findPrice') !!}",
                            dataType: 'json',
                            data: { "_token": $('meta[name="csrf-token"]').attr('content'), 'id': product.id },
                            success: function (data) {
                                const $tr = $input.closest('tr');
                                $tr.find('.price').val(data.price);
                                $tr.find('.unit').val(data.unit);
                                calculateAmount($tr);
                                total();
                            }
                        });
                    });
                    $suggestionsContainer.append(suggestionItem);
                });

                $suggestionsContainer.show();
            } else {
                $suggestionsContainer.hide();
                const $tr = $input.closest('tr');
                $tr.find('.product-id').val('');
                $tr.find('.count').val(1);
                $tr.find('.price').val('');
                $tr.find('.amount').val('');
                $('.paid').val('');
                $('.balance').val('');
                total();
            }
        });

        $(document).click(function (event) {
            if (!$(event.target).closest('.productname, .custom-suggestions').length) {
                $('.custom-suggestions').hide();
            }
        });

        function calculateAmount(tr) {
            var count = parseFloat(tr.find('.count').val()) || 0;
            var price = parseFloat(tr.find('.price').val()) || 0;
            var amount = count * price;
            tr.find('.amount').val(amount.toFixed(2));
        }

        $('tbody').on('keyup change', '.count, .price', function () {
            var tr = $(this).closest('tr');
            calculateAmount(tr);
            total();
        });

        function total() {
            var total = 0;
            $('.amount').each(function () {
                var amount = parseFloat($(this).val()) || 0;
                total += amount;
            });

            var discount = parseFloat($('.dis').val()) || 0;
            total -= discount;

            $('.total').html(total.toFixed(2));
            $('.total-input').val(total.toFixed(2));

            $('.paid').val(total.toFixed(2));
            $('.balance').val(0);
        }

        $('.dis').on('keyup change', function () {
            total();
        });
        $('.balance').on('keyup change', function () {
            var total = $('.total').html();
            var balance = $(this).val();
            $('.paid').val(total - balance);
        });


        $('.paid').on('keyup', function () {
            var total = $('.total').html();
            var paid = $(this).val();
            $('.balance').val(total - paid);
        });

        $('.addRow').on('click', function () {
            addRow();
        });

        function addRow() {
            var addRow = '<tr>\n' +
                '    <td class="product-row">\n' +
                '        <input type="text" name="product_name[]" placeholder="Product Name" class="form-control productname" autocomplete="off">\n' +
                '        <div class="custom-suggestions suggestions" style="display:none;"></div>\n' +
                '        <input type="hidden" name="product_id[]" class="product-id">\n' +
                '    </td>\n' +
                '  <td><select name="unit[]" class="form-control unit"><option value="">Select Unit</option><option value="M">Meter</option><option value="In">Inch</option><option value="Ft">Feet</option><option value="Pc">Piece</option></select></td>\n' +
                '    <td><input type="number" value="1" name="quantity[]" class="form-control count" style="width: 80px;"></td>\n' +
                '    <td><input type="text" name="price[]" placeholder="Price" class="form-control price" style="width: 100px;"></td>\n' +
                '    <td><input type="text" name="amount[]" placeholder="Amount" class="form-control amount" style="width: 100px;"></td>\n' +
                '    <td><a class="btn btn-danger remove"><i class="fa text-white fa-remove"></i></a></td>\n' +
                '</tr>';
            $('tbody').append(addRow);
        }

        $('tbody').on('click', '.remove', function () {
            var l = $('tbody tr').length;
            if (l == 1) {
                alert('You can\'t delete the last one');
            } else {
                $(this).closest('tr').remove();
                total();
            }
        });

        const customers = JSON.parse($('#customers-data').val());

        $('#customer-name-input').on('input', function () {
            const query = $(this).val().toLowerCase();
            const suggestionsContainer = $('#customer-suggestions');
            suggestionsContainer.empty();

            if (query) {
                const filteredCustomers = customers.filter(customer =>
                    customer.name.toLowerCase().includes(query)
                );

                filteredCustomers.forEach(customer => {
                    const suggestionItem = $('<div>').text(customer.name);
                    suggestionItem.on('click', function () {
                        $('#customer-name-input').val(customer.name);
                        $('#customer-id').val(customer.id);
                        $('#customer-phone').val(customer.phone);
                        $('#place').val(customer.place);
                        suggestionsContainer.empty();
                    });
                    suggestionsContainer.append(suggestionItem);
                });

                suggestionsContainer.show();
            } else {
                suggestionsContainer.hide();
            }
        });

        $(document).click(function (event) {
            if (!$(event.target).closest('#customer-name-input, #customer-suggestions').length) {
                $('#customer-suggestions').hide();

            }
        });
        $("#customer-name-input").on('keyup', function () {
            $('#customer-phone').val('');
            $('#customer-id').val('');
            $('#place').val('');
        })

    });





</script>

@endpush
