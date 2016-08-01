// JavaScript Document
function addConfirm(){
        alert("fff");
    }
    
		function unit_add()
		{
		var n=parseInt(document.getElementById('unit_num').value);
		var s=n+1;
		document.getElementById('unit_num').value=s;

		}
		function unit_remove(min_unit_num)
		{
		var n=parseInt(document.getElementById('unit_num').value);
		var s=n-1;
		if(s>=min_unit_num)
		{
		document.getElementById('unit_num').value=s;

		}
		}
		function month_add(nn, max_months)
		{
		var n=parseInt(document.getElementById('buy_month_num').value);
		var s=n+nn;
		if(s<=max_months)
		{
		document.getElementById('buy_month_num').value=s;

		}
		}
		function month_remove(nn,min_months)
		{
		var n=parseInt(document.getElementById('buy_month_num').value);
		var s=n-nn;
		if(s>=min_months)
		{

		document.getElementById('buy_month_num').value=s;


		}

		} 