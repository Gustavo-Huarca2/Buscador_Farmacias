<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id=null)
    {
        $product = $this->Products->newEmptyEntity();
        $this->Authorization->authorize($product);

        $this->paginate = [
            'contain' => ['Pharmacies'],
        ];
        $products = $this->paginate($this->Products);

        $role=$this->request->getSession()->read('Auth.rol_id');
        if($role!=1){
            $idU=$this->request->getSession()->read('Auth.id');
            
            $pharma = TableRegistry::getTableLocator()->get('Pharmacies');
            $phar=$pharma->find()->where(['id'=>$id])->first();
            if($phar['user_id']==$idU){
                $myproductsPharmacy = $this->paginate($this->Products->find()->where(['pharmacy_id' => $id]));
                $products=$myproductsPharmacy;
            }else{
                $myproductsPharmacy = $this->paginate($this->Products->find()->where(['pharmacy_id' => '-1']));
                $products=$myproductsPharmacy;
            }
            Cache::write('id', $id);
        }

        $this->set(compact('products','id'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Pharmacies'],
        ]);

        $this->set(compact('product'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id=null)
    {
        $product = $this->Products->newEmptyEntity();
		$this->paginate = [
            'contain' => ['Pharmacies'],
        ];
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
				
                $role=$this->request->getSession()->read('Auth.rol_id');
                if($role!=1){
            
                    $temp=Cache::read('id');
                    return $this->redirect(['action' => 'index', $temp]);
                }
                return $this->redirect(['action' => 'index', null]);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $pharmacies = $this->Products->Pharmacies->find('list', ['limit' => 200])->where(['Pharmacies.id'=>$id]);
        $this->set(compact('product', 'pharmacies'));    
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                $role=$this->request->getSession()->read('Auth.rol_id');
                if($role!=1){
                    
                    $temp=Cache::read('id');
                    return $this->redirect(['action' => 'index', $temp]);
                }
                        return $this->redirect(['action' => 'index', null]);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $pharmacies = $this->Products->Pharmacies->find('list', ['limit' => 200]);
        $this->set(compact('product', 'pharmacies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        $role=$this->request->getSession()->read('Auth.rol_id');
        if($role!=1){
            
            $temp=Cache::read('id');     
            return $this->redirect(['action' => 'index', $temp]);
        }
                return $this->redirect(['action' => 'index', null]);
    }
}
