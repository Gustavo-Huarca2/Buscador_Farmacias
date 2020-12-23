<?php // src/Controller/SearchController.php
declare(strict_types=1);
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Query;
//use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
namespace App\Controller;

class SearchController extends AppController {
	public function index()
    {
		$ss = $this->getRequest()->getSession(); //sesion de consulta
		$cc = 'search_simple_csrf';
		if (!$this->request->is(['ajax'])) {
			$csrfToken = bin2hex(random_bytes(24)); //creamos una clave de consulta
			$_serialize = ['csrfToken'];  
			$this->set(compact('csrfToken', '_serialize'));
			$ss->write($cc, $csrfToken);
			$Pharmacias = $this->getTableLocator()->get('pharmacies');
			$queryP = $Pharmacias->find();
			$this->set(compact('queryP'));
		} else {
			$searchProduct="";
			//$this->Session->write('Latitud', '12345');
			$new_csrfToken = $this->request->getQuery('csrfToken');
			$csrfToken = $ss->read($cc);
			//Captura de consulta
			$searchProduct=$this->request->getQuery('edit');
				$Products = $this->getTableLocator()->get('products');
				$queryP = $Products->find()->where(['name LIKE'=>"%{$searchProduct}%"]); 
			//Invocar a la tabla farmacias
			$Pharmacies = $this->getTableLocator()->get('pharmacies');
			$query = $Pharmacies->find()->where(['status' => true]);
			if($searchProduct!=""){
				$query->distinct('Pharmacies.id')
					->matching('Products', function ($q)use ($searchProduct) {//innerJoinWith
					return $q->where(['Products.name LIKE' => "%$searchProduct%"]);
			});
			}else{
				$query->where(['id '=> -1]);
			}
			$result=[10];
			return $this->response
				->withType('application/json')
				->withStringBody(json_encode([
				'pharmacies' => $query,
				'products' => $queryP,
				'result' => $result
			]));
			//$this->set('pharmacy',$this->paginate($query));
			//$this->set('_serialize',['pharmacy']);
			//$this->set(compact(['query']));
		}
    }
	public function distance(){
		if (!$this->request->is(['ajax'])) {
			echo "Error de acceso";
		} else {
			$searchProduct="";
			//$this->Session->write('Latitud', '12345');
			//Captura de consulta
			$searchProduct=$this->request->getQuery('edit');
			$lat=$this->request->getQuery('latitude');
			$lng=$this->request->getQuery('length');
				$Products = $this->getTableLocator()->get('products');
				$queryP = $Products->find()->where(['name LIKE'=>"%{$searchProduct}%"]); 
			//Invocar a la tabla farmacias
			$Pharmacies = $this->getTableLocator()->get('pharmacies');
			$query = $Pharmacies->find();
			if($searchProduct!=""){
				$query->distinct('Pharmacies.id')
					->matching('Products', function ($q)use ($searchProduct) {//innerJoinWith
					return $q->where(['Products.name LIKE' => "%$searchProduct%"]);
			});
			//$query->order(['length' => sqrt(pow('length'-$lng,2)+ pow('latitude'-$lat,2)) ]);
			}else{
				$query->where(['id '=> -1]);
			}
			$result=[10];
			return $this->response
				->withType('application/json')
				->withStringBody(json_encode([
				'pharmacies' => $query,
				'products' => $queryP,
				'result' => $result
			]));
		}
	}
	public function simple() {
		$ss = $this->getRequest()->getSession(); //an alias only
		$cc = 'search_simple_csrf'; //session var unique to this controller + view
		if (!$this->request->is(['ajax'])) { //prepare for first time (note the not!)
			$csrfToken = bin2hex(random_bytes(24)); //create our token
			$_serialize = ['csrfToken'];  
			$this->set(compact('csrfToken', '_serialize'));
			$ss->write($cc, $csrfToken); // could there be race condition / session issues?
		} else { //our ajax reply, check token & process data
			$new_csrfToken = $this->request->getQuery('csrfToken');
			$csrfToken = $ss->read($cc);
			$return = __('Invalid CSRF Token, try refreshing the page');
			if ($csrfToken === $new_csrfToken) //raise exception on else?
				$return = strrev($this->request->getQuery('edit')); //the data we generate
			$result = ['edit' => $return, 'csrfToken' => $csrfToken]; //pass back original token!
			$_serialize = ['result'];
			//If you wanted to be more secure you could pass a new token on 
			// this ajax return and use that for next request.
			//But, if the current token has be acquired then the new one will be too.
			$this->set(compact('result', '_serialize'));
		}
	}
	
}