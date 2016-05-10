<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController{

    public $name = 'Users';
	public function register()
	{
		$this->viewBuilder()->layout('project_layout');
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user)) {
				$this->Flash->success(__('O usuário foi salvo.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Não é possível adicionar o usuário.'));
		}
		$this->set('user', $user);
	}

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		// Permitir aos usuários se registrarem e efetuar logout.
		$this->Auth->allow(['register', 'logout']);
	}

	public function login()
	{
		$this->viewBuilder()->layout('project_layout');
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__('Usuário ou senha ínvalido, tente novamente'));
		}
	}

	public function logout()
	{
		$this->viewBuilder()->layout('project_layout');
		return $this->redirect($this->Auth->logout());
	}

}

 ?>