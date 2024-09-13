@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo $article['title'] . " - (by " . $article['author'] . ")"; ?>
				</div>

				<div class="panel-body">
					<?php
					echo substr($article['content'], 0, 90) . "<br>";
					echo "<br>";
					echo "This article has " . $views . " views";

					if ( ! isset( $tags ) || ! empty( $tags ) )
					{

						echo " and the following tags: ";

						$i = 0;

						foreach ( $tags as $tag )
						{
							// Don't print comma after last tag
							if ( ( count( $tags ) > 1 ) && $i <= ( count( $tags ) - 2 ) )
								$separator = ", ";
							else 
								$separator = "";

							echo $tag . $separator;

							$i++;
						}

					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
