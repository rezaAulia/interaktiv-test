@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 ">
			<div class="panel panel-default">
				<div class="panel-heading">Grid View</div>

				<div class="panel-body">	
					<div class="row">
						<div class="col-md-5">
							<button onClick="updateData()"class="btn btn-primary">Update Data from CSV and Json</button>
						</div>
						<div class="col-md-7">
							
							<h3 id="loading"></h3>
						</div>
					</div>
					<table id="thisIsTable" class="table">
						<thead>
							<tr>
								<th class="col-md-1">
									No
								</th>
								<th  class="col-md-2">
									<a href="#" onClick="setSort('id')">Id</a>
								</th>
								<th  class="col-md-1">
									<a href="#" onClick="setSort('CustomerName')">Customer Name</a>

								</th>
								<th  class="col-md-1">
									<a href="#" onClick="setSort('DatePurchase')">Date Purchase</a>
								</th>
								<th  class="col-md-1">
									<a href="#" onClick="setSort('AmountDue')">Amount Due</a>
								</th >
								<th  class="col-md-1">
									<a href="#" onClick="setSort('Discount')">Discount</a>
								</th>
								<th  class="col-md-1">
									<a href="#" onClick="setSort('GST')">GST</a>
								</th>
								<th  class="col-md-1">
									<a href="#" onClick="setSort('TotalPriceBeforeDisc')">Total Price Before Discount</a>
								</th>
								<th  class="col-md-1">
									<a href="#" onClick="setSort('created_at')">Created Date</a>
								</th>
								<th  class="col-md-1">
									<a href="#" onClick="setSort('updated_at')">Last Modified Date</a>
								</th>

							</tr>
							<tr>
								<th></th>
								<th><input type="text"  class="form-control" id="filterId"></th>
								<th><input type="text"  class="form-control" id="filterName"></th>
								<th><input type="text"  class="form-control" id="filterDate"></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-12">
							<ul class="pagination" id="pagination">
							
							  
							  
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section("javascript")
<script>
globalStart = 0;
globalSortName = 'id';
globalSortDir = 'ASC';

	function updateData(){
		$("#loading").html("Please Wait.......");
		postUrl = "{{URL::To('updateData')}}";
	  $.ajax({
		    type: "post",
		    url: postUrl,
		    data: {"_token": "{{ csrf_token() }}"},
		    datatype: "html",
		    success: function(result){
		     	if(result == 1){
		     		alert("Success");

		     	}else{
		     		alert("Already Added");
		     	}
		     	$("#loading").html("");
		    }
	  });

	}

	function getPaginateTable(){
		postUrl = "{{URL::To('getPaginateTable')}}";
	  $.ajax({
		    type: "post",
		    url: postUrl,
		    data: {	"_token": "{{ csrf_token() }}",
		    		"id": $("#filterId").val(),
		    		"date": $("#filterDate").val(),
		    		"name": $("#filterName").val()
		    		},
		    datatype: "html",
		    success: function(result){
		    	$("#pagination").empty();
		     	for(i=0;i<result;i++){
		     		startRecord = i*30;
		     		pageNumber = i+1;
		     		$("#pagination").append('<li><a href="#" onClick="generateTable('+startRecord+')">'+pageNumber+'</a></li>');
		     	}
		     
		    }
	  });
	}

	function generateTable(start){
		postUrl = "{{URL::To('generateTable')}}";
	  $.ajax({
		    type: "post",
		    url: postUrl,
		    data: {"_token": "{{ csrf_token() }}",
		    		"start": start,
		    		"id": $("#filterId").val(),
		    		"date": $("#filterDate").val(),
		    		"name": $("#filterName").val(),
		    		"sort": globalSortName,
		    		"direction": globalSortDir
		    	},

		    datatype: "html",
		    success: function(result){
		    	globalStart = start;
		    	start = start+1;

		    	$("#thisIsTable tbody").empty();
		    	for(x in result){
		    	
		    		$("#thisIsTable tbody").append("<tr><td>"+start+"</td><td>"+result[x].id+"</td><td>"+result[x].CustomerName+"</td><td>"+result[x].DatePurchase+"</td><td>"+result[x].AmountDue+"</td><td>"+result[x].Discount+"</td><td>"+result[x].GST+"</td><td>"+result[x].TotalPriceBeforeDisc+"</td><td>"+result[x].created_at+"</td><td>"+result[x].updated_at+"</td></tr>");
		    		start++;
		    	}
		     	 getPaginateTable();
		     
		    }

	  });
	}

	function setSort(sortName){
		if(globalSortName == sortName){
			if(globalSortDir == "DESC"){
				globalSortDir = "ASC";
			}else{
				globalSortDir = "DESC";
			}
			
		}else{
			globalSortDir = "ASC";
		}
		globalSortName = sortName;
		generateTable(globalStart);
		
	}

	jQuery(document).ready(function() {
		$( "#filterId" ).keyup(function() {
		  generateTable(globalStart);
		});
	   $( "#filterName" ).keyup(function() {
		  generateTable(globalStart);
		});
	   $( "#filterDate" ).keyup(function() {
		  generateTable(globalStart);
		});
	    generateTable(0);
	   
	});

</script>
@endsection