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
	function updateData(){
	
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
		     	
		    }
	  });

	}
</script>
@endsection