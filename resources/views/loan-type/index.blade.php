@extends('layouts.master')
@section('page_title', 'Financing Type')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Financing Type') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('loan-types.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Name</th>
										<th>Parent Id</th>
										<th>Createdon</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($loanTypes as $loanType)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $loanType->name }}</td>
											<td>{{ $loanType->parent_id }}</td>
											<td>{{ $loanType->createdOn }}</td>

                                            <td>
                                                <form action="{{ route('loan-types.destroy',$loanType->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('loan-types.show',$loanType->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('loan-types.edit',$loanType->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
