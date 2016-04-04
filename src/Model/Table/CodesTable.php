<?php 

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CodesTable extends Table {
	public function validationDefault(Validator $validator){
		$validator
		->requirePresence('a', 'b')
		->notEmpty('a', 'b');

		return $validator;
	}
}












?>