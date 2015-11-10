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
									Id
								</th>
								<th  class="col-md-1">
									Customer Name

								</th>
								<th  class="col-md-1">
									Date Purchase
								</th>
								<th  class="col-md-1">
									Amount Due
								</th >
								<th  class="col-md-1">
									Discount
								</th>
								<th  class="col-md-1">
									GST
								</th>
								<th  class="col-md-1">
									Total Price Before Discount
								</th>
								<th  class="col-md-1">
									Created At
								</th>
								<th  class="col-md-1">
									Last Modified Date
								</th>

							</tr>
							
						</thead>
						<tbody>
							
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-12">
							<ul class="pagination" id="pagination">
							<li><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							  
							  
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
		    		"start": start
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

	jQuery(document).ready(function() {
	    generateTable(0);
	   
	});

</script>
@endsection