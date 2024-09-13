@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">People to follow</div>

				<div class="panel-body">
						@if ( isset($message) )
							{{ $message }}
						@endif

						
						@if ( isset($users) && $users != '' )
							@foreach ( $users as $user)
								<div class="newsfeed post">
									<span class="text">{{ $user['username'] }} - <a href="/{{ $current_user_id }}/follow/{{ $user['id'] }}">Follow</a></span>
								</div>
							@endforeach
								
						@endif
					</div>
			</div>
		</div>
	</div>
</div>
@endsection
