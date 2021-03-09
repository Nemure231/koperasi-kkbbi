<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\Model_user_menu;


class HakAkses implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $model_user_menu = new Model_user_menu();

        $role = $session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $model_user_menu->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}