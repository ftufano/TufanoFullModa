@extends('backoffice_layout')

@section('zone_list_title')
    @lang('webtags.company_name') | @lang('Zones')
@endsection

@section('zone_list_header')
    
  {{-- Custom styles for this page --}}
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="css/multiselect-input/bootstrap-multiselect.min.css" type="text/css"/>
@endsection

@section('username')

@if (Session::has('userName'))

  {{ Session::get('userName') }}
    
@endif

@endsection

@section('zone_list_page_header')
    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-2 text-gray-800">@lang('Zones')</h1>
      <a href="" class="btn btn-primary dropdown add-int-tel" id="addUsrLnk" data-toggle="modal" data-target="#addModal"><i class="fas fa-user-plus fa-sm text-white-50"></i> @lang('New Zone')</a>
    </div>
@endsection

@section('zone_list_table')
    {{-- DataTables Example --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">@lang('Zones List')</h6>
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
                  <th class="cm-tbl-dsp">ID</th>
                  <th>@lang('Zone Name')</th>
                  <th class="cm-tbl-dsp">Seller ID</th>
                  <th>@lang('Seller')</th>
                  <th class="cm-tbl-dsp">States ID</th>
                  <th style="width: 20%">@lang('States Associated')</th>
                  <th style="width: 10%">@lang('Actions')</th>
                </tr>
              </thead>
              <tbody>
              @if (count($zones) > 0)   
                @foreach($zones as $zone) 
                  <tr>
                    <td class="cm-tbl-dsp" id="zoneId">{{ $zone->id }}</td>
                    <td id="zoneName">{{ $zone->name }}</td>
                    <td class="cm-tbl-dsp" id="zoneSellerId">{{ $zone->seller_id }}</td>
                    <td id="zoneSeller">{{ $zone->seller_name }}</td>
                    <td class="cm-tbl-dsp">
                      @foreach($zones[$loop->index]->zone_states as $zone_state)
                        <ul>
                          <li class="list-id state-id">{{ $zone_state->id }}</li>
                        </ul>
                      @endforeach
                    </td>
                    <td>
                      <a class="cm-a-mrg cm-a-clr" href="" data-toggle="modal" data-target="#statesModal{{ $loop->iteration }}" title="@lang('Show')">
                        <i class="fas fa-map-pin"></i> @lang('Show States')
                      </a>
                    </td>
                    <td>
                      <a class="cm-a-mrg edt-zone" href="" data-toggle="modal" data-target="#editModal" title="Editar">
                        <i class="fas fa-user-edit"></i>
                      </a>
                      <a class="cm-a-mrg dlt-zone" href="" data-toggle="modal" data-target="#deleteModal" title="Eliminar">
                        <i class="fas fa-user-times"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              @else
                <div class="alert alert-danger alert-dismissible fade show">
                  @lang('There are no zones registered yet')
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

@section('zone_list_form_modals')

  {{-- Zone States List --}}
  @if (count($zones) > 0)   
    @foreach($zones as $zone) 
      <div class="modal fade" id="statesModal{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">@lang('States Associated')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table class="table table-bordered text-center datatable" width="100%" cellspacing="0">       
                  <thead>
                    <tr>
                      <th hidden>@lang('#')</th>
                      <th>@lang('State')</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($zones[$loop->index]->zone_states as $zone_state) 
                      <tr class="list-row">
                        <td class="list-id state-id" hidden>{{ $zone_state->id }}</td>
                        <td class="list-items state-name">{{ $zone_state->name }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  @endif
    
  {{-- Add Zone Modal --}}
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('New Zone')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="creZoneForm" action="{{ route('createZone') }}">
            @csrf
            <div class="form-group">
                <label for="inputName">@lang('Zone Name')</label>
                <input type="text" class="form-control form-control-user" id="inputName" name="name"
                  placeholder="@lang('Zone Name')" required>
            </div>
            <div class="form-group">
              <label for="inputSeller">@lang('Seller')</label>
              @if (count($sellers) > 0)   
                <select class="form-control form-control-user" id="inputSeller" name="seller">
                  @foreach($sellers as $seller)
                      <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                  @endforeach
                </select>
              @else
                  <input type="text" class="form-control form-control-user" id="inputNoSeller" value="@lang('There are no sellers registered yet')" readonly>
              @endif
            </div>
            <div class="form-group">
              <label for="inputStates">@lang('States Associated')</label>
              @if (count($states) > 0)   
                <select class="form-control form-control-user" id="inputStates" name="states[]" multiple="multiple" required>
                  @foreach($states as $state)
                      <option value="{{ $state->id }}">{{ $state->name }}</option>
                  @endforeach
                </select>
              @else
                  <input type="text" class="form-control form-control-user" id="inputNoStates" value="@lang('There are no states registered yet')" readonly>
              @endif
            </div>
            <button type="submit" class="btn btn-primary">@lang('Accept')</button>
            <button type="cancel" class="btn btn-cancel" data-dismiss="modal">@lang('Cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Edit Zone Modal --}}
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Edit Zone')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="updZoneForm" action="{{ route('updateZone') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="inputEditId">
            <div class="form-group">
              <label for="inputEditName">@lang('Zone Name')</label>
              <input type="text" class="form-control form-control-user" id="inputEditName" name="name"
                  placeholder="@lang('Zone Name')" required>
            </div>
            <div class="form-group">
              <label for="inputEditSeller">@lang('Seller')</label>
              @if (count($sellers) > 0)   
                <select class="form-control form-control-user" id="inputEditSeller" name="seller">
                  @foreach($sellers as $seller)
                      <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                  @endforeach
                </select>
              @else
                  <input type="text" class="form-control form-control-user" id="inputNoSeller" value="@lang('There are no sellers registered yet')" readonly>
              @endif
            </div>
            <div class="form-group">
              <label for="inputEditStates">@lang('States Associated')</label>
              @if (count($states) > 0)   
                <select class="form-control form-control-user" id="inputEditStates" name="states[]" multiple="multiple" required>
                  @foreach($states as $state)
                      <option value="{{ $state->id }}">{{ $state->name }}</option>
                  @endforeach
                </select>
              @else
                  <input type="text" class="form-control form-control-user" id="inputNoStates" value="@lang('There are no states registered yet')" readonly>
              @endif
            </div>
            <button type="submit" class="btn btn-primary">@lang('Accept')</button>
            <button type="cancel" class="btn btn-cancel" data-dismiss="modal">@lang('Cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Zone Delete Modal--}}
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Delete Zone')</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="deleteModalDiv"></div>
        <div class="modal-body">
          <form method="POST" action="{{ route('deleteZone') }}">
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

@section('zone_list_footer')

  {{-- Page level plugins --}}
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
  <script type="text/javascript" src="js/multiselect-input/bootstrap-multiselect.min.js"></script>

  {{-- Page level custom scripts --}}
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/zone-list.js"></script>

@endsection