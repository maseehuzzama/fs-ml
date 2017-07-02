@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <h2>Customer #ID -  {{$customer->id}}
                    <small>
                        <a href="#" data-toggle="modal" data-target="#transferModal" class="btn btn-primary">Transfer Amount</a>
                        <a href="#" onclick="goBack()" class="btn btn-info"><i class="fa fa-arrow-left"></i>Back</a>
                    </small>
                </h2>
                <div class="message col-xs-12">
                    @if (session('unsuccess'))
                        <h3 class="text-danger" style="padding:20px; background: #e3e3e3; border: orange 1px solid;">{{ session('unsuccess') }}</h3>
                    @endif
                    @if (session('success'))
                        <p class="text-success" style="padding:20px; background: #e3e3e3; border: green 1px solid;  ">{{ session('success') }}</p>
                    @endif
                </div>
                <div class="col-sm-12 col-md-6">
                    <h3>User Details</h3>
                   <ul class="list-unstyled">
                       <li><b>Name:</b>&nbsp;<span>{{$customer->name}}</span></li>
                       <li><b>UserName:</b>&nbsp;<span>{{$customer->username}}</span></li>
                       <li><b>Email:</b>&nbsp;<span>{{$customer->email}}</span></li>
                       <li><b>Phone:</b>&nbsp;<span>{{$customer->phone}}</span></li>
                       <li><b>City:</b>&nbsp;<span>{{$customer->city}}</span></li>
                   </ul>
                </div>
                <div class="col-sm-12 col-md-6">
                    <h3>Account Details</h3>
                    <ul class="list-unstyled">
                        <li><b>Fullname:</b>&nbsp;<span>{{@$customer->accounts->fullname}}</span></li>
                        <li><b>Bank:</b>&nbsp;<span>{{@$customer->accounts->bank_name}}</span></li>
                        <li><b>IBAN:</b>&nbsp;<span>{{@$customer->accounts->iban}}</span></li>
                        <li><b>Amount in Wallet :</b>&nbsp;<span>{{@$customer->accounts->wallet_amount}}</span></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive" style="padding-top:10px;">
                    <h3>Store Lists</h3>
                    <table class="table table-bordered">
                        <tbody>
                        <tr class="primary">
                            <th class="text-center">S.N</th>
                            <th class="text-center">Store Name</th>
                            <th class="text-center">Street</th>
                            <th  class="text-center">Neighbourhood</th>
                            <th  class="text-center">City</th>
                        </tr>
                        <?php $i =1; ?>
                        @foreach(@$stores as $store)
                            <tr class="info text-center">
                                <td>{{@$i++}}</td>
                                <td>{{@$store->name}}</td>
                                <td>{{@$store->street}}</td>
                                <td>{{@$store->neighbors->name}}</td>
                                <td>{{@$store->city}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!--table-responsive close-->
            </div>

        </div>
        <!-- /.container-fluid -->

        <div id="transferModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Transfer Amount</h4>
                    </div>
                    <div class="modal-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{route('admin.transfer-client-amount',array($customer->id,$customer->email,App::getLocale()))}}" enctype="multipart/form-data">
                            {{csrf_field()}}

                            <input type="hidden" name="current_amount" id="current_amount" value="{{@$customer->accounts->wallet_amount}}">
                            <div class="form-group">
                                <label for="amount_type">Amount  Type[required]</label>
                                <select id="amount_type" name="amount_type" class="form-control" required>
                                    <option value="">--select amount--</option>
                                    <option value="current">Current Amount</option>
                                    <option value="other">Other Amount</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount [required]</label>
                                <input type="text" id="amount" name="amount"  class="form-control" required="required" readonly="true" value="{{@$customer->accounts->wallet_amount}}">
                            </div>
                            <div class="form-group">
                                <label for="reference">Reference [required]</label>
                                <input type="text" id="reference" name="reference"  class="form-control" required="required" placeholder="Reference String">
                            </div>
                            <div class="form-group">
                                <label for="file">Reference Copy [Not required, But recommended]</label>
                                <input type="file" id="transfer_file"  name="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Update">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
    <script>
        $(function () {
            $("#amount_type").change(function () {
                var current_amount = $("#current_amount").val();
                if($(this).val() == 'current') {
                    $("#amount").val(current_amount);
                   $("#amount").attr("readonly","true");
                } else {
                    $("#amount").removeAttr("readonly");
                    $("#amount").val("");
                    $("#amount").focus();
                }
            });
        });
    </script>

@endsection