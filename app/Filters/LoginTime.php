<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginTime implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null){
        $cookie = $request->getCookie('jwt_token');

        if(!$cookie){
            $session->remove('email');
            $session->remove('role_id');
            $session->remove('id_user');
            $session->remove('nama');
            $session->setFlashdata('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
						<strong>Waktu login Anda baru saja habis, silakan login kembali.</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>');
            return redirect()->to(base_url('/'));

        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}