@extends('layouts.master')
@section('page_title', 'Voucher Management')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Voucher Management') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('fin-general-ledgers.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatable-button-html5-columns">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Added By</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Txn Date</th>
                                        <th>Txn Number</th>
                                        <th>Office</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($finGeneralLedgers as $finGeneralLedger)
                                        <tr>
                                            <td>{{ ++$i }}</td>					
                                            <td>{{ $finGeneralLedger->userinfo->name }}</td>
                                            <td align="right">{{ number_format($finGeneralLedger->debit,0) }}</td>
                                            <td align="right">{{ number_format($finGeneralLedger->credit,0) }}</td>
                                            <td>{{ date("j M Y", strtotime($finGeneralLedger->txn_date)) }}</td>
                                            <td>{{ App\Http\Controllers\FinGeneralLedgerController::getReference($finGeneralLedger->txn_type,$finGeneralLedger->txn_series,3) }}</td>
                                            <td>{{ $finGeneralLedger->officeinfo->name }}</td>
                                            
                                            <td><?php echo app('App\Http\Controllers\FinGeneralLedgerController')->getVoucherStatus($finGeneralLedger->voucher_status) ?></td>
                                            <td>
                                                <form action="{{ route('fin-general-ledgers.destroy',$finGeneralLedger->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('fin-general-ledgers.show', $finGeneralLedger->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    @if($finGeneralLedger->voucher_status<3)
                                                    <a class="btn btn-sm btn-success " href="{{ route('fin-general-ledgers.process', $finGeneralLedger->id) }}"><i class="fa fa-fw fa-eye"></i> Process</a>
                                                    @endif

                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                

@endsection
