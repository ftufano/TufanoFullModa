/*
|--------------------------------------------------------------------------
| Custom Tufano... Full Moda!! JS
|--------------------------------------------------------------------------
|
| These file is used to create custom JS functionalities to perform on the app
| 
| 
| Author: Caelum Dev
*/

/**
 * Function to fill dashes telephone format
 */

 $(document).ready(function () { //when the DOM is loaded, run these functions
  // Toggle the side navigation when window is resized below 480px
  if ($(window).width() < 1024) {
    $("body").addClass("sidebar-toggled");
    $(".sidebar").addClass("toggled");
    $('.sidebar .collapse').collapse('hide');
  };88
});

$(function () {

  $('#inputTelephone').click(function (e) { //Function to format the input value to just numbers
    $text = $(this); //Getting the input field value on a variable
    
    $text.val($text.val().replace(/[^0-9]/g, "")); //Setting the $text value by replacing any character but numbers using a RegEx

  })

  $('#inputTelephone').keyup(function (e) {  //Function to check on keypressing up if the phone value is more than 10 digits
    $text = $(this); //Getting the input field value on a variable

    if ($text.val().length > 10){ //If the input value length is higher than 10
      $text.val($text.val().substr(0, 10)); //Substitute the variable text for a substring of it with 10 digits length
    }

    return($('#inputTelephone').val($text.val())); //Return in the input field the text value

  })

  $('#inputTelephone').keydown(function (e) { //Function to check which keys are allowed on the input
    var key = e.charCode || e.keyCode || 0; //Getting the keyboard event numbers or codes
    $text = $(this); //Getting the input field value on a variable
    
    //Returning only allowed keys (backspace, tab, supress, normal number keys, numpad keys, arrows)
    return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key >= 37 && key <= 40));
  })

  $('#inputTelephone').blur(function (e){ //Function to format the input value on phone value by clicking out of the input field
    $text = $(this); //Getting the input field value on a variable

    var tlf3 = $text.val().substr(0, 3) + '-'; //variable for the 3 first digits and adding the dash (-) symbol
    var tlf7 = $text.val().substr(3, 3) + '-'; //variable for the 3 second digits and adding the dash (-) symbol
    var tlf10 = $text.val().substr(6, 4); //variable for the 4 last digits
    
    return($('#inputTelephone').val(tlf3+tlf7+tlf10));//Return in the input field the phone text value formatted
  })

});

/**
 * Function to fill thousand colons and decimal point for inputPrice
 */
