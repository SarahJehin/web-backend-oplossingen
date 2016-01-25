<?php

//session_start();

$empty_done_list = false;
$empty_not_done_list = false;

$not_done = array();
$done = array();

if (count($tasks) > 0) {
    foreach($tasks as $task) {
        if($task->status == "not_done") {
            array_push($not_done, $task);
        }
        else {
            array_push($done, $task);
        }
    }
}

/*foreach($not_done as $todo) {
    echo($todo->name." ".$todo->id);
}*/

if(count($done) == 0 && count($not_done) > 0) {
    $empty_done_list = true;
}
if(count($not_done) == 0 && count($done) > 0) {
    $empty_not_done_list = true;
}

if(Session::has("count_done") && Session::has("count_not_done")) {
    if(count($done) > Session::get("count_done") && count($not_done) < Session::get("count_not_done")) {
        Session::flash('flash_message', 'Alright! Dat is geschrapt!');
    }
    if(count($done) < Session::get("count_done") && count($not_done) > Session::get("count_not_done")) {
        Session::flash('flash_message', 'Ai ai, nog meer werk...');
    }
}



$previous_page = $_SERVER['HTTP_REFERER'];
preg_match("/[^\/]+$/", $_SERVER['HTTP_REFERER'], $matches);
$last_word = $matches[0];
//add_task --> toegevoegd
if(Session::has("task_inserted") && $last_word == "add_task") {
    Session::flash('flash_message', 'Todo "'.Session::get("task_inserted").'" toegevoegd');
    Session::forget("task_inserted");
}

//tasks --> task deleted
if(Session::has("task_deleted") && $last_word == "tasks") {
    Session::flash('flash_message', 'Todo "'.Session::get("task_deleted").'" verwijderd');
    Session::forget("task_deleted");
}



//we gaan het aantal elementen in beide lijstjes opslagen zodat we kunnen vergelijken als er 1 van status verandert welke vermindert is en welke vermeerdert
Session::set("count_done", count($done));
Session::set("count_not_done", count($not_done));
Session::save();


?>


@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Task Form -->
        <!--
        <form action="{{ url('task') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Task Name --><!--
            <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Task</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="task-name" class="form-control">
                </div>
            </div>

            <!-- Add Task Button --><!--
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Task
                    </button>
                </div>
            </div>
        </form>
    </div>
-->
   
       <div class="container">
           <h1>De TODO-app</h1>
        
        
        @if(count($tasks) == 0)
            <div>Nog geen todo-items. <a href="{{ url('/add_task') }}">Voeg item toe</a>.</div>
            
        @else
           <h3>Wat moet er allemaal gebeuren?</h3>
            <div><a href="{{ url('/add_task') }}">Voeg item toe</a>.</div>
        @endif
        
        

   
    <!-- TODO: Current Tasks -->
    @if (count($tasks) > 0)
       
        <div class="panel panel-default">
            <div class="panel-heading">
                Todo
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Taak</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                       
                       <!-- als er geen items in de todo zitten, maar wel in de done, krijg je een "all done" message -->
                        @if($empty_not_done_list)
                            <tr>
                                <td>&nbsp;</td>
                                <td>Alright! All done!</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endif
                       
                        @foreach ($not_done as $task)
                           
                            <tr>
                                <!-- Change Status Button -->
                                <td class="td_status_btn {{ $task->status }}">
                                    <form action="{{ url('update_task/'.$task->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}

                                        <button class="status_btn {{ $task->status }}">v</button> <!-- hier kan ik achteraf nog een vinkje ofzo inzetten -->
                                    </form>
                                </td>
                                <!-- Task Name -->
                                <td class="table-text">
                                    <div>{{ $task->name }}</div>
                                </td>

                               <!-- Delete button -->
                                <td>
                                    <form action="{{ url('task/'.$task->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button>Verwijder</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        
        
        <div class="panel panel-default">
            <div class="panel-heading">
                Done
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Taak</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                       
                       <!-- als er geen items in de done zitten, maar wel in de todo, krijg je een "werk aan de winkel" message -->
                        @if($empty_done_list)
                            <tr>
                                <td>&nbsp;</td>
                                <td>Damn, werk aan de winkel...</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endif
                       
                        @foreach ($done as $task)
                           
                            <tr>
                               <!-- Change Status Button -->
                                <td class="td_status_btn {{ $task->status }}">
                                    <form action="{{ url('update_task/'.$task->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}

                                        <button class="status_btn {{ $task->status }}">v</button> <!-- hier kan ik achteraf nog een vinkje ofzo inzetten -->
                                    </form>
                                </td>
                                <!-- Task Name -->
                                <td class="table-text line-through">
                                    <div>{{ $task->name }}</div>
                                </td>

                               <!-- Delete button -->
                                <td>
                                    <form action="{{ url('task/'.$task->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button>Verwijder</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        
        
        
    @endif
    </div>
    
@endsection