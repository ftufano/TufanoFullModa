$(document).ready(function() {

    $('#editModal').on('hidden.bs.modal', function() {
        $('#inputEditStates').multiselect('deselectAll', false);    
        $('#inputEditStates').multiselect('updateButtonText');
    });

    $('#inputStates').multiselect({
      buttonWidth: '100%',
      maxHeight: 250,
      enableFiltering: true,
      enableCaseInsensitiveFiltering: false,
      filterPlaceholder: 'Buscar Estado(s)',
      nonSelectedText: 'Ningun estado seleccionado',
      nSelectedText: 'seleccionados',
      includeSelectAllOption: true,
      selectAllText: 'Seleccionar todos',
      allSelectedText: 'Todos los estados seleccionados',
      onInitialized: function (option, checked) {

        var selectedOption = $('#inputStates option:selected');

        if (selectedOption.length <=0) {

          $('#inputStates')[0].setCustomValidity("{{ __('No state selected, please select') }}");

        }else{

          $('#inputStates')[0].setCustomValidity('');
          
        }

      },
      onChange: function (option, checked) {

        var selectedOption = $('#inputStates option:selected');

        if (selectedOption.length <=0) {

          $('#inputStates')[0].setCustomValidity("{{ __('No state selected, please select') }}");

        }else{

          $('#inputStates')[0].setCustomValidity('');
          
        }

      }
    });

    $('#inputEditStates').multiselect({
      buttonWidth: '100%',
      maxHeight: 250,
      enableFiltering: true,
      enableCaseInsensitiveFiltering: false,
      filterPlaceholder: 'Buscar Estado(s)',
      nonSelectedText: 'Ningun estado seleccionado',
      nSelectedText: 'seleccionados',
      includeSelectAllOption: true,
      selectAllText: 'Seleccionar todos',
      allSelectedText: 'Todos los estados seleccionados',
      onChange: function (option, checked) {

        var selectedOption = $('#inputEditStates option:selected');

        if (selectedOption.length <=0) {

          $('#inputEditStates')[0].setCustomValidity("Ningun estado seleccionado, por favor seleccione");

        }else{

          $('#inputEditStates')[0].setCustomValidity('');
          
        }

      }
    });

});

/**
 * Function to get an specific row info for edit a zone
 */
$('.edt-zone').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  
    $row = $(this).closest('tr');    // Find the row
    $id = $row.find('#zoneId').text(); // Find the id text
    $name = $row.find('#zoneName').text(); // Find the name text
    $seller = $row.find('#zoneSellerId').text(); // Find the seller name text
    $arrStates = []; //array to save the states contained in such zone
  
    $row.find('.state-id').each( function() { //for each state of such zone, do...
        $arrStates.push($(this).text()); // fill the array with the current loop state text
    });
  
    return{ //set all info on each form field
      first: $('#inputEditId').val($id), //setting value of the input through its html id
      second: $('#inputEditName').val($name), //setting value of the input through its html id
      third: $('#inputEditSeller').val($seller).change(), //setting value of the input through its html id
      fourth: $('#inputEditStates').multiselect('select', $arrStates)
    };
  });

/**
 * Function to get an specific row info for delete a zone
 */
$('.dlt-zone').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  $row = $(this).closest('tr');    // Find the row
  $id = $row.find('#zoneId').text(); // Find the id text
  $name = $row.find('#zoneName').text(); // Find the name text

  return{ //set all info on each form field
    first: $('#inputDeleteId').val($id), //setting value of the input through its html id
    second: $('#deleteModalDiv').html("¿Estás seguro que quieres eliminar la siguiente zona <b>" + $name +"</b>?") //setting the html content within the invoked div
  };
});