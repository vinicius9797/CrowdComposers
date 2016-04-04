<?php 
namespace App\Controller;

class CodesController extends AppController{

    public function index(){

    }

	public function calc(){
    $a = $this->set('a', $this->request->data['a']);
    $b = $this->set('b', $this->request->data['b']);
    $r = ($this->request->data['b']) * ($this->request->data['a']/100);
    $this->set('r', $r);
	
  }

}





 ?>