<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">Reference</div>
            <div class="col-md-4">Transaction Date</div>
            <div class="col-md-4 chequenum">Cheque Number</div>
        </div>

        <div class="row">
            <div class="col-md-4">
<!--                <input type="hidden" name="reference" value="{{$Reference}}" />-->
                <select name="reference" required="required" id="reference" class="form-control select-search">
                    <option value="">Select Payment Type</option>
                    <option value="1">BPV</option>
                    <option value="2">BRV</option>
                    <option value="3">CPV</option>
                    <option value="4">CRV</option>
                    <option value="5">JV</option>
                </select>

            </div>
            <div class="col-md-4"><input class="form-control" type="date" required="required" name="TxnDate" id="TxnDate" value="{{$TxnDate}}" /></div>
            <div class="col-md-4"><input class="form-control chequenum" type="number" name="chqnum" id="chqnum" value="{{$chqnum}}" /></div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-2"><h3>Purpose:</h3></div>
            <div class="col-md-10">
                <input class="form-control purpose" required="required" autocomplete="off" name="purpose" id="purpose" placeholder="Purpose" id="purpose" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"><h3>Attachments:</h3></div>
            <div class="col-md-10">
                <input type="file" multiple="multiple" id="filesupload" required="" name="filesupload[]" class="form-control alert-primary" />
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
            <div class="col-md-4">Account</div>
            <div class="col-md-3">Description</div>
            <div class="col-md-2">Debit</div>
            <div class="col-md-2">Credit</div>

        </div>

        <div id="gl_rows">
            @for($i=1; $i<=50; $i++)
            <div class="row gl_rows_{{$i}}" style="display: none;">
                <div class="col-md-1">
                    {{$i}}
                </div>
                <div class="col-md-4">
                    <select name="chartofaccount[]" id="chartofaccount_{{$i}}" class="form-control select-search">
                        <option value="0">Select Chart Of Account</option>
                        @foreach($chartOfAccounts as $row)
                        <option value="{{$row->id}}">{{$row->code}} - {{$row->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input class="form-control inputvalues detail" type="text" autocomplete="off" name="detail[]" id="detail_{{$i}}" placeholder="Description" id="detail" />
                </div>
                <div class="col-md-2">
                    <input class="form-control inputvalues debit" autocomplete="off" value="0" name="debit[]" id="debit_{{$i}}" placeholder="Debit Amount" />
                </div>
                <div class="col-md-2">
                    <input class="form-control inputvalues credit" autocomplete="off" value="0" name="credit[]" id="credit_{{$i}}" placeholder="Credit Amount" />
                </div>
            </div>
            @endfor
        </div>
        <hr>
        <div class="row" style="font-size: 18px; font-weight: bold;">
            <div class="col-md-8" align="right">Total</div>
            <div class="col-md-2 granddebit form-control"></div>
            <div class="col-md-2 grandcredit form-control"></div>

        </div>

    </div>
    <hr>
    <div class="box-footer mt20">
        <button type="button" class="btn btn-primary col-md-12 submitbtn">Save</button>
    </div>
</div>
