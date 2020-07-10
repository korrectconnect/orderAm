<div class="card-header">
    <strong>
        Set range of date to filter transaction
    </strong>
</div>

<div class="card-body">

<center>


    <div style="width: 300px; height: auto; display:inline-block; margin-top:10px;">

        <form data-href="{{route('vendor.transaction.filter')}}" id="filterTransactionForm">

            <div class="form-group">
                <label for="start">Start</label>
                <input type="date" name="start" id="start" class="form-control">
            </div>

            <div class="form-group">
                <label for="end">End</label>
                <input type="date" name="end" id="end" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary btn-md" id="filterTransactionFormBtn">Filter</button>

        </form>

    </div>


</center>

</div>
