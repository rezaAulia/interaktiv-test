<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sample;
use Carbon\Carbon;
use URL;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('index');
	}

	public function updateData(){
		$sample = Sample::first();
		if(!$sample){
			$this->insert_from_json();
			$this->insert_from_csv();
			return 1;
		}else{
			return 0;
		}
	}

	private function insert_from_csv(){
		$array = array();
		$file = fopen("data/RecruitmentTestData.csv","r");
		while(!feof($file))
		  {
		  	array_push($array,fgetcsv($file));
		  
		  }
		fclose($file);
		//var_dump($array[1]);
		foreach($array as $key => $value){
			if($key != 0){
				if($array[$key][0] != ""){
					$this->insertToTableSample($array[$key]);
				}
				
			}	
		}
	}

	private function insert_from_json(){
		$array = array();
		$path = URL::To("/data/RecruitmentTestData.json");
	    $array = file_get_contents($path);
	    $array = str_replace("'",'"',$array);
	   	$array = json_decode($array,true);

	   	foreach($array as $key => $value){
	   		if($array[$key]['Id'] != ""){
	   			$this->insertToTableSample(array($array[$key]['Id'],
												$array[$key]['CustomerName'],
												$array[$key]['DatePurchase'],
												$array[$key]['Amount_due__c'],
												$array[$key]['Discount__c'],
												$array[$key]['GST__c'],
												$array[$key]['CreatedDate'],
												$array[$key]['LastModifiedDate']));
	   		
				
	   		}
					
		}
	}

	private function formatDatePurchase($string){
		$date = substr($string,0,6);
		$year = substr($date,0,4);
		$month = substr($date,4,2);
		return $year.'-'.$month.'-00';
	}

	private function insertToTableSample($array){
		$sample = new Sample;
		$sample->id = $array['0'];
		$sample->CustomerName = $array['1'];
		$sample->DatePurchase = $this->formatDatePurchase($array['2']);
		$sample->AmountDue = $array['3'];
		$sample->Discount = $array['4'];
		$sample->GST = $array['5'];
		$sample->TotalPriceBeforeDisc = $sample->AmountDue + $sample->Discount - $sample->GST;
		$sample->created_at = $array['6'];
		$sample->updated_at = $array['7'];
		$sample->save();
	}


	public function generateTable(Request $request){
		$sample = Sample::where('id', 'LIKE', '%'.$request->Input('id').'%')
							->where('CustomerName', 'LIKE', '%'.$request->Input('name').'%')
							->where('DatePurchase', 'LIKE', '%'.$request->Input('date').'%')
							->orderBy($request->Input('sort'),$request->Input('direction'))
							->take(30)
							->skip($request->Input("start"))->get();
		return $sample;
	}
	public function getPaginateTable(Request $request){
		$sample = Sample::where('id', 'LIKE', '%'.$request->Input('id').'%')
						->where('CustomerName', 'LIKE', '%'.$request->Input('name').'%')
						->where('DatePurchase', 'LIKE', '%'.$request->Input('date').'%')
						->count();
		$totalPage = ceil($sample/30);
		return $totalPage;
	}

}
