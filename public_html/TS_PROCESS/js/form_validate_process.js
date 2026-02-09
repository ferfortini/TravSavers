function validate_required(field,alerttxt)
{
with (field)
{
if (value==null||value=="")
  {alert(alerttxt);return false}
else {return true}
}
}

function validate_numlength(field,alerttxt)
{
with (field)
{
if (value.length > 16 || value.length <15 )
  {alert(alerttxt);return false}
else {return true}
}
}



function validate_email(field,alerttxt)
{
with (field)
{
apos=value.indexOf("@")
dotpos=value.lastIndexOf(".")
if (apos < 1 || dotpos-apos < 2) 
  {alert(alerttxt);return false}
else {return true}
}
}



function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function validate_num1length(field,alerttxt)
{
with (field)
{
if (value.length > 3 || value.length < 3 )
  {alert(alerttxt);return false}
else {return true}
}
}


function validate_num2length(field,alerttxt)
{
with (field)
{
if (value.length > 4 || value.length < 4 )
  {alert(alerttxt);return false}
else {return true}
}
}

function validate_form(thisform)
{
with (thisform)
{

if (validate_required(month,"Callback Date/Time must be filled out!")==false)
  {month.focus();return false}
if (validate_required(day,"Callback Date/Time must be filled out!")==false)
  {month.focus();return false}
if (validate_required(year,"Callback Date/Time must be filled out!")==false)
  {month.focus();return false}
if (validate_required(hour,"Callback Date/Time must be filled out!")==false)
  {month.focus();return false}
if (validate_required(minute,"Callback Date/Time must be filled out!")==false)
  {month.focus();return false}
if (validate_required(ampm,"Callback Date/Time must be filled out!")==false)
  {month.focus();return false}
if (validate_required(CallBackNotes,"Please enter notes for this callback!")==false)
  {CallBackNotes.focus();return false}


if (validate_required(FirstName,"'First Name' must be filled out!")==false)
  {FirstName.focus();return false}

if (validate_required(LastName,"'Last Name' must be filled out!")==false)
  {LastName.focus();return false}

if (validate_required(phoneareacode,"'Phone Number' must be filled out!")==false)
  {phoneareacode.focus();return false}

if (validate_required(phoneexchange,"'Phone Number' must be filled out!")==false)
  {phoneexchange.focus();return false}

if (validate_required(phonenumber,"'Phone Number' must be filled out!")==false)
  {phonenumber.focus();return false}

if (isNumeric(phoneareacode,"'Phone Number' must be numeric!")==false)
  {phoneareacode.focus();return false}

if (isNumeric(phoneexchange,"'Phone Number' must be numeric!")==false)
  {phoneexhange.focus();return false}

if (isNumeric(phonenumber,"'Phone Number' must be numeric!")==false)
  {phonenumber.focus();return false}

if (validate_num1length(phoneareacode,"'Phone Number' must have the proper number of digits!")==false)
  {phoneareacode.focus();return false}


if (validate_num1length(phoneexchange,"'Phone Number' must have the proper number of digits!")==false)
  {phoneexchange.focus();return false}


if (validate_num2length(phonenumber,"'Phone Number' must have the proper number of digits!")==false)
  {phonenumber.focus();return false}

if (validate_required(Email,"'Email Address' must be filled out!")==false)
  {Email.focus();return false}

if (validate_email(Email,"Not a valid e-mail address!")==false)
  {Email.focus();return false}

if (validate_required(Address1,"'Address1' must be filled out!")==false)
  {Address1.focus();return false}

if (validate_required(City,"'City' must be filled out!")==false)
  {City.focus();return false}

if (validate_required(State,"'State' must be filled out!")==false)
  {State.focus();return false}



if (validate_required(MaritalStatus,"'Marital Status' must be filled out!")==false)
  {MaritalStatus.focus();return false}

if (validate_required(Identification,"'Identification' must be filled out!")==false)
  {Identification.focus();return false}

if (validate_required(Income,"'Income' must be filled out!")==false)
  {Income.focus();return false}



if (validate_required(NumAdults,"'# of Adults' must be filled out!")==false)
  {NumAdults.focus();return false}


if (validate_required(NumChildren,"'# of Children' must be filled out!")==false)
  {NumChildren.focus();return false}


if (validate_required(PackageDetails,"'Package Details' must be filled out!")==false)
  {PackageDetails.focus();return false}


if (validate_required(PackageLocation,"'Package Location' must be filled out!")==false)
  {PackageLocation.focus();return false}


if (validate_required(PackageRequestedProperty,"'Requested Property' must be filled out!")==false)
  {PackageRequestedProperty.focus();return false}


if (validate_required(ArrivalDate,"'Requested Check-In Date' must be filled out!")==false)
  {ArrivalDate.focus();return false}


if (validate_required(PackagePrice,"'Package Price' must be filled out!")==false)
  {PackagePrice.focus();return false}


if (validate_required(PrintY,"Are you sure you printed before submitting?")==false)
  {PrintY.focus();return false}



}
}
