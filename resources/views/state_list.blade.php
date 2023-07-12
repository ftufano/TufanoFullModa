@extends('backoffice_layout')

@section('state_list_title')
    @lang('webtags.company_name') | @lang('Venezuela States')
@endsection

@section('state_list_header')
    
  {{-- Custom styles for this page --}}
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
@endsection

@section('username')

@if (Session::has('userName'))

  {{ Session::get('userName') }}
    
@endif

@endsection

@section('state_list_page_header')
    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-2 text-gray-800">@lang('Venezuela States')</h1>
      <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-sliders-h fa-sm"></i> @lang('Actions')
        </button>
        <div class="dropdown-menu shadow animated--fade-in" aria-labelledby="dropdownMenuButton">
          <button class="dropdown-item text-center" 
          data-toggle="modal" data-target="#addStateModal">
            <i class="fas fa-user-plus fa-sm"></i> @lang('New State')
          </button>
        </div>
      </div>
    </div>
@endsection

@section('state_list_table')
    {{-- DataTables Example --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">@lang('States')</h6>
        </div>
        <div class="card-body">
        @if(Session::has('successMsg'))
          <div class="alert alert-success alert-dismissible fade show">
            {{ Session::get('successMsg') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @elseif(Session::has('errorMsg'))
          <div class="alert alert-danger alert-dismissible fade show">
            {{ Session::get('errorMsg') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
          <div class="table-responsive">
            <table class="table table-bordered text-center datatable" width="100%" cellspacing="0">       
              <thead>
                <tr>
                  <th hidden>@lang('#')</th>
                  <th>@lang('State')</th>
                  <th style="width: 10%">@lang('Actions')</th>
                </tr>
              </thead>
              <tbody>
              @if (count($states) > 0)   
                @foreach($states as $state) 
                  <tr class="list-row">
                    <td class="list-id" id="stateId" hidden>{{ $state->id }}</td>
                    <td class="list-items" id="stateName">{{ $state->name }}</td>
                    <td>
                      <a class="cm-a-mrg edt-stt" href="" data-toggle="modal" data-target="#editStateModal" title="Editar">
                        <i class="fas fa-user-edit"></i>
                      </a>
                      <a class="cm-a-mrg dlt-stt" href="" data-toggle="modal" data-target="#stateDeleteModal" title="Eliminar">
                        <i class="fas fa-user-times"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              @else
                <div class="alert alert-danger alert-dismissible fade show">
                  @lang('There are no states registered yet')
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif
            </table>
          </div>
        </div>
      </div>
@endsection

@section('state_list_form_modals')
    {{-- Add State Modal --}}
  <div class="modal fade" id="addStateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('New State')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="creStateForm" action="{{ route('createState') }}">
            @csrf
            <div class="form-group">
                <label for="inputStateName">@lang('State Name')</label>
                <input type="text" class="form-control form-control-user" id="inputStateName" name="name"
                  placeholder="@lang('State Name')" required>
            </div>
            <button type="submit" class="btn btn-primary">@lang('Accept')</button>
            <button type="cancel" class="btn btn-cancel" data-dismiss="modal">@lang('Cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Edit State Modal --}}
  <div class="modal fade" id="editStateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Edit State')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="updStateForm" action="{{ route('updateState') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="inputEditId">
            <div class="form-group">
              <label for="inputEditStateName">@lang('State Name')</label>
              <input type="text" class="form-control form-control-user" id="inputEditStateName" name="name"
                placeholder="@lang('State Name')" required>
            </div>
            <button type="submit" class="btn btn-primary">@lang('Accept')</button>
            <button type="cancel" class="btn btn-cancel" data-dismiss="modal">@lang('Cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- State Delete Modal--}}
  <div class="modal fade" id="stateDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Delete State')</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="deleteModalDiv"></div>
        <div class="modal-body">
          <form method="POST" action="{{ route('deleteState') }}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" id="inputDeleteId">
            
            <div class="modal-footer">
              <button class="btn btn-cancel" type="button" data-dismiss="modal">@lang('Cancel')</button>
              <button type="submit" class="btn btn-primary">@lang('Delete')</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('state_list_footer')

    {{-- Page level plugins --}}
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

  {{-- Page level custom scripts --}}
  <script src="js/demo/datatables-demo.js"></script>

@endsection