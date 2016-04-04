<?php 

namespace App\Controller;



class PostsController extends AppController{
	
	public function index(){
		$this->set('posts', $this->paginate($this->Posts));
	}

	public function view($id = null){
		$post = $this->Posts->get($id);
		$this->set('post', $post);
	}

	public function add(){
		$post = $this->Posts->newEntity();
		if ($this->request->is(['post', 'put'])){
			$this->Posts->patchEntity($post, $this->request->data);

			if ($this->Posts->save($post)){
				$this->Flash->success('A new post was created!');
				$this->redirect('/posts');
			}else{
				$this->Flash->error('Error. Please, try again.');
			}
		}
		$this->set(compact('post'));
	}

	public function edit($id = null){
		$post = $this->Posts->get($id);
		if($this->request->is(['post', 'put'])){
			$this->Posts->patchEntity($post, $this->request->data);
			if ($this->Posts->save($post)){
				$this->Flash->success("The post was edited.");
				$this->redirect(['action'=>'index']);
			} else {
				$this->Flash->error("Error, please try again.");
			}
		}

		$this->set(compact('post'));
	}

	public function delete($id = null){
		$this->request->allowMethod(['post', 'delete']);
		$post = $this->Posts->get($id);
		if ($this->Posts->delete($post)) {
			$this->Flash->success('The post was deleted.');
			$this->redirect(['action'=>'index']);
		}else{
			$this->Flash->error('Error, please try again.');
		}
	}









}


 ?>