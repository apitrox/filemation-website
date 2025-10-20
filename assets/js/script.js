$(function(){
	$('.datepicker').datepicker()
	$('.tooltip').tooltip();
});
$(function(){
	$('#To_Be_Filed_File_Grid').dataTable({  // the users grid on the users interface
//		"processing": true,
//		"serverSide": true,
//		"ajax": {
//		    "url": "/json/GetAccountToBeFiledFiles/",
//		    "dataType": "json"
//		},
		"sDom": '<"top">t<"bottom"><"clear">'
	});
});

function ResetForm(form_id)
{
	$('#' + form_id + ' :input[type="text"]').each(function(index, item){
		$(this).attr('id');
	});
	$('#' + form_id + ' :input[type="number"]').each(function(index, item){
		$(this).attr('id');
	});
}

function ResetTextfield(textfield_el)
{
	var orig_background_color = '#FFFFFF';
	var orig_border_color = '#CCCCCC';
	var orig_shadow = 'insert 0 1px 1px rgba(0, 0, 0, 0.075)';
	
	$(textfield_el).css('background-color', orig_background_color);
	$(textfield_el).css('border-color', orig_border_color);
	$(textfield_el).css('-webkit-box-shadow', orig_shadow);
	$(textfield_el).css('box-shadow', orig_shadow);
	
	$(this).tooltip('hide');
}

function ValidateFilerCriteria(form_id)
{
	var error = false;
	$('#' + form_id + ' input').each(function(index, item){
		
		var this_error = false;
		var border_color = "#A94442";
		var background_color = "#FFF7F7";
		
		$(this).keyup(function(event){
			ResetTextfield(this);
		});
		
		// handle requird elements first
		if( $(this).hasClass('required') && this.value.trim() == '' )
		{
			console.log($(this).attr('id'));
			error = true;
			this_error = true;
		}
		
		// handle minimum character lengths
		var criteria_min_length = $(this).attr('data-min-length');
		if( (criteria_min_length != '' && criteria_min_length != 'undefined') && (this.value.length < parseInt(criteria_min_length)) )
		{
			this_error = true;
			error = true;
		}
		
		
		if( this_error )
		{
			$(this).css('border-color', border_color);
			$(this).css('background-color', background_color);
			$(this).tooltip('show');
		}
		else
		{
			ResetTextfield(this);
		}
		
		
	});
	
	return error;
}

// Reformats a number by inserting commas and padding out the number of digits
// and decimal places.
//
// Parameters:
//     number:        The number to format. All non-numeric characters are
//                    stripped out first.
//     digits:        The minimum number of digits to the left of the decimal
//                    point. The extra places are padded with zeros.
//     decimalPlaces: The number of places after the decimal point, or zero to
//                    omit the decimal point.
//     withCommas:    True to insert commas every 3 places, false to omit them.
function FormatNumber(number, digits, decimalPlaces, withCommas)
{
        number       = number.toString();
    var simpleNumber = '';

    // Strips out the dollar sign and commas.
    for (var i = 0; i < number.length; ++i)
    {
        if ("0123456789.".indexOf(number.charAt(i)) >= 0)
            simpleNumber += number.charAt(i);
    }

    number = parseFloat(simpleNumber);

    if (isNaN(number))      number     = 0;
    if (withCommas == null) withCommas = false;
    if (digits     == 0)    digits     = 1;

    var integerPart = (decimalPlaces > 0 ? Math.floor(number) : Math.round(number));
    var string      = "";

    for (var i = 0; i < digits || integerPart > 0; ++i)
    {
        // Insert a comma every three digits.
        if (withCommas && string.match(/^\d\d\d/))
            string = "," + string;

        string      = (integerPart % 10) + string;
        integerPart = Math.floor(integerPart / 10);
    }

    if (decimalPlaces > 0)
    {
        number -= Math.floor(number);
        number *= Math.pow(10, decimalPlaces);

        string += "." + FormatNumber(number, decimalPlaces, 0);
    }

    return string;
}

function FormatDate(date_value, date_format)
{
	var date = Date.parse(date_value);
	
	var format;
	switch(date_format)
	{
		case 'm-d-yyyy':
			format = 'M-d-yyyy';
			break;
		case 'yyyy-m-d':
			format = 'yyyy-d-M';
			break;
		case 'mm-dd-yyyy':
			format = 'MM-dd-yyyy';
			break;
		case 'yyyy-mm-dd':
			format = 'yyyy-MM-dd';
			break;
		case 'm.d.yyyy':
			format = 'M.d.yyyy';
			break;
		case 'yyyy.m.d':
			format = 'yyyy.M.d';
			break;
		case 'mm.dd.yyyy':
			format = 'MM.dd.yyyy';
			break;
		case 'yyyy.mm.dd':
			format = 'yyyy.MM.dd';
			break;
		case 'm-d-yy':
			format = 'M-d-yy';
			break;
		case 'mm-dd-yy':
			format = 'MM-dd-yy';
			break;
		case 'm.d.yy':
			format = 'M.d.yy';
			break;
		case 'mm.dd.yy':
			format = 'MM.dd.yy';
			break;
	}
	
	var new_date = date.toString(format);
	
	return new_date;
}

function MapKeyPressToActualCharacter(isShiftKey, characterCode)
{
	if ( characterCode === 27 || characterCode === 8 || characterCode === 9 || characterCode === 20 || characterCode === 16 || characterCode === 17 || characterCode === 91 || characterCode === 13 || characterCode === 92 || characterCode === 18 ) {
	    return false;
	}
	if (typeof isShiftKey != "boolean" || typeof characterCode != "number") {
	    return false;
	}
	var characterMap = [];
	characterMap[192] = "~";
	characterMap[49] = "!";
	characterMap[50] = "@";
	characterMap[51] = "#";
	characterMap[52] = "$";
	characterMap[53] = "%";
	characterMap[54] = "^";
	characterMap[55] = "&";
	characterMap[56] = "*";
	characterMap[57] = "(";
	characterMap[48] = ")";
	characterMap[109] = "_";
	characterMap[107] = "+";
	characterMap[219] = "{";
	characterMap[221] = "}";
	characterMap[220] = "|";
	characterMap[59] = ":";
	characterMap[222] = "\"";
	characterMap[188] = "<";
	characterMap[190] = ">";
	characterMap[191] = "?";
	characterMap[32] = " ";
	var character = "";
	if (isShiftKey) {
	    if ( characterCode >= 65 && characterCode <= 90 ) {
		   character = String.fromCharCode(characterCode);
	    } else {
		   character = characterMap[characterCode];
	    }
	} else {
	    if ( characterCode >= 65 && characterCode <= 90 ) {
		   character = String.fromCharCode(characterCode).toLowerCase();
	    } else {
		   character = String.fromCharCode(characterCode);
	    }
	}
	return character;
 }

function ValidateDateTextfield(event)
{
	//var the_event = evt || window.event;
	
	var regex = new RegExp("^[0-9?=.*!@#$%^&*]+$");
	var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
	   // event.preventDefault();
	    //return false;
	}
}