<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $user = $this->Users->newEmptyEntity();
        $this->Authorization->authorize($user);

        $this->paginate = [
            'contain' => ['Roles'],
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $user = $this->Users->newEmptyEntity();
        $this->Authorization->authorize($user);

        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Comments', 'Pharmacies'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        $this->Authorization->authorize($user);
        

        if ($this->request->is('post')) {
			$user->set(['id'=>octdec(uniqid())]);
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $user = $this->Users->newEmptyEntity();
        $this->Authorization->authorize($user);
        $user = $this->Users->get($id, [
            'contain' => [],
        ]); 

        $this->Authorization->authorize($user);


        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));


                $role=$this->request->getSession()->read('Auth.rol_id');
                if($role!=1){
                    return $this->redirect(['controller'=>'Search', 'action' => 'index']);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $this->Authorization->authorize($user);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $this->Authorization->skipAuthorization();

        $ses= $this->request->getSession()->check('Auth.id');
        if($ses){
            $redirect = [
                'controller' => 'Search',
                'action' => 'index',    
            ];
            return $this->redirect($redirect);
        }


        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            // redirect to /articles after login success

            $data=$this->request->getData();
            $email=$data['email'];
            $userDB = $this->Users->find()->where(['email' => $email])->first();
            $rol_id=$userDB['rol_id'];
            if($rol_id==3 || $rol_id==2){
                $redirect = $this->request->getQuery('redirect', [
                    'controller' => 'Search',
                    'action' => 'index',
                ]);
            }else{
				$user_id=$userDB['id'];
                $redirect = $this->request->getQuery('redirect', [
				'controller' => 'Users','action' => 'view', $user_id,
				]);
            }
            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }


    public function logout()
    {
        $this->Authorization->skipAuthorization();

        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }




    public function register()
    {
        $this->Authorization->skipAuthorization();

        $ses= $this->request->getSession()->check('Auth.id');
        if($ses){
            $redirect = [
                'controller' => 'Search',
                'action' => 'index',    
            ];
            return $this->redirect($redirect);
        }

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
			$user->set(['id'=>octdec(uniqid())]);
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->rol_id=2;

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $this->set(compact('user'));
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login']);

    }
}
