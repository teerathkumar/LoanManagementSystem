@extends('layouts.master')
@section('page_title', 'Manage System Settings')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title font-weight-semibold">Update System Settings </h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <form enctype="multipart/form-data" method="post" action="{{ route('settings.update') }}">
                @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 border-right-2 border-right-blue-400">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Organization Name: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="system_name" value="{{ $s['system_name'] }}" required type="text" class="form-control" placeholder="Name of School">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="current_session" class="col-lg-3 col-form-label font-weight-semibold">Current Session <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <select data-placeholder="Choose..." required name="current_session" id="current_session" class="select-search form-control">
                                    <option value=""></option>
                                    @for($y=date('Y', strtotime('- 3 years')); $y<=date('Y', strtotime('+ 1 years')); $y++)
                                        <option {{ ($s['current_session'] == (($y-=1).'-'.($y+=1))) ? 'selected' : '' }}>{{ ($y-=1).'-'.($y+=1) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Acronym</label>
                            <div class="col-lg-9">
                                <input name="system_title" value="{{ $s['system_title'] }}" type="text" class="form-control" placeholder="School Acronym">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Phone</label>
                            <div class="col-lg-9">
                                <input name="phone" value="{{ $s['phone'] }}" type="text" class="form-control" placeholder="Phone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Email</label>
                            <div class="col-lg-9">
                                <input name="system_email" value="{{ $s['system_email'] }}" type="email" class="form-control" placeholder="School Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Address <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input required name="address" value="{{ $s['address'] }}" type="text" class="form-control" placeholder="School Address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Fiscal Ends</label>
                            <div class="col-lg-6">
                                <input name="term_ends" value="{{ $s['term_ends'] }}" type="text" class="form-control date-pick" placeholder="Date Term Ends">
                            </div>
                            <div class="col-lg-3 mt-2">
                                <span class="font-weight-bold font-italic">M-D-Y or M/D/Y </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Next Fiscal Begins</label>
                            <div class="col-lg-6">
                                <input name="term_begins" value="{{ $s['term_begins'] }}" type="text" class="form-control date-pick" placeholder="Date Term Ends">
                            </div>
                            <div class="col-lg-3 mt-2">
                                <span class="font-weight-bold font-italic">M-D-Y or M/D/Y </span>
                            </div>
                        </div>
                </div>

            </div>

                <hr class="divider">

                <div class="text-right">
                    <button type="submit" class="btn btn-danger">Submit form <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>

@endsection
