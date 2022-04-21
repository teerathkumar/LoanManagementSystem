@extends('layouts.master')
@section('page_title', 'General Office')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('General Office') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('general-offices.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
										<th>Code</th>
										<th>Parent Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($generalOffices as $generalOffice)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $generalOffice->name }}</td>
											<td>{{ $generalOffice->code }}</td>
											<td>{{ $generalOffice->parent_id }}</td>

                                            <td>
                                                <form action="{{ route('general-offices.destroy',$generalOffice->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('general-offices.show',$generalOffice->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('general-offices.edit',$generalOffice->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
