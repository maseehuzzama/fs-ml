@extends('layouts.admin')
@section('content')
    <style>
        .filterable {
            margin-top: 15px;
        }
        .filterable .panel-heading .pull-right {
            margin-top: -20px;
        }
        .filterable .filters input[disabled] {
            background-color: transparent;
            border: none;
            cursor: auto;
            box-shadow: none;
            padding: 0;
            height: auto;
        }
        .filterable .filters input[disabled]::-webkit-input-placeholder {
            color: #333;
        }
        .filterable .filters input[disabled]::-moz-placeholder {
            color: #333;
        }
        .filterable .filters input[disabled]:-ms-input-placeholder {
            color: #333;
        }

    </style>

    <div id="page-wrapper">

    <div class="container-fluid">

        <div class="row">
            <h2>{{trans('general.all-orders')}}</h2>
            <div class="panel panel-primary filterable">
                <div class="panel-heading">
                    <h3 class="panel-title">{{trans('general.users')}}</h3>
                    <div class="pull-right">
                        <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr class="filters">
                            <th><input type="text" class="form-control" placeholder="{{trans('general.order-number')}}#" disabled></th>
                            <th><input type="text" class="form-control" placeholder="{{trans('general.shipment-details')}}" disabled></th>
                            <th><input type="text" class="form-control" placeholder="{{trans('general.origin')}}" disabled></th>
                            <th><input type="text" class="form-control" placeholder="{{trans('general.destination')}}" disabled></th>
                            <th><input type="text" class="form-control" placeholder="{{trans('general.pick-date')}}" disabled></th>
                            <th><input type="text" class="form-control" placeholder="{{trans('general.status')}}" disabled></th>
                            <th><input type="text" class="form-control" placeholder="{{trans('general.pick-agent')}}" disabled></th>
                            <th><input type="text" class="form-control" placeholder="{{trans('general.delivery-agent')}}" disabled></th>
                            <th><input type="text" class="form-control" placeholder="{{trans('general.actions')}}" disabled></th>
                        </tr>
                        </thead>
                        @foreach($allOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{route('admin.order',array($order->id,App::getLocale()))}}" title=""><b>{{$order->ref_number}}</b></a>
                                </td>
                                <td>{{$order->contains}}&nbsp;</td>
                                <td>{{@$order->s_city}}-{{@$order->s_regions->name}}&nbsp;</td>
                                <td>{{@$order->r_city}}-{{@$order->r_regions->name}}</td>
                                <td>{{$order->pick_date}}&nbsp;</td>
                                <td>{{$order->status}}&nbsp;</td>
                                <td>{{$order->pick_agent}}&nbsp;</td>
                                <td>{{$order->deliver_agent}}&nbsp;</td>
                                <td class="actions">
                                    <a href="{{route('admin.order',array($order->id,App::getLocale()))}}" class="{{(App::getLocale() === 'ar') ? 'pull-right':''}}" title="Update Status"><span class="label label-success">Show</span></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            {{ $allOrders->links() }}
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

    <script>
        $(document).ready(function(){
            $('.filterable .btn-filter').click(function(){
                var $panel = $(this).parents('.filterable'),
                        $filters = $panel.find('.filters input'),
                        $tbody = $panel.find('.table tbody');
                if ($filters.prop('disabled') == true) {
                    $filters.prop('disabled', false);
                    $filters.first().focus();
                } else {
                    $filters.val('').prop('disabled', true);
                    $tbody.find('.no-result').remove();
                    $tbody.find('tr').show();
                }
            });

            $('.filterable .filters input').keyup(function(e){
                /* Ignore tab key */
                var code = e.keyCode || e.which;
                if (code == '9') return;
                /* Useful DOM data and selectors */
                var $input = $(this),
                        inputContent = $input.val().toLowerCase(),
                        $panel = $input.parents('.filterable'),
                        column = $panel.find('.filters th').index($input.parents('th')),
                        $table = $panel.find('.table'),
                        $rows = $table.find('tbody tr');
                /* Dirtiest filter function ever ;) */
                var $filteredRows = $rows.filter(function(){
                    var value = $(this).find('td').eq(column).text().toLowerCase();
                    return value.indexOf(inputContent) === -1;
                });
                /* Clean previous no-result if exist */
                $table.find('tbody .no-result').remove();
                /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
                $rows.show();
                $filteredRows.hide();
                /* Prepend no-result row if all rows are filtered */
                if ($filteredRows.length === $rows.length) {
                    $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
                }
            });
        });
    </script>
@endsection