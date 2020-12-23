<?php // src/Controller/TestController.php
declare(strict_types=1);

namespace App\Controller;

class TestController extends AppController {
  
	public function simple() {
    $ss = $this->getRequest()->getSession(); //an alias only
    $cc = 'test_simple_csrf'; //session var unique to this controller + view
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