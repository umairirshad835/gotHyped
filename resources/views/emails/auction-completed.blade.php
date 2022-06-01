<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Auction Completed Detail</title>
        <style type="text/css">
            .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }

            a {
                color: #5D6975;
                text-decoration: underline;
            }

            body {
                position: relative;
                width: 21cm;  
                height: 29.7cm; 
                margin: 0 auto; 
                color: #001028;
                background: #FFFFFF; 
                font-family: sans-serif; 
                font-size: 12px; 
            }

            header {
                padding: 10px 0;
                margin-bottom: 30px;
                font-size: 14px;
            }
            section{
                text-align: left;
                margin-top: 50px;
                width: 90%;
            }


            #logo {
                text-align: center;
                margin-bottom: 10px;
            }

            #logo img {
                width: 250px;
            }

            h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                color: #5D6975;
                font-size: 2.4em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;
                background: url(dimension.png);
            }

            #project {
                float: left;
            }

            #project span {
                color: #5D6975;
                text-align: right;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
            }

            #company {
                float: right;
                text-align: right;
            }

            #project div,
            #company div {
                white-space: nowrap;        
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
            }

            table tr:nth-child(2n-1) td {
                background: #F5F5F5;
            }

            .table tr:nth-child(2n-1) th {
                background: #F5F5F5;
            }
            .table th, td{
                border: 1px solid black;
            }

            table th,
            table td {
                text-align: center;
            }

            table th {
                padding: 5px 20px;
                color: #5D6975;
                white-space: nowrap;        
                font-weight: normal;
            }

            table .service,
            table .desc {
                text-align: left;
            }

            table td {
                padding: 20px;
                text-align: right;
            }

            table td.service,
            table td.desc {
                vertical-align: top;
            }

            table td.unit,
            table td.qty,
            table td.total {
                font-size: 1.2em;
            }

            table td.grand {
                border-top: 1px solid #5D6975;;
            }

            #notices .notice {
                color: #5D6975;
                font-size: 1.2em;
            }

            footer {
                color: #5D6975;
                width: 100%;
                height: 30px;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #C1CED9;
                padding: 8px 0;
                text-align: center;
            }
            header div{
                line-height: 1.6;
            }

        </style>
        
           
    </head>
    <body>
        <div>
            <header class="row" style="width: 90%;" class="clearfix">
                <div id="logo">
                    <img width="200px" height="100px" src="assets/images/brand/GH Logo.png">
                </div>

                <div style="float: right; width: 30%;" class="clearfix">
                    <img width="130px" height="100px" src="{{$product->image1}}">
                </div>
                <div style="float: left; width:60%" >
                    <div><span><b>Product Name :</b> {{$product->name ?? ''}}</span> </div>
                    <div><span><b>Product Description :</b> {{ \Illuminate\Support\Str::words($product->description ?? '',10, '>>>') }}</span> </div>
                    <div><span><b>Product Size :</b> 
                        @foreach($sizenames as $size)
                            {{ \Illuminate\Support\Str::words($size->name ?? '', 10, '>>>') }}@if ( ! $loop->last),@endif 
                        @endforeach
                        </span> </div>
                    <div><span><b>Actual Price :</b> ${{$product->actual_price ?? ''}}</span> </div>
                    <div><span><b>Market Price :</b> ${{$product->market_price ?? ''}}</span> </div>
                    
                    <br>
                    
                </div>
            </header>
            
            <table class="table" style="margin-top: 160px;width: 90%;">
                <tr>
                    <th class="service" ><span><b>Winner User Name</b></span></th>
                    <td class="desc">{{$customer->username ?? ''}}</td>
                </tr>
                <tr>
                    <th class="service" ><span><b>Winner Name</b></span></th>
                    <td class="desc">{{$customer->name ?? ''}}</td>
                </tr>
                <tr>
                    <th class="service" ><span><b>Winner Role</b></span></th>
                    <td class="desc">{{$customer->roles ?? ''}}</td>
                </tr>
                <tr>
                    <th class="service" ><span><b>Winner E-mail</b></span></th>
                    <td class="desc"><a href="mailto:">{{$customer->email ?? ''}}</a></td>
                </tr>
                <tr>
                    <th class="service"><span><b>Winner Phone</b></span></th>
                    <td class="desc">{{$customer->phone ?? ''}}</td>
                </tr>
                <tr>
                    <th class="service"><span><b>Winner Bid Used</b></span></th>
                    <td class="desc">{{$winner_bids->bid_used ?? ''}}</td>
                </tr>
                <tr>
                    <th class="service"><span><b>Total Bid Used</b></span></th>
                    <td class="desc">{{$completed->total_bids ?? ''}}</td>
                </tr>
                <tr>
                    <th class="service"><span><b>Real Bid Used</b></span></th>
                    <td class="desc">{{$real_bids ?? ''}}</td>
                </tr>
                <tr>
                    <th class="service"><span><b>Dummy Bid Used</b></span></th>
                    <td class="desc">{{$dummy_bids ?? ''}}</td>
                </tr>
                    <tr>
                        <th class="service"><span><b>Winning Price</b></span></th>
                        <td class="desc">${{$completed->auction_close_price ?? ''}}</td>
                    </tr>
                <tr>
                    <th class="service"><span><b>Check Out Method</b></span></th>
                    <td class="desc">
                        @if($completed->market_value_status == 1)
                            <span>Market Price</span> 
                        @elseif($completed->get_product_status == 1)
                            <span>Delivery</span>
                        @else
                            <span>N/A</span>      
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="service">
                        @if($completed->market_value_status == 1)
                            <span><b>Market Price</b></span>
                        @else
                        <span><b>Delivery Address </b></span>    
                        </th>
                        @endif
                    <td class="desc">
                        @if($completed->market_value_status == 1)
                            ${{$product->market_price ?? ''}}
                        @else
                            {{$shipping_Address->address->address ?? ''}}
                        @endif
                    </td>
                </tr>
                
            </table>

            <h3 style="margin-top: 50px;">Loser List</h3>
            <table style="margin-top: 10px;width: 90%;">
                <thead>
                    <tr>
                        <th style="font-weight:bold" class="service">Loser User Name</th>
                        <th style="font-weight:bold" class="service">User Role</th>
                        <th style="font-weight:bold" class="desc">Bids Lost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($losers as $loser)
                        <tr>
                            <td class="service">{{$loser->auctionLoser[0]->name ?? ''}}</td>
                            <td class="service">{{$loser->auctionLoser[0]->roles ?? ''}}</td>
                            <td class="desc">{{$loser->lost_bids ?? ''}}</td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </body>
</html>