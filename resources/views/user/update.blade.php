@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Post an Update</div>

				<div class="panel-body">
					<form action="/<?php echo $userID; ?>/postupdate" method="POST">
				        <p class="form-error">
				       	<?php 
				            if ( isset($errors) && ! empty($errors) ) {
				       			foreach ( $errors->all() as $error )
				       			{
				       				echo "<p class=\"form-error\">";
				       				echo $error;
				       				echo "</p>";
				       			}
				       		}
				       		if ( isset($message) )
				       			echo "<p class=\"form-success\">" . $message . "</p>";

				       	?>
				       	</p>
				       	<div class="form-group">
					        <label for="inputTitle">Udate Status</label>
					        <input type="text" name="update" id="inputUpdate" class="form-control" placeholder="I saw a big bird!" required autofocus>
						</div>
						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				        <button class="btn btn-lg btn-primary btn-block" type="submit">Post!</button>
			      	</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
