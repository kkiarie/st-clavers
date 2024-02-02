@extends('layouts.pdf')
@section('content')
<div>


<h3><b>Student Class Summary :: Academic Year {{$year}} :: Total Students :: {{number_format($students)}}</b></h3>

<table border="1">
<tr style="background:#ccc">
	<th><b>Grade Name</b></th>
	<th colspan="{{$StreamsData}}"><b>Streams</b></th>
</tr>


<?php for($x=0;$x<count($Data);$x++):

$DataQuery=$Data[$x]["grade_details"];
$DataQueryResults=$DataQuery["results"]["stream_data"];
?>
	<tr>
		<th><b>{{$DataQuery["grade_name"]}}</b></th>
	

<?php for($y=1;$y<=count($DataQueryResults); $y++):?>
			<th>
				<b>{{$DataQueryResults[$y]["stream_name"]}} {{$DataQueryResults[$y]["stream_total"]}}</b>
			
			</th>	
			<?php endfor;?>  
	</tr>
<?php endfor;?>
</table>


</div>
@endsection