<?php 

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\Network\Response;
use ArrayObject;

class ProjectsTable extends Table{
	public $name = 'Projects';


	public function initialize(array $config){
	$this->addBehavior('Timestamp');
	}

	public function validationDefault(Validator $validator){
		$validator
		->notEmpty('title');

		$validator
		->requirePresence('audiofile')
		->notEmpty('audiofile', 'Por favor, insira um arquivo.')
		->uploadedFile('audiofile', ['types'=>['audio/mpeg', 'audio/x-wav', 'audio/midi', 'audio/ogg']] );
		return $validator;
		// 'audio/mpeg3', 'audio/wav', 'audio/midi', 'audio/mid'
	}

	public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
	{
		$number = round(microtime(true));
		$temp = explode(".", $_FILES["audiofile"]["name"]);
		$uploadfile_basename = basename($_FILES['audiofile']['name']);
		$uploadfile = preg_replace('/\s+/', '', $uploadfile_basename);
		$info = pathinfo($uploadfile);
		$upload_name_basename = basename($uploadfile, '.' .$info['extension']) . '.' . end($temp);
		$upload_name = preg_replace('/\s+/', '', $upload_name_basename);
		$uploadtitle_basename = pg_escape_string($data['title']) . '.' . end($temp);
		$uploadtitle = preg_replace('/\s+/', '', $uploadtitle_basename);
		$data['audionumber'] = $number;
		if (empty($data['title'])) {
			$data['title'] = strtolower($upload_name_basename);
		}else{
			$data['title']=strtolower($uploadtitle_basename);
		}

	}	
}