@extends('layouts.master')
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


        .margin-top-20{
            margin-top: -20px;
        }
        .report-print{
            display: none;
        }
        .left{
            left:0;
        }
        .right{
            right:0;
        }

        @media print {
            .container {
                width:100%;
            }
            body * {
                visibility: hidden;
            }
            #print, #print * {
                visibility: visible;
            }
            #print .panel-heading{
                margin-top: -380px;
            }
            a[href]:after {
                content: none !important;
            }
            #not-print{
                display: none;
            }
            .not-print{
                display: none;
            }
            .report-print{
                display: inherit;
                padding: 10px;

            }
        }

    </style>
    <section class="page-title-section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
                        <div class="page-header">
                            <h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('general.report')}}</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
                            <li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
                            <li class="active">{{trans('general.report')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-padding">

        <div class="container">
            <div class="row">
                <div class="col-xs-9">
                    <form action="{{route('client.reports.orders-by-status',array(App::getLocale()))}}" method="post">
                        {{csrf_field()}}
                        <div class="col-xs-6 form-inline">
                            <select class="form-control" name="status">
                                <option value="">--select-status--</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status->name}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                            <input type="submit" class="form-control" value="{{trans('general.submit')}}">
                        </div>
                    </form>
                </div>
                <div class="col-xs-3">
                    <a class="btn btn-success btn-sm pull-right" style="margin-top: 10px" onclick="window.print();">Print</a>
                </div>

            </div>
            @if(count($orders) > 0)
                <div class="row">
                    <div class="panel panel-info filterable" id="print">
                        <div class="col-xs-12 report-print">
                            <div class="col-xs-6">
                                <span>{{date('d-m-Y')}}</span>
                            </div>
                            <div class="col-xs-6" style="position: relative;">
                                <img src="{{url('img/logo.png')}}" class="{{App::getLocale() == 'ar'?'left':'right'}}" style="height: 60px; position: absolute; top: 10px;">
                            </div>
                        </div>
                        <div class="panel-heading">
                            <h3 class="panel-title">Reports By Status:  {{@$stats}}
                                <button class="btn btn-default btn-sm btn-filter right"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="{{trans('general.order')}} {{trans('general.number')}}#" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="{{trans('general.shipment-details')}}" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="{{trans('general.origin')}}" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="{{trans('general.r_name')}}" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="{{trans('general.destination')}}" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="{{trans('general.pick-date')}}" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="{{trans('general.status')}}" disabled></th>
                                </tr>
                                </thead>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{route('admin.order',array($order->id,App::getLocale()))}}" title=""><b>{{$order->ref_number}}</b></a>
                                        </td>
                                        <td>{{$order->contains}}&nbsp;</td>
                                        <td>{{@$order->s_city}}-{{@$order->s_regions->name}}&nbsp;</td>
                                        <td>{{@$order->r_name}}</td>
                                        <td>{{@$order->r_city}}-{{@$order->r_regions->name}}</td>
                                        <td>{{$order->pick_date}}&nbsp;</td>
                                        <td>{{$order->status}}&nbsp;</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="report-print">
                            By: {{Auth::user()->name}}<br>
                        </div>
                    </div>
                </div>
            @else
                No Record found
            @endif
        </div>
        <!-- /.container-fluid -->

    </section>
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