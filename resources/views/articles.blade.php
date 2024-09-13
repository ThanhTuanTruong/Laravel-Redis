@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Add an Article</div>

				<div class="panel-body">
					<form action="/admin/addarticle" method="POST">
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
					        <label for="inputTitle">Article Name</label>
					        <input type="text" name="title" id="inputTitle" class="form-control" placeholder="" required autofocus>
						</div>
						<div class="form-group">
					        <label for="inputAuthor">Author Name</label>
					        <input type="text" name="author" id="inputAuthor" class="form-control" placeholder="" required>
					    </div>
						<div class="form-group">
					        <label for="inputAuthor">Tagging</label>
					        <input type="text" name="tagging" id="inputTagging" class="form-control" placeholder="Redis, Laravel, Caching">
					    </div>
						<div class="form-group">
					        <label for="inputContent">Content</label>
					        <textarea name="inputContent" rows="10" class="form-control" placeholder="Article here" required></textarea>
					        <span id="helpBlock" class="help-block">Accepts HTML tags and displays spaces as inputted.</span>
						</div>
						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				        <button class="btn btn-lg btn-primary btn-block" type="submit">Add!</button>
			      	</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
