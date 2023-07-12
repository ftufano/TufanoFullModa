@extends('backoffice_layout')

@section('category_list_title')
    @lang('webtags.company_name') | @lang('Customers Categories')
@endsection

@section('category_list_header')
    
  {{-- Custom styles for this page --}}
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
@endsection

@section('username')

@if (Session::has('userName'))

  {{ Session::get('userName') }}
    
@endif

@endsection

@section('category_list_page_header')
    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-2 text-gray-800">@lang('Customers Categories')</h1>
      <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-sliders-h fa-sm"></i> @lang('Actions')
        </button>
        <div class="dropdown-menu shadow animated--fade-in" aria-labelledby="dropdownMenuButton">
          <button class="dropdown-item text-center" 
          data-toggle="modal" data-target="#addCategoryModal">
            <i class="fas fa-user-plus fa-sm"></i> @lang('New Category')
          </button>
        </div>
      </div>
    </div>
@endsection

@section('category_list_table')
    {{-- DataTables Example --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">@lang('Categories')</h6>
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
                  <th>@lang('Category')</th>
                  <th style="width: 10%">@lang('Actions')</th>
                </tr>
              </thead>
              <tbody>
              @if (count($categories) > 0)   
                @foreach($categories as $category) 
                  <tr class="list-row">
                    <td class="list-id" id="categoryId" hidden>{{ $category->id }}</td>
                    <td class="list-items" id="categoryName">{{ $category->name }}</td>
                    <td>
                      <a class="cm-a-mrg edt-ctg" href="" data-toggle="modal" data-target="#editCategoryModal" title="Editar">
                        <i class="fas fa-user-edit"></i>
                      </a>
                      <a class="cm-a-mrg dlt-ctg" href="" data-toggle="modal" data-target="#categoryDeleteModal" title="Eliminar">
                        <i class="fas fa-user-times"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              @else
                <div class="alert alert-danger alert-dismissible fade show">
                  @lang('There are no categories registered yet')
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

@section('category_list_form_modals')
    {{-- Add Category Modal --}}
  <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('New Category')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="creCategoryForm" action="{{ route('createCategory') }}">
            @csrf
            <div class="form-group">
                <label for="inputCategoryName">@lang('Category Name')</label>
                <input type="text" class="form-control form-control-user" id="inputCategoryName" name="name"
                  placeholder="@lang('Category Name')" required>
            </div>
            <button type="submit" class="btn btn-primary">@lang('Accept')</button>
            <button type="cancel" class="btn btn-cancel" data-dismiss="modal">@lang('Cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Edit Category Modal --}}
  <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Edit Category')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="updCategoryForm" action="{{ route('updateCategory') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="inputEditId">
            <div class="form-group">
              <label for="inputEditCategoryName">@lang('Category Name')</label>
              <input type="text" class="form-control form-control-user" id="inputEditCategoryName" name="name"
                placeholder="@lang('Category Name')" required>
            </div>
            <button type="submit" class="btn btn-primary">@lang('Accept')</button>
            <button type="cancel" class="btn btn-cancel" data-dismiss="modal">@lang('Cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Category Delete Modal--}}
  <div class="modal fade" id="categoryDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Delete Category')</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="deleteModalDiv"></div>
        <div class="modal-body">
          <form method="POST" action="{{ route('deleteCategory') }}">
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

@section('category_list_footer')

    {{-- Page level plugins --}}
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

  {{-- Page level custom scripts --}}
  <script src="js/demo/datatables-demo.js"></script>

@endsection