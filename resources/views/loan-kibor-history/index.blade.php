@extends('layouts.master')
@section('page_title', 'Loan Kibor History')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Loan Kibor History') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('loan-kibor-histories.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Loan Id</th>
										<th>Start Date</th>
										<th>End Date</th>
										<th>Status</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($loanKiborHistories as $loanKiborHistory)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $loanKiborHistory->loan_id }}</td>
											<td>{{ $loanKiborHistory->start_date }}</td>
											<td>{{ $loanKiborHistory->end_date }}</td>
											<td>{{ $loanKiborHistory->status }}</td>

                                            <td>
                                                <form action="{{ route('loan-kibor-histories.destroy',$loanKiborHistory->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('loan-kibor-histories.show',$loanKiborHistory->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('loan-kibor-histories.edit',$loanKiborHistory->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
