@extends('layouts.master')
@section('page_title', 'General User')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('General User') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('general-users.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
										<th>Id</th>
										<th>User Type</th>
										<th>Name</th>
										<th>User Name</th>
										<th>Created Date</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($generalUsers as $generalUser)
                                        <tr>
                                            
											<td>{{ $generalUser->id }}</td>
											<td>{{ $generalUser->user_type }}</td>
											<td>{{ $generalUser->name }}</td>
											<td>{{ $generalUser->username }}</td>
											<td>{{ $generalUser->created_date }}</td>

                                            <td>
                                                <form action="{{ route('general-users.destroy',$generalUser->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('general-users.show',$generalUser->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('general-users.edit',$generalUser->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
