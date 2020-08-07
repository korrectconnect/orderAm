@extends('admin.base')

@section('content')

<div class="row" style="margin: 0px !important; padding: 0px !important;">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-align-justify"></i> <b>Funding History</b></div>
            <div class="card-body">
                @if ($funds->count() >= 1)
                    <table class="table table-responsive-sm table-striped">
                        <thead>
                        <tr>
                            <th><i class="fa fa-clock"></i></th>
                            <th>Vendor</th>
                            <th>Amount</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($funds as $fund)
                                <tr>
                                    <td>{{$fund->created_at}}</td>
                                    <td>{{$fund->name}}</td>
                                    <td>
                                        @if ($fund->amount < 0)
                                            <span class="text-danger">&#8358;{{$fund->amount}}</span>
                                        @else
                                            <span class="text-success">&#8358;{{$fund->amount}}</span>
                                        @endif
                                    </td>
                                    <td>{{$fund->description}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <i class="fa fa-exclamation-circle"></i> No transaction here
                @endif

            </div>
        </div>

    </div>

</div>

@endsection

@section('javascript')

@endsection
