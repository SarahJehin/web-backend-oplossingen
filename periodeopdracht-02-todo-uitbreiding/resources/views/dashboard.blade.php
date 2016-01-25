@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
                    <h1>Dashboard</h1>
                </div>

				<div class="panel-body">
					<p>Dit is de applicatie die je moet maken: <a href="{{ url('/tasks') }}">Todo-applicatie</a></p>
				</div>

				
			</div>
		</div>
	</div>
@endsection