$(function () {

  $('#inputPrice').click(function (e) { //Function to format the input value to just numbers and decimals
    $text = $(this); //Getting the input field value on a variable
    var intString; //Variable declaration for the integer currency value
    var decString = ""; //Variable declaration for the decimal currency value, initialized on none since may be not decimal value

    if ($text.val().indexOf(".") > -1){ //If there's a decimal dot on the input value
      intString = $text.val().substr(0, $text.val().indexOf('.')); //Get the integer value
      decString = $text.val().substr($text.val().indexOf('.'), 3); //Get the decimal value including the decimal dot up to 2 decimals
    }else{ //Else if there is not decimal dot on the input value
      intString = $text.val(); //Fill the integer variable with the whole input value
    }

    intString = intString.replace(/[^0-9]/g, ""); //Setting the integer value by replacing any character but numbers using a RegEx

    return ($('#inputPrice').val(intString+decString)); //Return in the input field the integer value along the decimal value if the decimal value exists

  })

  $('#inputPrice').keydown(function (e) { //Function to check which keys are allowed on the input
    var key = e.charCode || e.keyCode || 0; //Getting the keyboard event numbers or codes
    $text = $(this); //Getting the input field value on a variable´

    $text.val($text.val().replace(/[^0-9.]/g, "")); //Setting the $text value by replacing any character but numbers using a RegEx
    
    //Returning only allowed keys (backspace, tab, normal dot, numpad dot, supress, normal number keys, numpad keys, arrows)
    return (key == 8 || key == 9 || key == 46 || key == 190 || key == 110 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key >= 37 && key <= 40));
  })

  $('#inputPrice').blur(function(e) { //Function to format the input value on currency value by clicking out of the input field
    $text = $(this); //Getting the input field value on a variable

    if ($text.val().indexOf(".") > -1){ //If there's a decimal dot on the input value
      var input = $text.val(); //Variable declaration for encapsulate the field value
      
      var intString = input.substr(0, input.indexOf('.')); //Get the integer value
      var decString = input.substr(input.indexOf('.')); //Get the decimal value including the decimal dot
      
      intString = intString ? parseInt( intString, 10 ) : 0; //If intString exists, then output intString, else parse it to an integer value

      if (decString.substr(1, 3).indexOf(".") > -1) { //If there's another dot on the decimal value besides the initial main decimal dot
        decString ="." + decString.substr(1, 3).replace(/\./g, ""); //Delete those additional dot using a RegEx
        if (decString.substr(1, 3).length < 2){ //If the decimal value has only 1 digit
          decString = decString + "0"; //Fill it with a 0 on the right, ex .6 will be .60
        }
      }else{ //Else if there's no another dot on the decimal value besides the initial main decimal dot
        if (decString.substr(1, 3).length < 2){ //If the decimal value has only 1 digit
          decString = decString + "0"; //Fill it with a 0 on the right, ex .6 will be .60
        }else{ //Else if none of the previous IF occur
        decString = decString.substr(0,3); //Set the decimal value to use
        }
      }
      
      $text.val( function() { //Function to set the $text value to output
        //If the $text value is empty, set intString value to 0, else set the IntString to the US currency format and add the 2 decimal values
        return ( intString === 0 && decString == ".00" ) ? "" : intString.toLocaleString( "en-US") + decString;
      } );

    }else{ //If there's no decimal dot on the input value
    var input = $text.val(); //Variable declaration for encapsulate the field value
    
    var input = input.replace(/[^0-9]/g, ""); //Setting the input value by replacing any character but numbers using a RegEx
        input = input ? parseInt( input, 10 ) : 0; //If input exists, then output input, else parse it to an integer value

        $text.val( function() { //Function to set the $text value to output
          //If the $text value is empty, set intString value to 0, else set the IntString to the US currency format and 
          //add the 2 decimal values to "00" by bounding them with the Min and Max Fraction function
          return ( input === 0 ) ? "" : input.toLocaleString( "en-US", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        } );
    }
        
  })

});

