@extends('layouts.master')
@section('page_title', 'Manage Borrowers')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Manage Borrowers</h6>
        {!! Qs::getPanelOptions() !!}


    </div>



    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#showall" class="nav-link active" data-toggle="tab">Borrowers</a></li>
            <li class="nav-item"><a href="#add-borr" class="nav-link" data-toggle="tab">Add Borrower</a></li>
        </ul>


        <div class="tab-content">

            <div class="tab-pane fade" id="add-borr">
                <div class="col-md-8">
                    <form class="ajax-store" method="post" action="{{ route('ttr.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">CNIC Number:<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="cnic" value="{{ old('cnic') }}" required type="text" class="form-control" placeholder="CNIC">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">First Name <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="fname" value="{{ old('name') }}" required type="text" class="form-control" placeholder="First Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Middle Name <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="mname" value="{{ old('name') }}" required type="text" class="form-control" placeholder="Middle Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Last Name <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="lname" value="{{ old('name') }}" required type="text" class="form-control" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">First Name <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="dob" value="{{ old('name') }}" required type="text" class="form-control" placeholder="First Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Gender: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">                                
                                <select required data-placeholder="Select Gender" class="form-control select" name="gender" id="gender">
                                    <option value="">Please Select Gender</option>
                                    <option value="0">Male</option>
                                    <option value="1">FeMale</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Mobile:<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="mobile" value="{{ old('mobile') }}" required type="text" class="form-control" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Caste: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="caste" value="{{ old('caste') }}" required type="text" class="form-control" placeholder="Caste">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Address: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="address" value="{{ old('address') }}" required type="text" class="form-control" placeholder="Address">
                            </div>
                        </div>

                        
                        
                        
                        



                        <div class="text-right">
                            <button id="ajax-btn" type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>

            </div>


            

            <div class="tab-pane fade show active" id="showall">                         
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>CNIC</th>
                            <th>Mobile</th>
                            <th>DOB</th>
                            <th>Added On</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tt_records as $mc)
                        <tr>
                            <td>{{ $mc->id }}</td>
                            <td>{{ $mc->fname." ".$mc->mname." ".$mc->lname }}</td>
                            <td>{{ $mc->cnic }}</td>
                            <td>{{ $mc->mobile }}</td>
                            <td>{{ date("j M Y", strtotime($mc->dob)) }}</td>
                            <td>{{ date("j M Y H:i A", strtotime($mc->created_at)) }}</td>
                            <td class="text-center">

                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            {{--View--}}
                                            <a href="{{ route('ttr.show', $mc->id) }}" class="dropdown-item"><i class="icon-eye"></i> View</a>

                                            @if(Qs::userIsTeamSA())
                                            {{--Manage--}}
                                            <a href="{{ route('ttr.manage', $mc->id) }}" class="dropdown-item"><i class="icon-plus-circle2"></i> Manage</a>
                                            {{--Edit--}}
                                            <a href="{{ route('ttr.edit', $mc->id) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                            @endif

                                            {{--Delete--}}
                                            @if(Qs::userIsSuperAdmin())
                                            <a id="{{ $mc->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                            <form method="post" id="item-delete-{{ $mc->id }}" action="{{ route('ttr.destroy', $mc->id) }}" class="hidden">@csrf @method('delete')</form>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            

        </div>
    </div>
</div>

{{--TimeTable Ends--}}

@endsection
