@extends('layouts.pdf')
@section('content')


<table border="1" style="border:solid 1px #000">
    <tr style="background:#ccc">
	<th>Stream</th>
	<?php 
	$columns = $Results["lines"][0]["rows"];
	$streams = $Results["lines"];
	?>

	<?php for($x=0;$x<count($columns);$x++):?>

	<th><?php echo $columns[$x]["subject"]?></th>
	<?php endfor; ?>
</tr>

<?php for($y=0;$y<count($streams);$y++):?>
<tr>
	<th>{{$GradeName}} <?php echo $streams[$y]["stream_name"]?></th>
		<?php for($x=0;$x<count($columns);$x++):?>

	<th><?php echo $columns[$x]["score"]?></th>
	<?php endfor; ?>

</tr>

<?php endfor;?>




<tr>
	<th>Average</th>
	<?php for($x=0;$x<count($columns);$x++):?>

	<th><?php echo $columns[$x]["average_score"]?></th>
	<?php endfor; ?>
</tr>




</table>




@endsection