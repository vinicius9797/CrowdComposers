<?php 
namespace App\Controller;
define('FACEBOOK_SDK_V4_SRC_DIR','../vendor/facebook/src/Facebook/');
require_once("../vendor/facebook/src/Facebook/autoload.php");

use Facebook;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;



use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;
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
		$conn_string = "host=127.0.0.1 port=5432 dbname= bookmarker user= dev password=dev123";
		$pgConn = pg_connect($conn_string);
		$number = round(microtime(true)) * rand(1, 9);

		$project = $this->Projects->newEntity();	
		if ($this->request->is(['post','put'])) {

			$this->Projects->patchEntity($project, $this->request->data);
			$uploaddir = chdir('tracks') ;
			$temp = explode(".", $_FILES["audiofile"]["name"]);
			$uploadfile = pg_escape_string(basename($_FILES['audiofile']['name']));
			$uploadfile = preg_replace('/\s+/', '', $uploadfile);
			$info = pathinfo($uploadfile);
			$upload_name = basename(strtolower(basename(($uploadfile), '.' .$info['extension'])) .  '.' . end($temp));
			$upload_name = preg_replace('/\s+/', '', $upload_name);
			$uploadtitle = strtolower(pg_escape_string(($this->request->data['title']))) . '.' . end($temp);
			$uploadtitle = preg_replace('/\s+/', '', $uploadtitle);
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
			// echo 'Aqui está mais informações de debug:';
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

	public function callback(){
		$fb = new Facebook\Facebook([
			'app_id' => '851796718287324',
			'app_secret' => 'dcc096a7e1cb9fc2252622948067991c',
			'default_graph_version' => 'v2.5',
		]); 
		// $this->set('fb', $fb);	

		$helper = $fb->getRedirectLoginHelper();

		try {
			$accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			var_dump($helper);
			exit;
		}

		if (! isset($accessToken)) {
			if ($helper->getError()) {
				header('HTTP/1.0 401 Unauthorized');
				echo "Error: " . $helper->getError() . "\n";
				echo "Error Code: " . $helper->getErrorCode() . "\n";
				echo "Error Reason: " . $helper->getErrorReason() . "\n";
				echo "Error Description: " . $helper->getErrorDescription() . "\n";
			} else {
				header('HTTP/1.0 400 Bad Request');
				echo 'Bad request';
			}
			exit;
		}

// Logged in
		echo '<h3>Access Token</h3>';
		var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		echo '<h3>Metadata</h3>';
		var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('851796718287324'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
	try {
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
		exit;
	}

	echo '<h3>Long-lived</h3>';
	var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');

	}

	public function signIn(){
		$this->viewBuilder()->layout('project_layout');

		// $fb = new Facebook\Facebook([
		// 	'app_id' => '851796718287324',
		// 	'app_secret' => 'dcc096a7e1cb9fc2252622948067991c',
		// 	'default_graph_version' => 'v2.5',
		// ]); 

	}

	public function apiTest()
	{
		$this->viewBuilder()->layout('project_layout');
	}
	

}


 ?>