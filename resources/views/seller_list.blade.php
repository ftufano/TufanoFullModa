@extends('backoffice_layout')

@section('seller_list_title')
    @lang('webtags.company_name') | @lang('Sellers')
@endsection

@section('seller_list_header')
    
  {{-- Custom styles for this page --}}
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
  <link href="css/intl-tel-input/intlTelInput.min.css" rel="stylesheet" >
@endsection

@section('username')

@if (Session::has('userName'))

  {{ Session::get('userName') }}
    
@endif

@endsection

@section('seller_list_page_header')
    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-2 text-gray-800">@lang('Sellers')</h1>
      <a href="" class="btn btn-primary dropdown add-int-tel" id="addUsrLnk" data-toggle="modal" data-target="#addModal"><i class="fas fa-user-plus fa-sm text-white-50"></i> @lang('New Seller')</a>
    </div>
@endsection

@section('seller_list_table')
    {{-- DataTables Example --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">@lang('Sellers List')</h6>
        </div>
        <div class="card-body">
        @if(Session::has('successSellerMsg'))
          <div class="alert alert-success alert-dismissible fade show">
            {{ Session::get('successSellerMsg') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @elseif(Session::has('errorSellerMsg'))
          <div class="alert alert-danger alert-dismissible fade show">
            {{ Session::get('errorSellerMsg') }}
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
                  <th>@lang('First Name and Last Name')</th>
                  <th>@lang('E-Mail Address')</th>
                  <th>@lang('Phone')</th>
                  <th>@lang('User Type')</th>
                  <th>@lang('Actions')</th>
                </tr>
              </thead>
              <tbody>
              @if (count($sellers) > 0)   
                @foreach($sellers as $seller) 
                  <tr>
                    <td class="cm-tbl-dsp" id="userId">{{ $seller->id }}</td>
                    <td id="userName">{{ $seller->name }}</td>
                    <td id="userEmail">{{ $seller->email }}</td>
                    <td id="userPhone">{{ $seller->phone }}</td>
                    <td id="userType">{{ $seller->user_type }}</td>
                    <td>
                      <a class="cm-a-mrg edt-usr edt-int-tel" href="" data-toggle="modal" data-target="#editModal" title="Editar">
                        <i class="fas fa-user-edit"></i>
                      </a>
                      <a class="cm-a-mrg dlt-usr" href="" data-toggle="modal" data-target="#userDeleteModal" title="Eliminar">
                        <i class="fas fa-user-times"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              @else
                <div class="alert alert-danger alert-dismissible fade show">
                  @lang('There are no sellers registered yet')
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

@section('seller_list_form_modals')
    {{-- Add Seller Modal --}}
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('New Seller')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="creUserForm" action="{{ route('createUser') }}">
            @csrf
            <div class="form-group">
                <label for="inputName">@lang('First Name and Last Name')</label>
                <input type="text" class="form-control form-control-user" id="inputName" name="name"
                  placeholder="@lang('First Name and Last Name')" required>
            </div>
            <div class="form-group">
                <label for="inputEmail">@lang('E-Mail Address')</label>
                <input type="email" class="form-control form-control-user" id="inputEmail" name="email"
                    placeholder="@lang('E-Mail Address')" required>
            </div>
            <div class="form-group cm-dsp-grd">
              <label for="inputPhone">@lang('Phone')</label>
              <input type="tel" name="phone" class="form-control form-control-user"
                  id="inputPhone"required>
            </div>
            <div class="form-group">
              <label for="inputPassword">@lang('Password')</label>
              <input type="password" class="form-control form-control-user"
                  id="inputPassword" name="password" value="1234" placeholder="@lang('Password')" required readonly>
            </div>
            <div class="form-group">
              <label for="inputConfirmPassword">@lang('Confirm Password')</label>
                    <input type="password" class="form-control form-control-user"
                        id="inputConfirmPassword" value="1234" name="repeat_password" placeholder="@lang('Confirm Password')" required readonly>
            </div>
            <div class="form-group">
                <label for="inputUserType">@lang('User Type')</label>
                <input type="text" class="form-control form-control-user" id="inputUserType" name="user_type" value="@lang('Seller')" readonly>
            </div>
            <button type="submit" class="btn btn-primary">@lang('Accept')</button>
            <button type="cancel" class="btn btn-cancel" data-dismiss="modal">@lang('Cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Edit Seller Modal --}}
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Edit Seller')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="updUserForm" action="{{ route('updateUser') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="inputEditId">
            <div class="form-group">
              <label for="inputEditName">@lang('First Name and Last Name')</label>
              <input type="text" class="form-control form-control-user" id="inputEditName" name="name"
                  placeholder="@lang('First Name and Last Name')" required>
            </div>
            <div class="form-group">
              <label for="inputEditEmail">@lang('E-Mail Address')</label>
              <input type="email" class="form-control form-control-user" id="inputEditEmail" name="email"
                  placeholder="@lang('E-Mail Address')" required>
            </div>
            <div class="form-group cm-dsp-grd">
              <label for="inputEditPhone">@lang('Phone')</label>
              <input type="tel" name="phone" class="form-control form-control-user"
                  id="inputEditPhone"required>
            </div>
            <div class="form-group">
              <label for="inputEditPassword">@lang('Password')</label>
              <input type="password" class="form-control form-control-user"
                  id="inputEditPassword" name="password" placeholder="@lang('Password')" readonly>
            </div>
            <div class="form-group">
              <label for="inputEditConfirmPassword">@lang('Confirm Password')</label>
              <input type="password" class="form-control form-control-user"
                  id="inputEditConfirmPassword" name="repeat_password" placeholder="@lang('Confirm Password')" readonly>
            </div>
            <div class="form-group">
              <label for="inputEditSuerType">@lang('User Type')</label>
              <input type="text" class="form-control form-control-user" id="inputEditUserType" name="user_type" value="@lang('Seller')" readonly>
            </div>
            <button type="submit" class="btn btn-primary">@lang('Accept')</button>
            <button type="cancel" class="btn btn-cancel" data-dismiss="modal">@lang('Cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Seller Delete Modal--}}
  <div class="modal fade" id="userDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Delete Seller')</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="deleteModalDiv"></div>
        <div class="modal-body">
          <form method="POST" action="{{ route('deleteUser') }}">
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

@section('seller_list_footer')

    {{-- Page level plugins --}}
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

  {{-- Page level custom scripts --}}
  <script src="js/demo/datatables-demo.js"></script>

  {{-- Custom scripts for all pages--}}
  <script src="js/intl-tel-input/intlTelInput.min.js"></script>

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
      
    document.getElementById('creUserForm').onsubmit = function() {
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