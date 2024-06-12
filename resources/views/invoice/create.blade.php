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
                                <label class="control-label">Customer Name (optional)</label>
                                <input type="text" name="customer_name" placeholder="Customer Name"
                                    class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Mobile Number (optional)</label>
                                <input name="customer_phone" class="form-control" type="text"
                                    placeholder="Mobile Number">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Payment Method</label>
                                <select name="payment_method" class="form-control">
                                    <option value="Cash">Cash</option>
                                    <option value="Online">GPay/Paytm/PhonePe</option>
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
                                    <th scope="col" style="width: 10%;">Quantity</th>
                                    <th scope="col" style="width: 10%;">No of items</th>
                                    <th scope="col" style="width: 10%;">Price</th>
                                    <th scope="col" style="width: 15%;">Discount %</th>
                                    <th scope="col" style="width: 15%;">Amount</th>
                                    <!-- <th scope="col" style="width: 5%;"></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="product_id[]" class="form-control productname">
                                            <option>Select Product</option>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="input-group" style="width: 120px;">
                                            <input type="text" name="qty[]" class="form-control qty">
                                            <div class="input-group-append">
                                                <span class="input-group-text unit"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" name="count[]" class="form-control count"
                                            style="width: 80px;"></td>
                                    <td><input type="text" name="price[]" class="form-control price"
                                            style="width: 100px;"></td>
                                    <td><input type="text" name="dis[]" class="form-control dis" value="0"
                                            style="width: 100px;"></td>
                                    <td><input type="text" name="amount[]" class="form-control amount"
                                            style="width: 100px;"></td>
                                    <td><a class="btn btn-danger remove"><i class="fa fa-remove"></i></a></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"></td>
                                    <td><b>Total</b></td>
                                    <td><b class="total"></b></td>
                                    <td><a class="addRow badge badge-success text-white p-2"><i class="fa fa-plus"></i>
                                            Add
                                            Row</a></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div>
                            <button class="btn btn-primary" type="submit">Submit</button>
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
        $('tbody').on('change', '.productname', function () {
            var tr = $(this).closest('tr');
            var id = tr.find('.productname').val();
            $.ajax({
                type: 'GET',
                url: '{!! URL::route('findPrice') !!}',
                dataType: 'json',
                data: { "_token": $('meta[name="csrf-token"]').attr('content'), 'id': id },
                success: function (data) {
                    tr.find('.price').val(data.sales_price);
                    tr.find('.unit').text(data.unit);
                    tr.find('.qty').val(data.quantity);
                }
            });
        });

        $('tbody').on('keyup', '.count,.price,.dis', function () {
            var tr = $(this).closest('tr');
            var count = tr.find('.count').val();
            var price = tr.find('.price').val();
            var dis = tr.find('.dis').val();
            var amount = (count * price) - (count * price * dis) / 100;
            tr.find('.amount').val(amount);
            total();
        });

        function total() {
            var total = 0;
            $('.amount').each(function () {
                var amount = $(this).val() - 0;
                total += amount;
            });
            $('.total').html(total);
        }

        $('.addRow').on('click', function () {
            addRow();
        });

        function addRow() {
            var addRow = '<tr>\n' +
                '    <td><select name="product_id[]" class="form-control productname">\n' +
                '        <option value="0" selected="true" disabled="true">Select Product</option>\n' +
                '        @foreach($products as $product)\n' +
                '            <option value="{{ $product->id }}">{{ $product->name }}</option>\n' +
                '        @endforeach\n' +
                '    </select></td>\n' +
                '    <td>\n' +
                '        <div class="input-group" style="width: 120px;">\n' +
                '            <input type="text" name="qty[]" class="form-control qty">\n' +
                '            <div class="input-group-append">\n' +
                '                <span class="input-group-text unit"></span>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </td>\n' +
                '    <td><input type="text" name="count[]" class="form-control count" style="width: 80px;"></td>\n' +
                '    <td><input type="text" name="price[]" class="form-control price" style="width: 100px;"></td>\n' +
                '    <td><input type="text" name="dis[]" class="form-control dis" value="0" style="width: 100px;"></td>\n' +
                '    <td><input type="text" name="amount[]" class="form-control amount" style="width: 100px;"></td>\n' +
                '    <td><a class="btn btn-danger remove"><i class="fa fa-remove"></i></a></td>\n' +
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
    });

</script>

@endpush