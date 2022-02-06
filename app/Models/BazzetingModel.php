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

    public function getJabfung($kdkomp=null)
    {
        $db      = \Config\Database::connect();
        if($kdkomp != null){
            $sql = "select a.kjab, b.njab, count(a.nip) as jml from v_peglist2 a join ref_jabfung b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where concat(a.kuntp, a.kunkom) = ? and a.kstatus=2 and a.kjpeg = 1 group by a.kjab order by a.kjab";
            $query = $db->query($sql, $kdkomp);
        }else{
            $builder = $db->table('ref_jabfung');
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
        $sql = "select sum(jml) as jmlformasi from ref_bazzeting";
        $query = $db->query($sql);
        $a = $query->getRow();

        $sql = "select count(a.nip) as jmlpns from v_peglist2 a join ref_jabfung b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where a.kstatus=2 and a.kjpeg = 1";
        $query = $db->query($sql);
        $b = $query->getRow();

        $sql = "select count(distinct(kkomp)) as progresopd from ref_bazzeting";
        $query = $db->query($sql);
        $c = $query->getRow();

        return ['jmlformasi' => $a->jmlformasi, 'jmlpns' => $b->jmlpns, 'progresopd' => $c->progresopd];
    }

    public function getPNSfung($kjab, $kdkomp = null)
    {
        $db      = \Config\Database::connect();
        if($kdkomp != null){
            $sql = "select a.namapeg, a.nip, a.ngolru, b.kjab, a.njab, b.njab as njabfung, c.nunker, a.usiath from v_peglist2 a join ref_jabfung b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where a.kjab = ? and a.kstatus=2 and a.kjpeg = 1 and concat(a.kuntp, a.kunkom) = ?  order by a.kgolru";
            $query = $db->query($sql, [$kjab, $kdkomp]);
        }else{
            $sql = "select a.namapeg, a.nip, a.ngolru, b.kjab, a.njab, b.njab as njabfung, c.nunker, a.usiath from v_peglist2 a join ref_jabfung b on (a.kjab = b.kjab) join v_refunitkerja c on (a.kunker1 =c.kunker) where a.kjab = ? and a.kstatus=2 and a.kjpeg = 1 order by a.kgolru";
            $query = $db->query($sql, $kjab);
        }
        
        return $query->getResult();
    }

    public function getPNS($nip)
    {
        $db      = \Config\Database::connect();
        $sql = "select a.* from v_peglist a join v_refunitkerja c on (a.kunker1 =c.kunker) where a.nip = ? and a.kstatus in (1,2) and a.kjpeg = 1";
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
