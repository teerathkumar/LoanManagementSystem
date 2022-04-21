@extends('layouts.master')
@section('page_title', 'Loan Payment Recovered')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Loan Payment Recovered') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('loan-payment-recovereds.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Due Id</th>
										<th>Loan Id</th>
										<th>Amount Total</th>
										<th>Amount Pr</th>
										<th>Amount Mu</th>
										<th>Amount Penalty</th>
										<th>Recovered By</th>
										<th>Recovered Date</th>
										<th>Bank Slip Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($loanPaymentRecovereds as $loanPaymentRecovered)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $loanPaymentRecovered->due_id }}</td>
											<td>{{ $loanPaymentRecovered->loan_id }}</td>
											<td>{{ $loanPaymentRecovered->amount_total }}</td>
											<td>{{ $loanPaymentRecovered->amount_pr }}</td>
											<td>{{ $loanPaymentRecovered->amount_mu }}</td>
											<td>{{ $loanPaymentRecovered->amount_penalty }}</td>
											<td>{{ $loanPaymentRecovered->recovered_by }}</td>
											<td>{{ $loanPaymentRecovered->recovered_date }}</td>
											<td>{{ $loanPaymentRecovered->bank_slip_id }}</td>

                                            <td>
                                                <form action="{{ route('loan-payment-recovereds.destroy',$loanPaymentRecovered->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('loan-payment-recovereds.show',$loanPaymentRecovered->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('loan-payment-recovereds.edit',$loanPaymentRecovered->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
