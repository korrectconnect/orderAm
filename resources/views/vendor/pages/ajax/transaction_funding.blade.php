
<div class="card-header">
    <strong>
        Funding
    </strong>
</div>

<div class="card-body">
    @if ($funds->count() >= 1)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><i class="fa fa-clock"></i></th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>

            @foreach ($funds as $fund)

                <tr>
                    <td>{{$fund->created_at}}</td>
                    <td>
                        @if ($fund->amount < 0)
                            <span class="text-danger">{{$fund->amount}}</span>
                        @else
                            <span class="text-success">{{$fund->amount}}</span>
                        @endif
                    </td>
                    <td>{{$fund->description}}</td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
    @else
        <center>
            <p><i class="fa fa-list"></i>&nbsp; No transaction here</p>
        </center>
    @endif

</div>
