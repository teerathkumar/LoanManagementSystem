@extends('layouts.master')
@section('page_title', 'Fin General Ledger Detail')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Fin General Ledger Detail') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('fin-general-ledger-details.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Coa Id</th>
										<th>Debit</th>
										<th>Credit</th>
										<th>Created Date</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($finGeneralLedgerDetails as $finGeneralLedgerDetail)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $finGeneralLedgerDetail->coa_id }}</td>
											<td>{{ $finGeneralLedgerDetail->debit }}</td>
											<td>{{ $finGeneralLedgerDetail->credit }}</td>
											<td>{{ $finGeneralLedgerDetail->created_date }}</td>

                                            <td>
                                                <form action="{{ route('fin-general-ledger-details.destroy',$finGeneralLedgerDetail->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('fin-general-ledger-details.show',$finGeneralLedgerDetail->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('fin-general-ledger-details.edit',$finGeneralLedgerDetail->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
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