/**
 * Function to fill thousand colons and decimal point for inputEditPrice
 */
 $(function () {

  $('#inputEditPrice').click(function (e) { //Function to format the input value to just numbers and decimals
    $text = $(this); //Getting the input field value on a variable
    var intString; //Variable declaration for the integer currency value
    var decString = ""; //Variable declaration for the decimal currency value, initialized on none since may be not decimal value

    if ($text.val().indexOf(".") > -1){ //If there's a decimal dot on the input value
      intString = $text.val().substr(0, $text.val().indexOf('.')); //Get the integer value
      decString = $text.val().substr($text.val().indexOf('.'), 3); //Get the decimal value including the decimal dot up to 2 decimals
    }else{ //Else if there is not decimal dot on the input value
      intString = $text.val(); //Fill the integer variable with the whole input value
    }

    intString = intString.replace(/[^0-9]/g, ""); //Setting the integer value by replacing any character but numbers using a RegEx

    return ($('#inputEditPrice').val(intString+decString)); //Return in the input field the integer value along the decimal value if the decimal value exists

  })

  $('#inputEditPrice').keydown(function (e) { //Function to check which keys are allowed on the input
    var key = e.charCode || e.keyCode || 0; //Getting the keyboard event numbers or codes
    $text = $(this); //Getting the input field value on a variable´

    $text.val($text.val().replace(/[^0-9.]/g, "")); //Setting the $text value by replacing any character but numbers using a RegEx
    
    //Returning only allowed keys (backspace, tab, normal dot, numpad dot, supress, normal number keys, numpad keys, arrows)
    return (key == 8 || key == 9 || key == 46 || key == 190 || key == 110 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key >= 37 && key <= 40));
  })

  $('#inputEditPrice').blur(function(e) { //Function to format the input value on currency value by clicking out of the input field
    $text = $(this); //Getting the input field value on a variable

    if ($text.val().indexOf(".") > -1){ //If there's a decimal dot on the input value
      var input = $text.val(); //Variable declaration for encapsulate the field value
      
      var intString = input.substr(0, input.indexOf('.')); //Get the integer value
      var decString = input.substr(input.indexOf('.')); //Get the decimal value including the decimal dot
      
      intString = intString ? parseInt( intString, 10 ) : 0; //If intString exists, then output intString, else parse it to an integer value

      if (decString.substr(1, 3).indexOf(".") > -1) { //If there's another dot on the decimal value besides the initial main decimal dot
        decString ="." + decString.substr(1, 3).replace(/\./g, ""); //Delete those additional dot using a RegEx
        if (decString.substr(1, 3).length < 2){ //If the decimal value has only 1 digit
          decString = decString + "0"; //Fill it with a 0 on the right, ex .6 will be .60
        }
      }else{ //Else if there's no another dot on the decimal value besides the initial main decimal dot
        if (decString.substr(1, 3).length < 2){ //If the decimal value has only 1 digit
          decString = decString + "0"; //Fill it with a 0 on the right, ex .6 will be .60
        }else{ //Else if none of the previous IF occur
        decString = decString.substr(0,3); //Set the decimal value to use
        }
      }
      
      $text.val( function() { //Function to set the $text value to output
        //If the $text value is empty, set intString value to 0, else set the IntString to the US currency format and add the 2 decimal values
        return ( intString === 0 && decString == ".00" ) ? "" : intString.toLocaleString( "en-US") + decString;
      } );

    }else{ //If there's no decimal dot on the input value
    var input = $text.val(); //Variable declaration for encapsulate the field value
    
    var input = input.replace(/[^0-9]/g, ""); //Setting the input value by replacing any character but numbers using a RegEx
        input = input ? parseInt( input, 10 ) : 0; //If input exists, then output input, else parse it to an integer value

        $text.val( function() { //Function to set the $text value to output
          //If the $text value is empty, set intString value to 0, else set the IntString to the US currency format and 
          //add the 2 decimal values to "00" by bounding them with the Min and Max Fraction function
          return ( input === 0 ) ? "" : input.toLocaleString( "en-US", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        } );
    }
        
  })

});

/**
 * Function to get an specific row info for edit a category
 */
$('.edt-ctg').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  
  $row = $(this).closest('tr');    // Find the row
  $id = $row.find('#categoryId').text(); // Find the id text
  $name = $row.find('#categoryName').text(); // Find the name text

  return{ //set all info on each form field
    first: $('#inputEditId').val($id), //setting value of the input through its html id
    second: $('#inputEditCategoryName').val($name), //setting value of the input through its html id
  };
});

/**
 * Function to get an specific row info for delete an user
 */
$('.dlt-ctg').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  $row = $(this).closest('tr');    // Find the row
  $id = $row.find('#categoryId').text(); // Find the id text
  $name = $row.find('#categoryName').text(); // Find the name text

  return{ //set all info on each form field
    first: $('#inputDeleteId').val($id), //setting value of the input through its html id
    second: $('#deleteModalDiv').html("¿Estás seguro que quieres eliminar la categoría <b>" + $name +"</b>?") //setting the html content within the invoked div
  };
});

/**
 * Function to get an specific row info for edit a status
 */
$('.edt-stu').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  
  $row = $(this).closest('tr');    // Find the row
  $id = $row.find('#statusId').text(); // Find the id text
  $name = $row.find('#statusName').text(); // Find the name text

  return{ //set all info on each form field
    first: $('#inputEditId').val($id), //setting value of the input through its html id
    second: $('#inputEditStatusName').val($name), //setting value of the input through its html id
  };
});

/**
 * Function to get an specific row info for delete an user
 */
$('.dlt-stu').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  $row = $(this).closest('tr');    // Find the row
  $id = $row.find('#statusId').text(); // Find the id text
  $name = $row.find('#statusName').text(); // Find the name text

  return{ //set all info on each form field
    first: $('#inputDeleteId').val($id), //setting value of the input through its html id
    second: $('#deleteModalDiv').html("¿Estás seguro que quieres eliminar el status <b>" + $name +"</b>?") //setting the html content within the invoked div
  };
});

