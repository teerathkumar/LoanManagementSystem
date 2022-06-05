@extends('layouts.master')
@section('page_title', 'Loan Takaful')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Loan Takaful') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('loan-takafuls.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Start Date</th>
										<th>End Date</th>
										<th>Policy Number</th>
										<th>Renewal Date</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($loanTakafuls as $loanTakaful)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $loanTakaful->start_date }}</td>
											<td>{{ $loanTakaful->end_date }}</td>
											<td>{{ $loanTakaful->policy_number }}</td>
											<td>{{ $loanTakaful->renewal_date }}</td>

                                            <td>
                                                <form action="{{ route('loan-takafuls.destroy',$loanTakaful->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('loan-takafuls.show',$loanTakaful->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('loan-takafuls.edit',$loanTakaful->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
