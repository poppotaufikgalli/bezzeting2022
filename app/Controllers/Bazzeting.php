<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BazzetingModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\ThirdParty\Access;

class Bazzeting extends BaseController
{
    public function printData($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function index()
    {
        $model = model(BazzetingModel::class);
        $data['rekap'] = $model->getRekapBazzeting();
        $data['opd'] = $model->getOPD();
        $this->view('index', $data);
    }

    public function login()
    {
        $this->view('login');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    public function auth()
    {
        $uname = $this->request->getPost('uname');
        $pass = $this->request->getPost('pass');

        $access = new Access();
        $islogin = $access->islogin($uname, $pass);
        if($islogin){
            return redirect()->to('/');
        }else{
            return redirect()->to('/login');
        }
    }

    public function formasi($selkdkomp = null)
    {
        $model = model(BazzetingModel::class);
        $data['opd'] = $model->getOPD();
        if($selkdkomp != null){
            $data['selkdkomp'] = $selkdkomp;

            $data['selRefBazFung'] = $this->getRefBazzetingFungsional($selkdkomp);
            $data['sellspns'] = $this->getButuhAdaFungsional($selkdkomp);
            $data['selopd'] = $model->getOPD($selkdkomp);
            $data['selnunker'] = count($data['selopd']) > 0 ? $data['selopd'][0]->nunker : "";
            $data['lsjabfung'] = $model->getJabfung();
        }
        
        //$this->printData($data);
        $this->view('formasi', $data);
    }

    public function pejabat($kjab=null, $kdkomp=null)
    {
        $model = model(BazzetingModel::class);
        $data['lsjabfung'] = $model->getJabfung();

        $data['selkjab'] = $kjab;

        if($kjab != null){
            if($kdkomp != null){
                $data['lspns'] = $model->getPNSfung($kjab, $kdkomp);
                $data['seljabfung'] = count($data['lspns']) > 0 ? $data['lspns'][0]->njabfung : "";
            }else{
                $data['lspns'] = $model->getPNSfung($kjab);
                $data['seljabfung'] = count($data['lspns']) > 0 ? $data['lspns'][0]->njabfung : "";
            }
        }

        $this->view('pejabat', $data);
    }

    public function laporan($kdkomp=null)
    {
        $model = model(BazzetingModel::class);
        $data['opd'] = $model->getOPD();
        $this->view('laporan', $data);
    }

    public function downloadExcel($kdkomp=null)
    {
        $model = model(BazzetingModel::class);
        $data = $model->getOPD($kdkomp);
        $data1 = $this->getRefBazzetingFungsional($kdkomp);

        //$this->printData($data1);

        $spreadsheet = new Spreadsheet();
        // tulis header/nama kolom 
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', '('.$kdkomp.') - BAZZETING '. $data[0]->nunker);
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')
            ->getFont()->setSize(12)->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:D1')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('E')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->mergeCells('A1:E1');

        $spreadsheet->getActiveSheet()
            ->setCellValue('A3', 'STRUKTUR / JABATAN')
            ->setCellValue('E3', 'JUMLAH');

        $spreadsheet->getActiveSheet()->getStyle('A3:E3')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->mergeCells('A3:D3');
        $spreadsheet->getActiveSheet()->getStyle('A3:E3')
            ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $spreadsheet->getActiveSheet()->getStyle('A3:E3')
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
        
        $column = 4;
        $colIdx = ['A','B', 'C', 'D'];
        $maxLevel = 0;
        $jmlfung = 0;
        // tulis data mobil ke cell
        foreach($data as $key => $value) {
            $col = $value->levelunker -1;
            $kunker = $value->kunker;
            $spreadsheet->getActiveSheet()
                ->setCellValue($colIdx[$col] . $column, $value->nunker)
                ->setCellValue('E' . $column, "");
            $column++;
            if($maxLevel < $value->levelunker){
                $maxLevel = $value->levelunker;
            }
            if(isset($data1[$kunker]) && count($data1[$kunker])> 0){
                $dt = $data1[$kunker];
                foreach ($dt as $key1 => $value1) {
                    $spreadsheet->getActiveSheet()
                        ->setCellValue($colIdx[($col +1)] . $column, $value1->jabfung)
                        ->setCellValue('E' . $column, $value1->jml)
                        ->getStyle($colIdx[($col +1)] . $column)
                            ->getFont()->setItalic(true);
                    $spreadsheet->getActiveSheet()->getStyle($colIdx[($col +1)] . $column.':D'.$column)
                            ->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFD3D3D3');
                    $jmlfung = $jmlfung + $value1->jml;
                    $column++;
                }
            }
        }

        $spreadsheet->getActiveSheet()
                ->setCellValue('A'. $column, "TOTAL")
                ->setCellValue('E' . $column, $jmlfung);
        $spreadsheet->getActiveSheet()->mergeCells('A'.$column.':D'.$column);
        $spreadsheet->getActiveSheet()->getStyle('A'.$column.':D'.$column)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A'.$column.':E'.$column)
                ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
        $spreadsheet->getActiveSheet()->getStyle('A'.$column.':E'.$column)
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension($colIdx[($maxLevel -1)])->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Bazzeting - '. $kdkomp;

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function view($page = 'content', $data=[])
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        $data['sidebar'] = $this->sidebar();
        $data['topbar'] = $this->topbar();
        $data['copyright'] = $this->copyright();

        $data['title'] = ucfirst($page); // Capitalize the first letter

        echo view('templates/header', $data);
        echo view('pages/' . $page, $data);
        echo view('templates/footer', $data);
    }

    public function sidebar()
    {
        return view('templates/sidebar');
    }

    public function topbar()
    {
        return view('templates/topbar');
    }

    public function copyright()
    {
        return view('templates/copyright');
    }

    public function getRefBazzetingFungsional($kdkomp=null)
    {
        $model = model(BazzetingModel::class);
        $data = $model->getRefBazzetingFungsional($kdkomp);

        //$data = json_decode(json_encode($data), true);

        $dtfung = [];
        foreach ($data as $key => $value) {
            $kunker = $value->kunker;
            $dtfung[$kunker][] = $value;
        }

        //$this->printData($dtfung);
        return $dtfung;
    }

    public function getButuhAdaFungsional($kdkomp=null)
    {
        $model = model(BazzetingModel::class);
        $dtfung = [];
        $dt = [];
        $lsjab = [];

        $data1 = $model->getRefBazzetingFungsional($kdkomp);
        //$this->printData($data);
        foreach ($data1 as $key => $value) {
            $kjabfung = $value->kjabfung;
            $dt[$kjabfung]['kjab'] = $kjabfung;
            $dt[$kjabfung]['njab'] = $value->jabfung;
            $dt[$kjabfung]['jml'] = $value->jml;
        }

        

        $data = $model->getJabfung($kdkomp);
        foreach ($data as $key => $value) {
            $kjab = $value->kjab;
            $lsjab[] = $kjab;
            //$dtfung[$kjab]['kjab'] = $value->kjab;
            //$dtfung[$kjab]['njab'] = $value->njab;
            //$dtfung[$kjab]['formasi'] = $value->jml;
            $dtfung[] = [
                'kjab' => $kjab,
                'njab' => $value->njab,
                'ada' => $value->jml,
                'butuh' => isset($dt[$kjab]) ? $dt[$kjab]['jml'] : 0,
            ];
        }

        foreach ($data1 as $key => $value) {
            $kjabfung = $value->kjabfung;
            if(!in_array($kjabfung, $lsjab)){
                $dtfung[] = [
                    'kjab' => $kjabfung,
                    'njab' => $value->jabfung,
                    'ada' => 0,
                    'butuh' => $value->jml,
                ];
            }
        }
        //$this->printData($lsjab);
        return $dtfung;
    }

    public function sfungsional()
    {
        $data['kunker'] = $this->request->getPost('idx_opd');
        $data['kkomp'] = substr($data['kunker'], 0,4);
        $data['kjabfung'] = $this->request->getPost('kjabfung');
        $data['jabfung'] = $this->request->getPost('jabfung');
        $data['jml'] = $this->request->getPost('jml');

        //$this->printData($data);

        $model = model(BazzetingModel::class);

        $stts = $model->simpanData('ref_bazzeting', $data);
        return redirect()->back();
        //$this->printData($stts);
    }

    public function hfungsional($kunker, $kjabfung)
    {
        //$data['kunker'] = $kunker;
        //$data['kjabfung'] = $kjabfung;
        $data = [ 'kunker' => $kunker, 'kjabfung' => $kjabfung];
        $model = model(BazzetingModel::class);        
        $stts = $model->hapusData('ref_bazzeting', $data);

        return redirect()->back();
    }
}