/**
 * Function to get an specific row info for edit a state
 */
$('.edt-stt').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  
  $row = $(this).closest('tr');    // Find the row
  $id = $row.find('#stateId').text(); // Find the id text
  $name = $row.find('#stateName').text(); // Find the name text

  return{ //set all info on each form field
    first: $('#inputEditId').val($id), //setting value of the input through its html id
    second: $('#inputEditStateName').val($name), //setting value of the input through its html id
  };
});

/**
 * Function to get an specific row info for delete an user
 */
$('.dlt-stt').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  $row = $(this).closest('tr');    // Find the row
  $id = $row.find('#stateId').text(); // Find the id text
  $name = $row.find('#stateName').text(); // Find the name text

  return{ //set all info on each form field
    first: $('#inputDeleteId').val($id), //setting value of the input through its html id
    second: $('#deleteModalDiv').html("¿Estás seguro que quieres eliminar al estado <b>" + $name +"</b>?") //setting the html content within the invoked div
  };
});

/**
 * Function to get an specific row info for edit an user
 */
 $('.edt-usr').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  
  $row = $(this).closest('tr');    // Find the row
  $id = $row.find('#userId').text(); // Find the id text
  $name = $row.find('#userName').text(); // Find the name text
  $email = $row.find('#userEmail').text(); // Find the email text
  $phone = $row.find('#userPhone').text(); // Find the phone text
  $type = $row.find('#userType').text(); // Find the user type text
  
  if ($type == 'Administrador'){
    $valType = $('#inputEditUserType').val('Administrador').change();
  }else if ($type == 'Vendedor'){
    $valType = $('#inputEditUserType').val('Vendedor').change();
  }else if ($type == 'Cliente'){
    $valType = $('#inputEditType').val('Cliente').change();
  }

  return{ //set all info on each form field
    first: $('#inputEditId').val($id), //setting value of the input through its html id
    second: $('#inputEditName').val($name), //setting value of the input through its html id
    third: $('#inputEditEmail').val($email), //setting value of the input through its html id
    fourth: $('#inputEditPhone').val($phone), //setting value of the input through its html id
    fifth: $valType //setting value of the form selector input value
  };
});

/**
 * Function to get an specific row info for delete an user
 */
$('.dlt-usr').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  $row = $(this).closest('tr');    // Find the row
  $id = $row.find('#userId').text(); // Find the id text
  $name = $row.find('#userName').text(); // Find the name text

  return{ //set all info on each form field
    first: $('#inputDeleteId').val($id), //setting value of the input through its html id
    second: $('#deleteModalDiv').html("¿Estás seguro que quieres eliminar el usuario <b>" + $name +"</b>?") //setting the html content within the invoked div
  };
});

/**
 * Function to validate password confirmation on New User modal
 */
$('#inputConfirmPassword').keyup(function() { //function enabled on every keyup on the input box
  var password = document.getElementById("inputPassword") //encapsulate on the variable password the inputPassword element itself
  , confirm_password = document.getElementById("inputConfirmPassword"); //encapsulate on the variable confirm_password the inputConfirmPassword element itself

    if(password.value != confirm_password.value) { //if the password value is different to confirm_password value
      confirm_password.setCustomValidity("Las contraseñas no coinciden"); //throw the validation with the desired message
    } else { //if variables values are equal
      confirm_password.setCustomValidity(''); //do not throw a validation message
    }
});

/**
 * Function to check if depending the the Edit Password Input is empty or not then set the Confirm
 * Edit Password Input required or not
 */
$('#inputEditPassword').keyup(function() { //function enabled on every keyup on the input box
  var password = document.getElementById("inputEditPassword") //encapsulate on the variable password the inputEditPassword element itself
  , confirm_password = document.getElementById("inputEditConfirmPassword"); //encapsulate on the variable confirm_password the inputEditConfirmPassword element itself

  if(password.value != ''){ //if password value is not empty
    confirm_password.required = true; //set confirm_password element as required
  }else{ //if password value is empty
    confirm_password.required = false; //set confirm_password element not required
  }
});

