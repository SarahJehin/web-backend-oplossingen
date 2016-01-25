<?php

namespace App\Http\Controllers;


use App\Task;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;

//om flash sessions aan te kunnen maken
use Session;

class TaskController extends Controller
{
    
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;
    
    
    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }
    
    
    
    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }
    
    
    public function new_task(Request $request)
    {
        return view('tasks.add_task');
    }
    
    
    /**
     * Create a new task.
     *
     * @param  Request  $request
     * het veld name is verplicht en mag maximum 255 karakters lang zijn
     * redirect moet hier niet meer hard coded staan, zal automatisch gebeuren wanneer validation met de validate-method faalt, errors worden ook automatisch getoond
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        
        
        // Create The Task
        /*$request->user()->tasks()->create([
            'name' => $request->name,
        ]);*/
        
        //ik moet hier de status ook al meegeven en het dus op onderstaande manier doen
        $request->user()->tasks()->create([
            'name' => $request->name,
            'status' => 'not_done',
        ]);
        
        //de net toegevoegde taak in een session steken om op te halen bij het todo overzicht en daar in een flash message te steken
        Session::set("task_inserted", $request->name);
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        return redirect('/tasks');
    }
    
    
    
    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        //Het TaskPolicy is gelinkt app/Providers/AuthServiceProvider.php , dus we moeten hierboven niet use Taskpolicy doen
        //eerste argument is de naam van de functie in TaskPolicy die we willen uitvoeren, tweede argument is de huidige task
        //dit gaan we doen zodat alleen de ingelogde user een taak kan verwijderen
        $this->authorize('destroy', $task); //als dit false teruggeeft krijg je een 403-errorpage, anders zal de code gewoon verder uitgevoerd worden

        // Delete The Task
        $task->delete();
        
        
        //Session::flash('flash_message', 'Todo "'.$task->name.'" verwijderd.');
        Session::set("task_deleted", $task->name);
        
        //redirecten naar het overzicht
        return redirect('/tasks');
        
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Task $task)
    {
        
        //Het TaskPolicy is gelinkt app/Providers/AuthServiceProvider.php , dus we moeten hierboven niet use Taskpolicy doen
        //eerste argument is de naam van de functie in TaskPolicy die we willen uitvoeren, tweede argument is de huidige task
        //dit gaan we doen zodat enkel de ingelogde user zijn taken van status kan veranderen
        $this->authorize('update', $task); //als dit false teruggeeft krijg je een 403-errorpage, anders zal de code gewoon verder uitgevoerd worden
        
        $new_status = $this->change_status($task->status);
        
        $task->status = $new_status;

        $task->save();
        
        //redirecten naar het overzicht
        return redirect('/tasks');
        
    }
    
    
    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     *//* niet meer nodig ???
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }*/
    
    
    //deze functie gaat de status van een taak omzetten, indien deze "not_done" is wordt hij "done" en indien hij "done" is wordt hij "not_done"
    function change_status($current_status) {
        $new_status = "";
        if($current_status == "not_done") {
            $new_status = "done";
        }
        else if($current_status == "done") {
            $new_status = "not_done";
        }
        else {
            $new_status = "done";
        }
        
        return $new_status;
    }
    
    
    
}




