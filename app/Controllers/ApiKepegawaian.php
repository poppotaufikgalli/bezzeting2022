<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BazzetingModel;

class ApiKepegawaian extends BaseController
{
    use ResponseTrait;
    
    public function index()
    {
        echo 'bad request';
    }

    public function lspegawai($nip)
    {
        $model = model(BazzetingModel::class);
        if($nip != '' && strlen($nip) == 18){
            $result = $model->getPNS($nip);
            if($result){
                $ns = [
                    'status'    => 200,
                    'data'      => $result,
                ];
                return $this->respond($ns);
            }else{
                return $this->failNotFound('No Data Found ');
            }
        }else{
            return $this->failNotFound('No Data Found');
        }
        
    }

    public function lsunker($kdkomp)
    {
        $model = model(BazzetingModel::class);
        if($kdkomp != '' && strlen($kdkomp) == 4){
            $result = $model->getOPD($kdkomp);
            if($result){
                $ns = [
                    'status'    => 200,
                    'data'      => $result,
                ];
                return $this->respond($ns);
            }else{
                return $this->failNotFound('No Data Found');
            }
        }else{
            return $this->failNotFound('No Data Found');
        }
        
    }

    public function unker($kunker)
    {
        $model = model(BazzetingModel::class);
        if($kunker != '' && strlen($kunker) == 10){
            $result = $model->getUnker($kunker);
            if($result){
                $ns = [
                    'status'    => 200,
                    'data'      => $result,
                ];
                return $this->respond($ns);
            }else{
                return $this->failNotFound('No Data Found');
            }
        }else{
            return $this->failNotFound('No Data Found');
        }
        
    }
}
