<?php 

namespace App\Model\Entity;
use Cake\ORM\Entity;

	class Project extends Entity{

		protected $_acessible = [
			'title' => true,
			'audiofile' => true
		];
	}


 ?>