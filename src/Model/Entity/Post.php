<?php 

namespace App\Model\Entity;
use Cake\ORM\Entity;

	class Post extends Entity{

		protected $_acessible = [
			'title' => true,
			'body' => true
		];
	}


 ?>