<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\Model_user_menu;
use App\Models\Model_user_access_menu;

class HakAkses implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $user_menu = new Model_user_menu();
        $user_access_menu = new Model_user_access_menu();
        $db = \Config\Database::connect();

        $role = $session->get('role_id');
		if (!$role){
            return redirect()->to(base_url('/'));
        }
        
        $uri = $request->uri;
        $menu = $uri->getSegment(1);

        $queryMenu= $user_menu->select('id_menu')
                    ->asArray()
                    ->where('menu', $menu)
                    ->first();
        $menu_id = $queryMenu['id_menu'];

        
        $userAccess=$user_access_menu->select('role_id, menu_id')
                    ->where(['role_id' => $role, 'menu_id' => $menu_id])
                    ->countAllResults();
                    
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}