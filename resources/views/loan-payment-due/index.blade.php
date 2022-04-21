@extends('layouts.master')
@section('page_title', 'Loan Payment Due')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Loan Payment Due') }}
                            </span>

                             <div class="float-right">
<!--                                <a href="{{ route('loan-payment-dues.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>-->
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
                                        
										<th>A/c#</th>
										<th>Inst.#</th>
										<th>Due Date</th>
										<th>Amount</th>
										<th>Principle</th>
										<th>Markup</th>
										<th>Status</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($loanPaymentDues as $loanPaymentDue)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $loanPaymentDue->loan_id }}</td>
											<td>{{ $loanPaymentDue->installment_no }}</td>
											<td>{{ $loanPaymentDue->due_date }}</td>
											<td>{{ $loanPaymentDue->amount_total }}</td>
											<td>{{ $loanPaymentDue->amount_pr }}</td>
											<td>{{ $loanPaymentDue->amount_mu }}</td>
                                                                                        <td><?php echo $loanPaymentDue->payment_status ? '<span class="badge badge-pill badge-success">&nbsp;&nbsp;&nbsp;&nbsp;PAID&nbsp;&nbsp;&nbsp;&nbsp;</span>' : '<span class="badge badge-pill badge-danger">UN-PAID</span>' ?></td>

                                            <td>
                                                <form action="{{ route('loan-payment-dues.destroy',$loanPaymentDue->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('loan-payment-dues.show',$loanPaymentDue->id) }}"><i class="icon-eye"></i>Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('loan-payment-dues.edit',$loanPaymentDue->id) }}"><i class="icon-edit"></i>Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="icon-trash"></i>Delete</button>
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
