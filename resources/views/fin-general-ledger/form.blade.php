<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">Reference</div>
            <div class="col-md-6">Transaction Date</div>
        </div>

        <div class="row">
            <div class="col-md-6">
<!--                <h3>{{$Reference}}</h3>-->
                <input type="hidden" name="reference" value="{{$Reference}}" />
                <select name="reference" id="reference" class="form-control select-search">
                    <option value="">Select Payment Type</option>
                    <option value="1">BPV</option>
                    <option value="2">BRV</option>
                    <option value="3">CPV</option>
                    <option value="4">CRV</option>
                    <option value="5">JV</option>
                </select>

            </div>
            <div class="col-md-6"><h3>{{$TxnDate}}</h3><input type="hidden" name="TxnDate" id="TxnDate" value="{{$TxnDate}}" /></div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-2"><h3>Purpose:</h3></div>
            <div class="col-md-10">
                <input class="form-control purpose" autocomplete="off" name="purpose" id="purpose" placeholder="Purpose" id="purpose" />
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-1">
                <button type="button" class="add-row form-control btn-success"><i class="icon-plus3"></i></button>
            </div>
            <div class="col-md-1">
                <button type="button" class="rem-row form-control btn-danger"><i class="icon-minus3"></i></button>
            </div>

        </div>
        <hr>
        <div class="row" style="font-size: 18px; font-weight: bold;">
            <div class="col-md-1">S#</div>
            <div class="col-md-7">Account</div>
            <div class="col-md-2">Debit</div>
            <div class="col-md-2">Credit</div>

        </div>

        <div id="gl_rows">
            @for($i=1; $i<=10; $i++)
            <div class="row gl_rows_{{$i}}" style="display: none;">
                <div class="col-md-1">
                    {{$i}}
                </div>
                <div class="col-md-7">
                    <select name="chartofaccount[]" id="chartofaccount_{{$i}}" class="form-control select-search">
                        <option value="">Select Chart Of Account</option>
                        @foreach($chartOfAccounts as $row)
                        <option value="{{$row->id}}">{{$row->code}} - {{$row->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input class="form-control debit" autocomplete="off" value="0" name="debit[]" id="debit_{{$i}}" placeholder="Debit Amount" id="debit" />
                </div>
                <div class="col-md-2">
                    <input class="form-control credit" autocomplete="off" value="0" name="credit[]" id="credit_{{$i}}" placeholder="Credit Amount" id="credit" />
                </div>
            </div>
            @endfor
        </div>

    </div>
    <hr>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary col-md-12">Save</button>
    </div>
</div>
<script>

</script>