<?php


namespace Infinitypaul\LaravelUptime\Scheduler;




class Kernel
{
    //The Task
    protected $tasks = [];


    //Add an Event
    public function add(Task $task){
        $this->tasks[] = $task;

        return $task;
    }


    //Run The Schedule Tasked

    public function run(){
        foreach ($this->getTasks() as $task){
            if(!$task->isDueToRun()){
                continue;
            }

            $task->handle();
        }
    }

    //Get Tasks

    protected function getTasks(){
        return $this->tasks;
    }
}
