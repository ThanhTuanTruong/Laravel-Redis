@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">People to follow</div>

				<div class="panel-body">
						@if ( isset($message) && $message != '' )
							{{ $message }}
						@endif
						<a href="/{{ $user_id }}/userlist/">Back to user list</a></span>
					</div>
			</div>
		</div>
	</div>
</div>
@endsection