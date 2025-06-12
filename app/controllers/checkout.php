<?php

use Core\Render;
use Auth\Session;
use Auth\User;
use Core\Validator;

class Checkout extends Render
{
    public function index()
    {;
        $errors = [];
        $session = new Session();
        if (!$session->isLoggedIn()) {
            redirect('login');
        }
        $user_id = $session->user('id');
        $user = new User();
        $users_data = $user->fetch('users', ['id' => $user_id]);
        $country = $user->query('select country from country where id in (select country_id from users where id= :id)', ['id' => $user_id])->fetch(\PDO::FETCH_OBJ);

        $currentStep = $session->get('step') ?? 1;
        if (isset($_POST['next_step'])) {
            if ($_POST['next_step'] == '1') {
                $validator = new Validator($_POST);
                $validator->setRules([
                    'address' => ['Address', ['required']],
                    'city' => ['City', ['required']],
                    'state' => ['State', ['required']],
                    'zip' => ['Zip Code', ['required']],
                ]);
                if ($validator->has_error()) {
                    $errors = $validator->errors;
                } else {
                    $session->set('address', $_POST['address']);
                    $session->set('city', $_POST['city']);
                    $session->set('state', $_POST['state']);
                    $session->set('zip', $_POST['zip']);
                    $session->set('country', $country->country);
                    $session->set('users_data', $users_data);
                    $session->set('step', 2);
                    redirect('checkout');
                }
            }
            if ($_POST['next_step'] == '2') {
                $session->set('dispatch_method', $_POST['dispatch_method']);
                $session->set('step', 3);
                if (isset($_POST['prev_step'])) {
                    $session->set('step', $currentStep - 1);
                    $currentStep = $session->get('step');
                    redirect('checkout');
                }
                redirect('checkout');
            }
            if ($_POST['next_step'] == '3') {
                $session->set('payment_method', $_POST['payment_method']);
                if (isset($_POST['prev_step'])) {
                    $session->set('step', $currentStep - 1);
                    $currentStep = $session->get('step');
                    redirect('checkout');
                }
                redirect('checkout');
            }
        }

        if (isset($_POST['prev_step'])) {
            $session->set('step', $currentStep - 1);
            $currentStep = $session->get('step');
            redirect('checkout');
        }

        $this->render(path: 'checkout', data: [
            'title' => 'Checkout',
            'errors' => $errors,
            'country' => $country,
            'currentStep' => $currentStep

        ]);
    }
}
