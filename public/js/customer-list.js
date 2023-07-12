$(document).ready(function() {

    addZonesAndSellerByState($('#inputState'));

});

$('#inputState').on('change', function() {

    addZonesAndSellerByState($(this));

});

$('#inputZone').on('change', function() {

    addSellerByZone($(this));

});

$('#inputState').on('change', function() {

    addZonesAndSellerByState($(this));

});

$('#inputEditState').on('change', function() {

    editZonesAndSellerByState($(this));

});

$('#inputEditZone').on('change', function() {

    editSellerByZone($(this));

});

function addZonesAndSellerByState($element) {

    $stateID = $element.val();

    $.ajax({ //run ajax to send the data to the laravel controller for the order list confirmation email send
        type: "POST", //send type
        data:{ //data to be sent to the laravel controller
            "_token": $("meta[name='csrf-token']").attr("content"), //csrf token for laravel security
            state_id: $stateID
        },
        url: "/customer-list/index-zones" //URL where will be sent the data, is the URL of the laravel controller itself
    })
    .done(function( data, jqXHR, textStatus ) { //if the order list confirmation mail POST request was successfull

        if(data.message.length > 0) {

            $('#inputZone').empty();

            $.each(data.message, function(index, itemData) {

                $('#inputZone').append('<option value=' + data.message[index].id + '>' + data.message[index].name + '</option>');

            });

            addSellerByZone($('#inputZone'));            

        } else {

            $('#inputZone').empty();

            $('#inputZone').append('<option value="" disabled selected>'+"No hay zonas registradas en este estado"+'</option>');

            $('#inputSeller').val('No hay vendedor asignado');

        }
        
    })
    .fail(function( data, jqXHR, textStatus ) { //if the order list POST request failed
        console.log(data.responseJSON.message); //show on console the status + status error message
    });

};

function editZonesAndSellerByState($element, $zoneID) {

    $stateID = $element.val();

    $.ajax({ //run ajax to send the data to the laravel controller for the order list confirmation email send
        type: "POST", //send type
        data:{ //data to be sent to the laravel controller
            "_token": $("meta[name='csrf-token']").attr("content"), //csrf token for laravel security
            state_id: $stateID
        },
        url: "/customer-list/index-zones" //URL where will be sent the data, is the URL of the laravel controller itself
    })
    .done(function( data, jqXHR, textStatus ) { //if the order list confirmation mail POST request was successfull

        if(data.message.length > 0) {

            $('#inputEditZone').empty();

            $.each(data.message, function(index, itemData) {

                $('#inputEditZone').append('<option value=' + data.message[index].id + '>' + data.message[index].name + '</option>');

            });

            if($zoneID != null) {

                $('#inputEditZone').val($zoneID);

            }

            editSellerByZone($('#inputEditZone'));            

        } else {

            $('#inputEditZone').empty();

            $('#inputEditZone').append('<option value="" disabled selected>'+"No hay zonas registradas en este estado"+'</option>');

            $('#inputEditSeller').val('No hay vendedor asignado');

        }
        
    })
    .fail(function( data, jqXHR, textStatus ) { //if the order list POST request failed
        console.log(data.responseJSON.message); //show on console the status + status error message
    });

};

function addSellerByZone($element) {

    $zoneID = $element.val();

        $.ajax({ //run ajax to send the data to the laravel controller for the order list confirmation email send
            type: "POST", //send type
            data:{ //data to be sent to the laravel controller
                "_token": $("meta[name='csrf-token']").attr("content"), //csrf token for laravel security
                zone_id: $zoneID
            },
            url: "/customer-list/index-sellers" //URL where will be sent the data, is the URL of the laravel controller itself
        })
        .done(function( data, jqXHR, textStatus ) { //if the order list confirmation mail POST request was successfull

            $('#inputSeller').val(data.message[0].seller_name);
            
        })
        .fail(function( data, jqXHR, textStatus ) { //if the order list POST request failed
            console.log(data); //show on console the status + status error message
        });

}

function editSellerByZone($element) {

    $zoneID = $element.val();
    console.log($zoneID)

        $.ajax({ //run ajax to send the data to the laravel controller for the order list confirmation email send
            type: "POST", //send type
            data:{ //data to be sent to the laravel controller
                "_token": $("meta[name='csrf-token']").attr("content"), //csrf token for laravel security
                zone_id: $zoneID
            },
            url: "/customer-list/index-sellers" //URL where will be sent the data, is the URL of the laravel controller itself
        })
        .done(function( data, jqXHR, textStatus ) { //if the order list confirmation mail POST request was successfull

            $('#inputEditSeller').val(data.message[0].seller_name);
            
        })
        .fail(function( data, jqXHR, textStatus ) { //if the order list POST request failed
            console.log(data); //show on console the status + status error message
        });

}

function validAddZone() {

    if(!$('#inputZone').val()) {

        $('#inputZone')[0].setCustomValidity('No se puede agregar cliente sin asignarlo a una zona');

    } else {

        $('#inputZone')[0].setCustomValidity('');

    }

}

function validEditZone() {

    if(!$('#inputEditZone').val()) {

        $('#inputEditZone')[0].setCustomValidity('No se puede agregar cliente sin asignarlo a una zona');

    } else {

        $('#inputEditZone')[0].setCustomValidity('');

    }

}

/**
 * Function to get an specific row info for edit a customer
 */
$('.edt-cmr').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  
    $row = $(this).closest('tr');    // Find the row
    $id = $row.find('#custId').text(); // Find the id text
    $ident = $row.find('#custIdent').text(); // Find the identification text
    $name = $row.find('#custName').text(); // Find the name text
    $address = $row.find('#custAddress').text(); // Find the address text
    $phone = $row.find('#custPhone').text(); // Find the phone text
    $state = $row.find('#custStateId').text(); // Find the state text
    $zone = $row.find('#custZoneId').text(); // Find the state text
    $category = $row.find('#custCategoryId').text(); // Find the category text
    $status = $row.find('#custStatusId').text(); // Find the status text
  
    return{ //set all info on each form field
      first: $('#inputEditId').val($id), //setting value of the input through its html id
      second: $('#inputEditIdent').val($ident), //setting value of the input through its html id
      third: $('#inputEditName').val($name), //setting value of the input through its html id
      fourth: $('#inputEditAddress').val($address), //setting value of the input through its html id
      fifth: $('#inputEditPhone').val($phone), //setting value of the input through its html id
      sixth: $('#inputEditState').val($state), //setting value of the input through its html id
      seventh: editZonesAndSellerByState($('#inputEditState'), $zone),
      eighth: $('#inputEditCategory').val($category), //setting value of the input through its html id
      ninth: $('#inputEditStatus').val($status), //setting value of the input through its html id
    };
  });
  
  /**
   * Function to get an specific row info for delete a customer
   */
  $('.dlt-cmr').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
    $row = $(this).closest('tr');    // Find the row
    $id = $row.find('#custId').text(); // Find the id text
    $name = $row.find('#custName').text(); // Find the name text
  
    return{ //set all info on each form field
      first: $('#inputDeleteId').val($id), //setting value of the input through its html id
      second: $('#deleteModalDiv').html("¿Estás seguro que quieres eliminar al cliente <b>" + $name +"</b>?") //setting the html content within the invoked div
    };
  });