<?php 

namespace App\ThirdParty;

use App\Models\BazzetingModel;
 
class Access
{
    public function islogin(string $uname, $pass)
    {
        $session = session();
        $model = model(BazzetingModel::class);
        $result = $model->getUser($uname);

        if($result){
            $md5pass = md5($pass);
            if($md5pass == $result->mzpwd)
            {
                $ses_data = [
                    'uid'       => $result->user_id,
                    'username'  => $uname,
                    'name'      => $result->name,
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return true;
            }else{
                $session->setFlashdata('msg', "Password Salah");
            }
        }else{
            $session->setFlashdata('msg', "Login Tidak Valid");
        }

        return false;
    }
}