<?php 

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* 
*/
class PostsTable extends Table{
	
	public function initialize(array $config){
		$this->addBehavior('Timestamp');
		$this->displayField('title');
	}

	public function validationDefault(Validator $validator){
		$validator
		->requirePresence('title', 'create')
		->allowEmpty('title', false, 'Please, insert a title.');

		$validator
		->requirePresence('body', 'create')
		->allowEmpty('body', false, 'Please, insert a text body!');

		return $validator;
	}

}

 ?>