@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
				Blog 
					<span style="float:right;">

					<?php 
					// Display tags 
					if ( isset ($tags) ) : 
						foreach ( $tags as $tag )
						{
							echo "&bull; <a href='/filter/{$tag}'>" . $tag . "</a> ";
						}
					endif;

					?>
					</span>
				</div>

				<div class="panel-body">

				<?php
					// List posts
					foreach($posts as $post)
					{
						echo "<a href='/article/{$post->id}'>" . $post->title . " - (by " . $post->author . ")" . "</a><br>";
						echo substr($post->content, 0, 90) . "<br>";
						echo "<br>";
						echo "<br>";
					}
				?>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
