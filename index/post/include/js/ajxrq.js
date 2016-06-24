
function ajxrequest()
{
	try // non IE
	{
		//yes
		var request = new XMLHttpRequest();
	}
	catch(e1)
	{
		try // ie 6
		{
			//yes
			request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e2)
		{
			try //ie 5
			{
				request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e3) //no ajax support
			{
				request = false;
			}
		}
	}	
	return request;
};


