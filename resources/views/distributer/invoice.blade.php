<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>Print Invoice: {{ $dis->invoice_no }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    
    
	<style>
        .padding-15{
            padding : 15px;
        }
        .signature-box{
            border:1px solid black;
            padding:30px
        } 
	</style>
    
    
</head>
<body>
<div class="container-fluid">
    <h3 class="text-center">Invoice: {{$dis->invoice_no}}</h3>
    <div class="row justify-content-md-center">

        <div class="col-lg-12 grid-margin stretch-card">
            
            <div class="card">
            
                <div class="card-body">
                    <div class="border-bottom mb-3 row">
                        <div class="col-md-11">
                            <h4 class="card-title">Invoice - {{$dis->invoice_no}}</h4>
                        </div>
                        
                    </div>
                    
                    <div class="row" id="printarea">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <b>Date:</b> {{ date('d-m-Y',strtotime($dis->created_at)) }}
                                        </th>
                                        
                                        <th>
                                            <b>Invoice ID:</b> {{$dis->invoice_no}}
                                            
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr>
                                        <th>
                                            <b>Seller Details</b>
                                        </th>

                                        <th></th>

                                        <th>
                                            <b>Billing Details</b>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                        {!!$billing_add->details!!}
                                        </td>
                                        <td>
                                            <b>{{ $dis->user->firm_name }},</b>
                                            <br><br>
                                            {{  $dis->user->address }},
                                            <br>
                                            {{  $dis->user->district }},{{  $dis->user->state->name }},
                                            <br>
                                            {{ $dis->user->email }}
                                            <br>
                                            {{ $dis->user->mobile }}
                                            
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>GST</th>
                                        <th>Price</th>
                                        <th>Qty.</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php 
                                        $scgst = 0;
                                        $igst = 0;
                                    @endphp
                                    @foreach($dis->invoices as $in => $inv)
                                    <tr>
                                        <td>
                                            <b>{{$inv->item->name}}</b>
                                            <br>
                                            @php
                                                $tax = ($inv->product_price * $inv->item->gst_percent->percent)/100;
                                                $single_price = $inv->product_price-$tax;
                                                $scgst += $inv->scgst;
                                                $igst += $inv->igst;
                                            @endphp
                                            
                                        </td>
                                        <td> {{$inv->gst_percent}}% </td>
                                        <td>
                                            Rs. {{ number_format((float)$single_price, 2, '.', '')}}
                                        </td>
                                        <td valign="middle">
                                            {{ $inv->distributed_quantity }}
                                        </td>
                                        <td>
                                            <p><b>Price:</b> Rs.
                                                
                                                {{ round(($single_price*$inv->distributed_quantity),2) }}</p>
                                            
                                            <small class="help-block">(Price Multiplied with Qty.)</small>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                    @if(!empty($scgst))
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        
                                        <td>
                                            <b>SGST:</b>
                                        </td>
                                        <td>
                                        Rs.
                                        {{ round($scgst,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        
                                        <td>
                                            <b>CGST:</b>
                                        </td>
                                        <td>
                                        Rs.
                                        {{ round($scgst,2) }}
                                        </td>
                                    </tr>
                                    @endif
                                    @if(!empty($igst))
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        
                                        <td>
                                            <b>IGST:</b>
                                        </td>
                                        <td>
                                        Rs.
                                        {{ round($igst,2) }}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        
                                        <td>
                                            <b>Grand Total:</b>
                                        </td>
                                        <td>
                                        Rs.
                                        {{ round($dis->total_cost,2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table ">
                                <tr >
                                    <td width="50%">
                                        <label>Seller Signature:</label>
                                        <div class="signature-box">

                                        </div>
                                    </td>
                                    <td width="50%">
                                        <label>Customer Signature:</label>
                                        <div class="signature-box">

                                        </div>
                                    </td>
                                </tr>
                                
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
          
</body>
</html>