/**
 * Function to validate password confirmation on Edit User modal
 */
$('#inputEditConfirmPassword').keyup(function() { //function enabled on every keyup on the input box
  var password = document.getElementById("inputEditPassword")  //encapsulate on the variable password the inputEditPassword element itself
  , confirm_password = document.getElementById("inputEditConfirmPassword"); //encapsulate on the variable confirm_password the inputEditConfirmPassword element itself

    if(password.value != confirm_password.value) { //if the password value is different to confirm_password value
      confirm_password.setCustomValidity("Las contraseñas no coinciden"); //throw the validation with the desired message
    } else { //if variables values are equal
      confirm_password.setCustomValidity(''); //do not throw a validation message
    }
});

/**
 * Function to validate add season end date through input only (not submit)
 */
inputAddEnd.addEventListener('input', function(){ //add event listener to the inputAddEnd element which it is triggered when the element receives user inputs
  var startDate = document.getElementById("inputAddStart"); //encapsulate on the variable startDate the inputAddStart element itself
  var endDate = document.getElementById("inputAddEnd"); //encapsulate on the variable endDate the inputAddEnd element itself

  var endRDate = document.getElementById("inputRAddEnd"); //encapsulate on the variable endRDate the inputRAddEnd element itself
  var rDate = new Date(endDate.value) //encapsulate on the variable rDate a new Date from the endDate value
  endRDate.value = new Date(rDate.setDate(rDate.getDate() +1)).toISOString().split('T')[0]; //setting the endRDate value as a new Date from the rDate date
  // by adding 1 day and then setting the format date to yyyy-mm-dd... This new value is used to be sent through the form for DB queries
  //the 1 day plus on the end date is since the event is a full day event the end day is always the end day + 1 day in fullcalendar standards

  if (startDate.value > endDate.value) { //if startDate date is over the endDate date
    endDate.setCustomValidity("La fecha de fin es igual o está antes la fecha de inicio del periodo"); //throw the validation with the desired message
  } else { //if startDate date is under or equal the endDate date
    endDate.setCustomValidity(''); //do not throw a validation message
  }
});

/**
 * Function to validate add season ship date through input only (not submit)
 */
 inputAddShip.addEventListener('input', function(){ //add event listener to the inputAddShip element which it is triggered when the element receives user inputs
  var endDate = document.getElementById("inputAddEnd"); //encapsulate on the variable endDate the inputAddEnd element itself
  var shipDate = document.getElementById("inputAddShip"); //encapsulate on the variable shipDate the inputAddShip element itself

  if (endDate.value != shipDate.value) { //if endDate date is different the shipDate date
    shipDate.setCustomValidity("La fecha de envío está antes o después de la fecha de fin del periodo"); //throw the validation with the desired message
  } else { //if endDate date is equal the shipDate date
    shipDate.setCustomValidity(''); //do not throw a validation message
  }
});

/**
 * Function to validate add season end and ship date through submit (not input)
 */
function validAddDates(){ //function triggered through onclick method on the HTML submit button
  var startDate = document.getElementById("inputAddStart"); //encapsulate on the variable startDate the inputAddStart element itself
  var endDate = document.getElementById("inputAddEnd"); //encapsulate on the variable endDate the inputAddEnd element itself
  var shipDate = document.getElementById("inputAddShip"); //encapsulate on the variable shipDate the inputAddShip element itself

  if (startDate.value > endDate.value) { //if startDate date is over the endDate date
    endDate.setCustomValidity("La fecha de fin es igual o está antes la fecha de inicio del periodo"); //throw the validation with the desired message
  } else { //if startDate date is under or equal the endDate date
    endDate.setCustomValidity(''); //do not throw a validation message
  }

  if (endDate.value != shipDate.value) { //if endDate date is different the shipDate date
    shipDate.setCustomValidity("La fecha de envío está antes o después de la fecha de fin del periodo"); //throw the validation with the desired message
  } else { //if endDate date is equal the shipDate date
    shipDate.setCustomValidity(''); //do not throw a validation message
  }

};

