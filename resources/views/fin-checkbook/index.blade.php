@extends('layouts.master')
@section('page_title', 'Fin Checkbook')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Fin Checkbook') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('fin-checkbooks.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Checkbook Title</th>
										<th>Bank Id</th>
										<th>Checknum Start</th>
										<th>Checknum End</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($finCheckbooks as $finCheckbook)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $finCheckbook->checkbook_title }}</td>
											<td>{{ $finCheckbook->bank_id }}</td>
											<td>{{ $finCheckbook->checknum_start }}</td>
											<td>{{ $finCheckbook->checknum_end }}</td>

                                            <td>
                                                <form action="{{ route('fin-checkbooks.destroy',$finCheckbook->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('fin-checkbooks.show',$finCheckbook->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('fin-checkbooks.edit',$finCheckbook->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
