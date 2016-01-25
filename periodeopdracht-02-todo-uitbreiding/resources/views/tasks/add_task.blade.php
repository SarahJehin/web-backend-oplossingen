@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

       <div class="container">
           
           <!-- New Task Form -->
            <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                <!-- Task Name -->
                <div class="form-group">
                    <div>
                        <label for="task-name" class="">Wat moet er gedaan worden?</label>
                    </div>
                    
                    <div class="">
                        <input type="text" name="name" id="task-name" class="form-control">
                    </div>
                </div>

                <!-- Add Task Button -->
                <div class="form-group">
                    <div class="">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-plus"></i> Toevoegen
                        </button>
                    </div>
                </div>
            </form>
           
       </div>
        
    </div>
    
    
@endsection