<?php

namespace App\Models;

use CodeIgniter\Model;

class BazzetingModel extends Model
{
    public function getUser($uname){
        $db      = \Config\Database::connect();
        $query = $db->table('tr_user')->getWhere(['user_id' => $uname]);
        return $query->getRow();
    }

    public function getOPD($kdkomp=null)
    {
        $db      = \Config\Database::connect();
        if($kdkomp != null){
            $builder = $db->table('v_refunitkerja');
            $query = $builder->getWhere(['concat(tkpem,kode1)' => $kdkomp]);
        }else{
            $builder = $db->table('v_refkomponen');
            $query = $builder->get(); 
        }
        return $query->getResult();
    }

    public function getUnker($kunker)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('v_refunitkerja');
        $builder->select('*');
        $builder->join('v_refkomponen', 'concat(v_refunitkerja.tkpem,v_refunitkerja.kode1) = v_refkomponen.kkomp');
        $query = $builder->getWhere(['kunker' => $kunker]);
        return $query->getRow();
    }

    public function getJabfung($kdkomp=null, $jenisjab=2)
    {
        $db      = \Config\Database::connect();
        if($kdkomp != null){
            $tb_fung = $jenisjab == 2 ? "ref_jabfung" : "ref_jabnstr";
            $sql = "select a.kjab, b.njab, count(a.nip) as jml from v_peglist2 a join ".$tb_fung." b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where concat(a.kuntp, a.kunkom) = ? and a.kstatus=2 and a.kjpeg = 1 group by a.kjab order by a.kjab";
            $query = $db->query($sql, $kdkomp);
        }else{
            $tb_fung = $jenisjab == 2 ? "ref_jabfung" : "ref_jabnstr";
            $builder = $db->table($tb_fung);
            $query = $builder->get(); 
        }
        return $query->getResult();
    }

    public function getRefBazzetingFungsional($kdkomp=null, $kunker=null)
    {
        $db      = \Config\Database::connect();
        if($kdkomp != null){
            $builder = $db->table('ref_bazzeting');
            if($kunker != null){
                $query = $builder->getWhere(['kkomp' => $kdkomp, 'kunker' => $kunker]);
            }else{
                $query = $builder->getWhere(['kkomp' => $kdkomp]);
            }
        }else{
            $builder = $db->table('ref_bazzeting');
            $query = $builder->get(); 
        }
        return $query->getResult();
    }

    public function getRekapBazzeting()
    {
        $db      = \Config\Database::connect();
        $sql = "select sum(jml) as jmlformasi from ref_bazzeting where jenisjab = 2";
        $query = $db->query($sql);
        $a2 = $query->getRow();

        $sql = "select sum(jml) as jmlformasi from ref_bazzeting where jenisjab = 4";
        $query = $db->query($sql);
        $a4 = $query->getRow();

        $sql = "select count(a.nip) as jmlpns from v_peglist2 a join ref_jabfung b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where a.kstatus=2 and a.kjpeg = 1";
        $query = $db->query($sql);
        $b2 = $query->getRow();

        $sql = "select count(a.nip) as jmlpns from v_peglist2 a join ref_jabnstr b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where a.kstatus=2 and a.kjpeg = 1";
        $query = $db->query($sql);
        $b4 = $query->getRow();

        $sql = "select count(distinct(kkomp)) as progresopd from ref_bazzeting";
        $query = $db->query($sql);
        $c = $query->getRow();

        return ['jmlformasiFT' => $a2->jmlformasi, 'jmlpnsFT' => $b2->jmlpns, 'jmlformasiFU' => $a4->jmlformasi, 'jmlpnsFU' => $b4->jmlpns, 'progresopd' => $c->progresopd];
    }

    public function getPNSfung($kjab=null, $jenisjab=2, $kdkomp = null)
    {
        $db      = \Config\Database::connect();
        if($kjab != null){
            if($kdkomp != null){
                $tb_fung = $jenisjab == 2 ? "ref_jabfung" : "ref_jabnstr";
                $sql = "select a.nip, a.nama, a.namapeg, a.ngolru, b.kjab, a.njab, b.njab as njabfung, a.kunker, c.nunker, a.usiath from v_peglist2 a join ".$tb_fung." b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where a.kjab = ? and a.kstatus=2 and a.kjpeg = 1 and concat(a.kuntp, a.kunkom) = ?  order by a.kgolru";
                $query = $db->query($sql, [$kjab, $kdkomp]);
            }else{
                $tb_fung = $jenisjab == 2 ? "ref_jabfung" : "ref_jabnstr";
                $sql = "select a.nip, a.nama, a.namapeg, a.ngolru, b.kjab, a.njab, b.njab as njabfung, a.kunker, c.nunker, a.usiath from v_peglist2 a join ".$tb_fung." b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where a.kjab = ? and a.kstatus=2 and a.kjpeg = 1 order by a.kgolru";
                $query = $db->query($sql, $kjab);
            }
        }else{
            if($kdkomp != null){
                $tb_fung = $jenisjab == 2 ? "ref_jabfung" : "ref_jabnstr";
                $sql = "select a.nip, a.nama, a.namapeg, a.ngolru, b.kjab, a.njab, b.njab as njabfung, a.kunker, c.nunker, a.usiath from v_peglist2 a join ".$tb_fung." b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where a.kstatus=2 and a.kjpeg = 1 and concat(a.kuntp, a.kunkom) = ?  order by a.kgolru";
                $query = $db->query($sql, $kdkomp);
            }else{
                $tb_fung = $jenisjab == 2 ? "ref_jabfung" : "ref_jabnstr";
                $sql = "select a.nip, a.nama, a.namapeg, a.ngolru, b.kjab, a.njab, b.njab as njabfung, a.kunker, c.nunker, a.usiath from v_peglist2 a join ".$tb_fung." b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where a.kstatus=2 and a.kjpeg = 1 order by a.kgolru";
                $query = $db->query($sql);
            }    
        }
        
        return $query->getResult();
    }

    public function getPNS($nip)
    {
        $db      = \Config\Database::connect();
        $sql = "select a.nip, a.nama, a.namapeg, a.njab, a.lahirpeg, a.kgolru, a.aljalan, a.alrt, a.alrw, a.altelp, a.kgoldar, b.kunker, b.nunker from v_peglist a join v_refunitkerja b on (a.kunker2=b.kunker) where a.nip = ? and a.kstatus in (1,2) and a.kjpeg = 1";
        $query = $db->query($sql, $nip);
        
        return $query->getRow();
    }

    public function simpanData($tbname, $data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('ref_bazzeting');
        return $builder->insert($data);
    }

    public function hapusData($tbname, $data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('ref_bazzeting');
        return $builder->delete($data);
    }
}
