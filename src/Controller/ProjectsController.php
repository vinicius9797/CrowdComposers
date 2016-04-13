<?php 
namespace App\Controller;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Core\Configure;
use Cake\Network\Session;

class ProjectsController extends AppController{
	public $name = 'Projects';

	public function index(){
		$this->viewBuilder()->layout('project_layout');
	}

	public function midiplayer(){
		$this->viewBuilder()->layout('midi');
	}

	public function uploads(){
		$this->viewBuilder()->layout('project_layout');
		$this->set('projects', $this->paginate($this->Projects));

	}

	public function files($id = null){
		$this->viewBuilder()->layout('project_layout');
		$project = $this->Projects->get($id);
		$this->set('project', $project);
		if (file_exists($project->id.$project->title)) {
			# code...
		}
	}


	public function add(){
		$this->viewBuilder()->layout('project_layout');
//		$conn_string = "host=127.0.0.1 port=5432 dbname= bookmarker user= dev password=dev123";
//		$pgConn = pg_connect($conn_string);
//		$number = round(microtime(true)) * rand(1, 9);
                $project = $this->Projects->newEntity();
             
		if ($this->request->is(['post','put'])) {

			$this->Projects->patchEntity($project, $this->request->data);
			//Saving user ID and username on database.
			$project->uploader_id = $this->Auth->user('id');
			$project->uploader = $this->Auth->user('username');

                        $uploaddir = chdir('tracks') ;
                        $temp = explode(".", $_FILES["audiofile"]["name"]);
                        $uploadfile_basename = pg_escape_string(basename($_FILES['audiofile']['name']));
                        $uploadfile = preg_replace('/\s+/', '', $uploadfile_basename);
                        $info = pathinfo($uploadfile);
                        $upload_name_basename = basename(strtolower(basename(($uploadfile), '.' .$info['extension'])) .  '.' . end($temp));
                        $upload_name = preg_replace('/\s+/', '', $upload_name_basename);
                        $uploadtitle_basename = strtolower(pg_escape_string(($this->request->data['title']))) . '.' . end($temp);
                        $uploadtitle = preg_replace('/\s+/', '', $uploadtitle_basename);
                        $pathfile = DS . 'var' . DS . 'www' . DS . 'webroot' . DS .'tracks' . DS;
                        //Query Vars
			$uploadNameQuery = $project->id.trim($upload_name);
			$uploadTitleQuery = $project->id.trim($uploadtitle);			
			$idQuery= $project->id;
			


			if ($this->Projects->save($project)) {
				if (is_uploaded_file($_FILES['audiofile']['tmp_name'])) {
					$this->Flash->success('Seu arquivo foi enviado!');
				} else {
					$this->Flash->error('O arquivo não pôde ser enviado, verifique sua conexão.');
				}
				
				 if (empty($this->request->data['title'])) {
					move_uploaded_file(pg_escape_string($_FILES['audiofile']['tmp_name']), $project->id.$upload_name); 
					$projectsTable = TableRegistry::get('Projects');
					$projectQ = $projectsTable->get($project->id);
					$projectQ->pathtofile = $pathfile.$projectQ->id.$uploadNameQuery;
					$projectQ->musicname = strtolower($upload_name);

					$projectsTable->save($projectQ);
					$this->redirect(['action'=>'index']);			
					
				}else{
					move_uploaded_file(pg_escape_string($_FILES['audiofile']['tmp_name']), $project->id.$uploadtitle); 									
					$projectsTable = TableRegistry::get('Projects');
					$projectQ = $projectsTable->get($project->id);
					$projectQ->pathtofile = $pathfile.$projectQ->id.$uploadTitleQuery;
					$projectQ->musicname= $this->request->data['title'];



					$projectsTable->save($projectQ);
					$this->redirect(['action'=>'index']);
				}



			}else{
				$this->Flash->error('Verifique se o arquivo é MP3, WAV ou MIDI e tente novamente.');			
				}
			// echo 'DEBUG:';
			// print_r($_FILES);	
		}

		$this->set(compact('project'));
	}

	public function downloads($id=null){


		$this->viewBuilder()->layout('project_layout');
		$download = $this->Projects->get($id);
		$this->set('download', $download);
		$linkdownload = $download->id . $download->title;	
		$pathfile = WWW_ROOT .'tracks' . $linkdownload;	

			$path = $this->Projects->get($id);
			$this->response->file(WWW_ROOT.'tracks' . DS . $linkdownload, array(
				'download' => true,
				'name' => $download->title,
				));
			return $this->response;
	}

	public function signIn(){
		$this->viewBuilder()->layout('project_layout');


	}

	public function apiTest()
	{
		$this->viewBuilder()->layout('project_layout');
	}
	

} 