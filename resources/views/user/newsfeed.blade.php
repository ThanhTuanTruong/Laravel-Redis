@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">News Feed</div>
				<div class="panel-body">
						@if ( isset($message) && $message != '' )
							<div class="newsfeed post">
								<span class="text">{{ $message }}</span>
								<span class="info"><a href="/{{ $user_id }}/feed">Go to Newsfeed</a></span>
							</div>
						@endif
						
						@if ( isset($posts) && $posts != '' )
							
							@foreach ( $posts as $post)
								<?php $timedate = gmdate("d-m-Y \@ H:i", $post['time']); // Transform post UNIX time ?>

							<div class="newsfeed post">
								<span class="text">{{ $post['text'] }}</span>
								<span class="info">Posted on {{ $timedate }} by <a href="/{{ $post['user_id'] }}/feed">{{ ucfirst($post['username']) }}</a></span>
							</div>
							@endforeach

						@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
