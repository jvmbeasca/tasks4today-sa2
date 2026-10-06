<?php

namespace App\Controllers;

use App\Models\TaskModel;

class TaskManager extends BaseController
{
    public function createForm()
    {
        return view('tasks/create', [
            'title' => 'Add Task',
        ]);
    }

    public function create()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[150]',
            'description' => 'permit_empty|max_length[1000]',
            'task_date' => 'required|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $taskModel = new TaskModel();

        $taskModel->insert([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'task_date'   => $this->request->getPost('task_date'),
            'is_archived' => 0,
        ]);

        return redirect()->to('/tasks')
            ->with('success', 'Task added successfully.');
    }

    public function edit(int $id)
    {
        $taskModel = new TaskModel();
        $task = $taskModel->getTask($id);

        if (! $task) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('tasks/edit', [
            'title' => 'Edit Task',
            'task'  => $task,
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[150]',
            'description' => 'permit_empty|max_length[1000]',
            'task_date' => 'required|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $taskModel = new TaskModel();

        $taskModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'task_date'   => $this->request->getPost('task_date'),
        ]);

        return redirect()->to('/tasks')
            ->with('success', 'Task updated successfully.');
    }

    public function archive(int $id)
    {
        $taskModel = new TaskModel();
        $taskModel->archiveTask($id);

        return redirect()->to('/tasks')
            ->with('success', 'Task archived successfully.');
    }
}