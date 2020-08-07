@if ($funds->count() >= 1)
                    <table class="table table-responsive-sm table-striped">
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