/**
 * Function to validate edit season end date through input only (not submit)
 */
 inputEditEnd.addEventListener('input', function(){ //add event listener to the inputEditEnd element which it is triggered when the element receives user inputs
  var startDate = document.getElementById("inputEditStart"); //encapsulate on the variable startDate the inputEditStart element itself
  var endDate = document.getElementById("inputEditEnd"); //encapsulate on the variable endDate the inputEditEnd element itself

  var endRDate = document.getElementById("inputREditEnd"); //encapsulate on the variable endRDate the inputREditEnd element itself
  var rDate = new Date(endDate.value) //encapsulate on the variable rDate a new Date from the endDate value
  endRDate.value = new Date(rDate.setDate(rDate.getDate() +1)).toISOString().split('T')[0];//setting the endRDate value as a new Date from the rDate date
  // by adding 1 day and then setting the format date to yyyy-mm-dd... This new value is used to be sent through the form for DB queries
  //the 1 day plus on the end date is since the event is a full day event the end day is always the end day + 1 day in fullcalendar standards

  if (startDate.value >= endDate.value) { //if startDate date is over or equal the endDate date
    endDate.setCustomValidity("La fecha de fin es igual o está antes la fecha de inicio del periodo"); //throw the validation with the desired message
  } else { //if startDate date is under endDate date
    endDate.setCustomValidity(''); //do not throw a validation message
  }
});

/**
 * Function to validate add season ship date through input only (not submit)
 */
 inputEditShip.addEventListener('input', function(){ //add event listener to the inputEditShip element which it is triggered when the element receives user inputs
  var endDate = document.getElementById("inputEditEnd"); //encapsulate on the variable endDate the inputEditEnd element itself
  var shipDate = document.getElementById("inputEditShip"); //encapsulate on the variable shipDate the inputEditShip element itself

  if (endDate.value != shipDate.value) { //if endDate date is different to shipDate date
    shipDate.setCustomValidity("La fecha de envío está antes la fecha de fin del periodo"); //throw the validation with the desired message
  } else { //if endDate date is equal to shipDate date
    shipDate.setCustomValidity(''); //do not throw a validation message
  }
});

/**
 * Function to validate edit season end and ship date through submit (not input)
 */
function validEditDates(){ //function triggered through onclick method on the HTML submit button
  var startDate = document.getElementById("inputEditStart"); //encapsulate on the variable startDate the inputEditStart element itself
  var endDate = document.getElementById("inputEditEnd"); //encapsulate on the variable endDate the inputEditEnd element itself
  var shipDate = document.getElementById("inputEditShip"); //encapsulate on the variable shipDate the inputEditShip element itself

  if (startDate.value >= endDate.value) { //if startDate date is over or equal the endDate date
    endDate.setCustomValidity("La fecha de fin es igual o está antes la fecha de inicio del periodo"); //throw the validation with the desired message
  } else { //if startDate date is under endDate date
    endDate.setCustomValidity(''); //do not throw a validation message
  }

  if (endDate.value != shipDate.value) { //if endDate date is different to shipDate date
    shipDate.setCustomValidity("La fecha de envío está antes la fecha de fin del periodo"); //throw the validation with the desired message
  } else { //if endDate date is equal to shipDate date
    shipDate.setCustomValidity(''); //do not throw a validation message
  }
};

/**
 * Function to pass data to delete period modal
 */
 $('.dlt-ssn').click(function() {//Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  $id = $('#inputEditId').val(); //Find the id text
  $type = $('#inputEditType').children("option:selected").text(); //Find the name text

  return{ //set all info on each form field
    first: $('#inputDeleteId').val($id), //setting value of the input through its html id
    second: $('#deleteModalDiv').html("¿Estás seguro que quieres eliminar el periodo <b>" + $type +"</b>?") //setting the html content within the invoked div
  };
});

/**
 * Function to get the values for each field in the form by ID on Quota's form
 */
