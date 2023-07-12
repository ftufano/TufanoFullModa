@extends('backoffice_layout')

@section('customer_list_title')
    @lang('webtags.company_name') | @lang('Customers Summary')
@endsection

@section('customer_list_header')
    
  {{-- Custom styles for this page --}}
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
  <link href="css/intl-tel-input/intlTelInput.min.css" rel="stylesheet" >
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('username')

@if (Session::has('userName'))

  {{ Session::get('userName') }}
    
@endif

@endsection

@section('customer_list_page_header')
    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-2 text-gray-800">@lang('Customers Summary')</h1>
      <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-sliders-h fa-sm"></i> @lang('Actions')
        </button>
        <div class="dropdown-menu shadow animated--fade-in" aria-labelledby="dropdownMenuButton">
          <button class="dropdown-item text-center" 
          data-toggle="modal" data-target="#addCustomerModal">
            <i class="fas fa-user-plus fa-sm"></i> @lang('New Customer')
          </button>
        </div>
      </div>
    </div>
@endsection

@section('customer_list_table')
    {{-- DataTables Example --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">@lang('Customers')</h6>
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
                  <th>@lang('Identification')</th>
                  <th>@lang('Social Reason')</th>
                  <th>@lang('Address')</th>
                  <th>@lang('Phone')</th>
                  <th hidden>@lang('State #')</th>
                  <th>@lang('State')</th>
                  <th hidden>@lang('Zone #')</th>
                  <th>@lang('Zone')</th>
                  <th hidden>@lang('Category #')</th>
                  <th>@lang('Category')</th>
                  <th hidden>@lang('Status #')</th>
                  <th>@lang('Status')</th>
                  <th>@lang('Actions')</th>
                </tr>
              </thead>
              <tbody>
              @if (count($customers) > 0)   
                @foreach($customers as $customer) 
                  <tr class="list-row">
                    <td class="list-id" id="custId" hidden>{{ $customer->id }}</td>
                    <td class="user-name" id="custIdent">{{ $customer->identification }}</td>
                    <td class="list-items" id="custName">{{ $customer->name }}</td>
                    <td class="list-total" id="custAddress">{{ $customer->address }}</td>
                    <td class="list-total" id="custPhone">{{ $customer->phone }}</td>
                    <td class="list-id" id="custStateId" hidden>{{ $customer->state_id }}</td>
                    <td class="list-status" id="custState">{{ $customer->state_name }}</td>
                    <td class="list-id" id="custZoneId" hidden>{{ $customer->zone_id }}</td>
                    <td class="list-status" id="custZone">{{ $customer->zone_name }}</td>
                    <td class="list-id" id="custCategoryId" hidden>{{ $customer->category_id }}</td>
                    <td class="list-status" id="custCategory">{{ $customer->category_name }}</td>
                    <td class="list-id" id="custStatusId" hidden>{{ $customer->status_id }}</td>
                    <td class="list-status" id="custStatus">{{ $customer->status_name }}</td>
                    <td>
                      <form class="cm-form-dsp" action="{{-- route('orderDetails') --}}" method="GET"> {{-- seguir por aca --}}
                        @csrf
                        <input type="text" name="list_id" value="{{ $customer->id }}" hidden>
                        <a class="cm-a-mrg" href="#" onclick="$(this).closest('form').submit()" title="@lang('List Details')">
                          <i class="fas fa-folder-open"></i>
                        </a>
                        <a class="cm-a-mrg edt-cmr edt-int-tel" href="" data-toggle="modal" data-target="#editCustomerModal" title="Editar">
                          <i class="fas fa-user-edit"></i>
                        </a>
                        <a class="cm-a-mrg dlt-cmr" href="" data-toggle="modal" data-target="#customerDeleteModal" title="Eliminar">
                          <i class="fas fa-user-times"></i>
                        </a>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              @else
                <div class="alert alert-danger alert-dismissible fade show">
                  @lang('There are no customers registered yet')
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

@section('customer_list_form_modals')
    {{-- Add Customer Modal --}}
  <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('New Customer')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="creCustomerForm" action="{{ route('createCustomer') }}">
            @csrf
            <div class="form-group">
                <label for="inputId">@lang('Identification (RIF, C. I., etc)')</label>
                <input type="text" class="form-control form-control-user" id="inputId" name="identification"
                  placeholder="@lang('Identification (RIF, C. I., etc)')" required>
            </div>
            <div class="form-group">
                <label for="inputName">@lang('Social Reason')</label>
                <input type="text" class="form-control form-control-user" id="inputName" name="name"
                    placeholder="@lang('Social Reason')" required>
            </div>
            <div class="form-group">
                <label for="inputAddress">@lang('Address')</label>
                <textarea class="form-control form-control-user" id="inputAddress" name="address"
                    rows="3" placeholder="@lang('Address')" required></textarea>
            </div>
            <div class="form-group cm-dsp-grd">
              <label for="inputPhone">@lang('Phone')</label>
              <input type="tel" name="phone" class="form-control form-control-user"
                  id="inputPhone"required>
            </div>
            <div class="form-group">
              <label for="inputState">@lang('State')</label>
              @if (count($states) > 0)   
                <select class="form-control form-control-user" id="inputState" name="state" required>
                  @foreach($states as $state)
                      <option value="{{ $state->id }}">{{ $state->name }}</option>
                  @endforeach
                </select>
              @else
                  <input type="text" class="form-control form-control-user" id="inputNoStates" value="@lang('There are no states registered yet')" readonly>
              @endif
            </div>
            <div class="form-group">
              <label for="inputZone">@lang('Zone')</label>
                <select class="form-control form-control-user" id="inputZone" name="zone" required>
                </select>
            </div>
            <div class="form-group">
              <label for="inputSeller">@lang('Seller')</label>
              <input type="text" class="form-control form-control-user" id="inputSeller" placeholder="Nombre del Vendedor" disabled>
            </div>
            <div class="form-group">
              <label for="inputCategory">@lang('Category')</label>
              @if (count($categories) > 0)   
                <select class="form-control form-control-user" id="inputCategory" name="category" required>
                  @foreach($categories as $category)
                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              @else
                  <input type="text" class="form-control form-control-user" id="inputNoCategories" value="@lang('There are no categories registered yet')" readonly>
              @endif
            </div>
            <div class="form-group">
              <label for="inputStatus">@lang('Status')</label>
              @if (count($statuses) > 0)   
                <select class="form-control form-control-user" id="inputStatus" name="status" required>
                  @foreach($statuses as $status)
                      <option value="{{ $status->id }}">{{ $status->name }}</option>
                  @endforeach
                </select>
              @else
                  <input type="text" class="form-control form-control-user" id="inputNoStates" value="@lang('There are no statuses registered yet')" readonly>
              @endif
            </div>
            <button type="submit" class="btn btn-primary" onclick="validAddZone()">@lang('Accept')</button>
            <button type="cancel" class="btn btn-cancel" data-dismiss="modal">@lang('Cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Edit Customer Modal --}}
  <div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Edit Customer')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="updCustomerForm" action="{{ route('updateCustomer') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="inputEditId">
            <div class="form-group">
              <label for="inputEditIdent">@lang('Identification (RIF, C. I., etc)')</label>
                <input type="text" class="form-control form-control-user" id="inputEditIdent" name="identification"
                  placeholder="@lang('Identification (RIF, C. I., etc)')" required>
            </div>
            <div class="form-group">
              <label for="inputEditName">@lang('Social Reason')</label>
                <input type="text" class="form-control form-control-user" id="inputEditName" name="name"
                    placeholder="@lang('Social Reason')" required>
            </div>
            <div class="form-group">
              <label for="inputEditAddress">@lang('Address')</label>
              <textarea class="form-control form-control-user" id="inputEditAddress" name="address"
                  rows="3" placeholder="@lang('Address')" required></textarea>
            </div>
            <div class="form-group cm-dsp-grd">
              <label for="inputEditPhone">@lang('Phone')</label>
              <input type="tel" name="phone" class="form-control form-control-user"
                  id="inputEditPhone"required>
            </div>
            <div class="form-group">
              <label for="inputEditState">@lang('State')</label>
              @if (count($states) > 0)   
                <select class="form-control form-control-user" id="inputEditState" name="state" required>
                  @foreach($states as $state)
                      <option value="{{ $state->id }}">{{ $state->name }}</option>
                  @endforeach
                </select>
              @else
                  <input type="text" class="form-control form-control-user" id="inputNoStates" value="@lang('There are no states registered yet')" readonly>
              @endif
            </div>
            <div class="form-group">
              <label for="inputEditZone">@lang('Zone')</label>
                <select class="form-control form-control-user" id="inputEditZone" name="zone" required>
                </select>
            </div>
            <div class="form-group">
              <label for="inputSeller">@lang('Seller')</label>
              <input type="text" class="form-control form-control-user" id="inputEditSeller" placeholder="Nombre del Vendedor" disabled>
            </div>
            <div class="form-group">
              <label for="inputEditCategory">@lang('Category')</label>
              @if (count($categories) > 0)   
                <select class="form-control form-control-user" id="inputEditCategory" name="category" required>
                  @foreach($categories as $category)
                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              @else
                  <input type="text" class="form-control form-control-user" id="inputNoStates" value="@lang('There are no states registered yet')" readonly>
              @endif
            </div>
            <div class="form-group">
              <label for="inputEditStatus">@lang('Status')</label>
              @if (count($statuses) > 0)   
                <select class="form-control form-control-user" id="inputEditStatus" name="status" required>
                  @foreach($statuses as $status)
                      <option value="{{ $status->id }}">{{ $status->name }}</option>
                  @endforeach
                </select>
              @else
                  <input type="text" class="form-control form-control-user" id="inputNoStates" value="@lang('There are no states registered yet')" readonly>
              @endif
            </div>
            <button type="submit" class="btn btn-primary" onclick="validEditZone()">@lang('Accept')</button>
            <button type="cancel" class="btn btn-cancel" data-dismiss="modal">@lang('Cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- customer Delete Modal--}}
  <div class="modal fade" id="customerDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Delete Customer')</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="deleteModalDiv"></div>
        <div class="modal-body">
          <form method="POST" action="{{ route('deleteCustomer') }}">
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

@section('customer_list_footer')

    {{-- Page level plugins --}}
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

  {{-- Page level custom scripts --}}
  <script src="js/demo/datatables-demo.js"></script>

  {{-- Custom scripts for all pages--}}
  <script src="js/intl-tel-input/intlTelInput.min.js"></script>
  <script src="js/customer-list.js"></script>

  <script>
 
    var input = document.querySelector("#inputPhone");
    var iti = window.intlTelInput(input, {
        utilsScript:"js/intl-tel-input/utils.js",
      // any initialisation options go here
      placeholderNumberType:'MOBILE', //set placeholder phone example on phone input
      preferredCountries:['ve'], //put on list top the countries declared in this array
    });

    $('#inputPhone').keydown(function (e) { //Function to check which keys are allowed on the input
        var key = e.charCode || e.keyCode || 0; //Getting the keyboard event numbers or codes
        $text = $(this); //Getting the input field value on a variable
        
        $text.val($text.val().replace(/[^0-9]/g, "")); //Setting the $text value by replacing any character but numbers using a RegEx

        //Returning only allowed keys (backspace, tab, supress, ctrl, v (for paste), normal number keys, numpad keys, arrows)
        return (key == 8 || key == 9 || key == 46 || key == 86 || key == 17 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key >= 37 && key <= 40));
    })

    input.addEventListener('input', function() {
        input.value = input.value.replace(/[^0-9]/g, ""); //Setting the $text value by replacing any character but numbers using a RegEx

        if(!iti.isValidNumber()){
            input.setCustomValidity('El número indicado no es válido en ' + iti.getSelectedCountryData().name);
        }else{
            input.setCustomValidity('');
        }
        
    });

    input.addEventListener('blur', function() {

      var number = iti.getNumber();
        
      if (number.indexOf("+") == -1){

        if(number.length != 0){
            number = "+"+number;
        }
      }
      
      iti.setNumber(number);
      var valNumber = input.value;

      if(!iti.isValidNumber()){

        input.setCustomValidity('El número indicado no es válido en ' + iti.getSelectedCountryData().name);

      }else{
          input.setCustomValidity('');
          if (!iti.isValidNumber()) {
              input.setCustomValidity('El número indicado debe ser de un teléfono móvil o fijo vállido');
          }else{
              input.setCustomValidity('');
              var number = iti.getNumber();
              iti.setNumber(number);
          }
      }
    });

    /*function to set international prefix on phone after form submission - commented since it is not used

    document.getElementById('creCustomerForm').onsubmit = function() {
      var number = iti.getNumber();

      iti.setNumber(number);
      input.value = iti.getNumber(); //join the international prefix with the typed phone number
    };*/
  </script>

  <script>
 
      var input2 = document.querySelector("#inputEditPhone");
      var iti2 = window.intlTelInput(input2, {
          utilsScript:"js/intl-tel-input/utils.js",
        // any initialisation options go here
        placeholderNumberType:'MOBILE', //set placeholder phone example on phone input
        preferredCountries:['ve'], //put on list top the countries declared in this array
      });

      $('.edt-int-tel').click(function() {
        var number = iti2.getNumber();
        iti2.setNumber(number);
        input2.value = iti2.getNumber(); //join the international prefix with the typed phone number
      });

      $('#inputEditPhone').keydown(function (e) { //Function to check which keys are allowed on the input
        var key = e.charCode || e.keyCode || 0; //Getting the keyboard event numbers or codes
        $text = $(this); //Getting the input field value on a variable
        
        $text.val($text.val().replace(/[^0-9]/g, "")); //Setting the $text value by replacing any character but numbers using a RegEx

        //Returning only allowed keys (backspace, tab, supress, ctrl, v (for paste), normal number keys, numpad keys, arrows)
        return (key == 8 || key == 9 || key == 46 || key == 86 || key == 17 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key >= 37 && key <= 40));
      });

      input2.addEventListener('input', function() {
          input2.value = input2.value.replace(/[^0-9]/g, ""); //Setting the $text value by replacing any character but numbers using a RegEx

          if(!iti2.isValidNumber()){
              input2.setCustomValidity('El número indicado no es válido en ' + iti2.getSelectedCountryData().name);
          }else{
              input2.setCustomValidity('');
          }
          
      });

      input2.addEventListener('blur', function() {

        var number2 = iti2.getNumber();
          
          if (number2.indexOf("+") == -1){
            number2 = "+"+number2;
          }
        iti2.setNumber(number2);
        var valNumber2 = input2.value;

        if(!iti2.isValidNumber()){

          input2.setCustomValidity('El número indicado no es válido en ' + iti2.getSelectedCountryData().name);

        }else{

          input2.setCustomValidity('');
          var number2 = iti2.getNumber();
          iti2.setNumber(number2);

        }
      });

      /*function to set international prefix on phone after form submission - commented since it is not used

      document.getElementById('updUserForm').onsubmit = function() {
        var number2 = iti2.getNumber();

        iti2.setNumber(number2);
        input2.value = iti2.getNumber(); //join the international prefix with the typed phone number
      };*/
  </script>
@endsection