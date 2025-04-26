<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\TodoFormType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    // 📝 View all tasks
    #[Route('/todo', name: 'todo_list')]
    // 📝 View all tasks
    #[Route('/todo', name: 'todo_list')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $tasks = $session->get('tasks', []); // Get tasks from the session

        return $this->render('index.html.twig', [
            'tasks' => $tasks // Pass tasks to the template
        ]);
    }


    // ➕ Add new task
    #[Route('/todo/add', name: 'add_todo')]
    public function addTask(Request $request): Response
    {
        $session = $request->getSession();
        $tasks = $session->get('tasks', []);

        $form = $this->createForm(TodoFormType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //get the title from the form
            $title = $form->get('title')->getData();
            if ($title) {
                $id = uniqid();

                // Reset the tasks array if old invalid structure is detected
                if (!is_array($tasks) || (isset($tasks[0]) && !isset($tasks[0]['title']))) {
                    $tasks = [];
                }
                //store the new title and id in the tasks array
                $tasks[] = [
                    'id' => $id,
                    'title' => $title,
                ];
            }
            //update the 
            $session->set('tasks', $tasks);
            return $this->redirectToRoute('todo_list');
        }
        return $this->render('form/todoForm.html.twig', [
            'form' => $form->createView(),
            'tasks' => $tasks,
        ]);
    }
    // ❌ Delete task by ID
    #[Route('/todo/task/delete/{id}', name: 'delete_task')]
    public function deleteTask(Request $request, string $id): Response
    {
        $session = $request->getSession();
        $tasks = $session->get('tasks', []);
       //if no tasks is found
        if (!$tasks) {
            throw new NotFoundHttpException('Tasks do not exist');
        }
 
        $found = false;
       //if tasks are found in the session then 
        foreach ($tasks as $key => $task) {
            if ($task['id'] === $id) {
                unset($tasks[$key]);
                $tasks = array_values($tasks); // reindex array
                $session->set('tasks', $tasks); // Save the updated tasks
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw new NotFoundHttpException("Task with ID $id not found");
        }

        return $this->redirectToRoute('todo_list');
    }


    // 🔄 Clear all session tasks (for development/testing)
    #[Route('/todo/clear', name: 'clear_tasks')]
    public function clearTasks(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('tasks'); // Remove all tasks from session

        return $this->redirectToRoute('todo_list');
    }
}