$(document).ready(function(){ //run the function when the DOM is ready
  $('#addQuotaSsnSlct').on('change', function(){ //run the feature when the addQuotaSsnSlct change the selected option

    $id = $('#addQuotaSsnSlct option:selected').val(); //encapsulate on the variable $id the addQuotaSsnSlct option selected value
    
    $('#addQuotaSsnIdSlct').val($id).change(); //change the addQuotaSsnIdSlct option selected based on the $id value which is the same value as the addQuotaSsnSlct option selected

    $('#addQuotaSsnTpSlct').val($id).change(); //change the addQuotaSsnTpSlct option selected based on the $id value which is the same value as the addQuotaSsnSlct option selected

    $('#addQuotaSsnStrtDtSlct').val($id).change(); //change the addQuotaSsnStrtDtSlct option selected based on the $id value which is the same value as the addQuotaSsnSlct option selected

    $('#addQuotaSsnNdDtSlct').val($id).change(); //change the addQuotaSsnNdDtSlct option selected based on the $id value which is the same value as the addQuotaSsnSlct option selected

    $('#inputQuotaAddStart').val(''); //reset inputQuotaAddStart value void

    $('#inputQuotaAddEnd').val(''); //reset inputQuotaAddEnd value void

    $('#inputQuotaAddREnd').val(''); //reset inputQuotaAddREnd value void

    $('#addQuotaTpNpt').val($('#addQuotaSsnTpSlct option:selected').text()); //set addQuotaTpNpt input value the addQuotaSsnTpSlct option selected text

    $('#inputQuotaAddStart').attr("min", $('#addQuotaSsnStrtDtSlct option:selected').text()); //set the inputQuotaAddStart min attribute the addQuotaSsnStrtDtSlct option selected text

    $('#inputQuotaAddStart').attr("max", $('#addQuotaSsnNdDtSlct option:selected').text()); //set the inputQuotaAddStart max attribute the addQuotaSsnNdDtSlct option selected text

    $('#inputQuotaAddEnd').attr("min", $('#addQuotaSsnStrtDtSlct option:selected').text()); //set the inputQuotaAddEnd min attribute the addQuotaSsnStrtDtSlct option selected text
    
    $('#inputQuotaAddEnd').attr("max", $('#addQuotaSsnNdDtSlct option:selected').text()); //set the inputQuotaAddEnd max attribute the addQuotaSsnNdDtSlct option selected text
    
  });

  $('#addQuotaSsnSlct').trigger('change'); //to run the function 'change' on the element load or refresh

});

/**
 * Function to set end date from the selected start date on Quota's form
 */
 $('#inputQuotaAddStart').on('change', function(){ //run the feature when the inputQuotaAddStart value change

  $('#inputQuotaAddEnd').attr("min", $('#inputQuotaAddStart').val()); //set the inputQuotaAddEnd min attribute the inputQuotaAddStart value 

 });

   /**
 * Function to validate edit season end and ship date through submit (not input)
 */
function validQuotaAddDates(){ //function triggered through onclick method on the HTML submit button
  var startDate = document.getElementById("inputQuotaAddStart"); //encapsulate on the variable startDate the inputQuotaAddStart element itself
  var endDate = document.getElementById("inputQuotaAddEnd"); //encapsulate on the variable endDate the inputQuotaAddEnd element itself

  if (startDate.value > endDate.value) { //if startDate date is over the endDate date
    endDate.setCustomValidity("La fecha de fin está antes la fecha de inicio del periodo"); //throw the validation with the desired message
  } else { //if startDate date is under or equal endDate date
    endDate.setCustomValidity(''); //do not throw a validation message
  }

};

/**
 * Function to pass data to delete quota modal
 */
 $('.dlt-qt').click(function() { //Click on the button, for this specific function needs to call the element through class instead id attribute otherwise won't work
  $id = $('#inputEditQuotaId').val(); //Find the id text
  $type = $('#editQuotaTtlSlct').children("option:selected").text(); //Find the name text
  $qtDate = $('#inputQuotaEditStart').val(); //encapsulate on the variable $qtDate the inputQuotaEditStart value

  return{ //set all info on each form field
    first: $('#inputQuotaDeleteId').val($id), //setting value of the input through its html id
    second: $('#quotaDeleteModalDiv').html("¿Estás seguro que quieres eliminar los <b>" + $type +"</b> de fecha <b>" + $qtDate + "</b>?") //setting the html content within the invoked div
  };
});