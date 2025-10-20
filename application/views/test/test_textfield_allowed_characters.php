<div class="container">
	<div class="row">
		<input type="text" id="Text" class="form-control" value="" onkeypress="return ValidateTextfieldValue2(event, 'Name');"/>
	</div>
</div>

<script>
	// ^[a-zA-Z 0-9\.\,\+\-]*$
	// /^[-+., A-Za-z0-9]+$/
	// /^[a-z0-9 .,+-]+$/i
	
	function ValidateTextfieldValue2(e,allow)
	{
		var AllowableCharacters = '';

		if (allow == 'Letters'){AllowableCharacters=' ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';}
		if (allow == 'Numbers'){AllowableCharacters='1234567890';}
		if (allow == 'Name'){AllowableCharacters=' ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-.\'';}
		if (allow == 'Date'){AllowableCharacters='-/.1234567890';}
		if (allow == 'Currency'){AllowableCharacters='$.1234567890';}
		
		
		var k = document.all?parseInt(e.keyCode): parseInt(e.which);
		if (k!=13 && k!=8 && k!=0)
		{
			if ((e.ctrlKey==false) && (e.altKey==false))
			{
				return (AllowableCharacters.indexOf(String.fromCharCode(k))!=-1);
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
			
	} 


</script>