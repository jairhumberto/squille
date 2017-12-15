<?php
namespace Admin\Domain;

use Admin\DAO\DB\ContentsDB;

class ContentsDomain {
    public function read() {
        $dao = new ContentsDB;
        $c = $dao->read();
        foreach ($c as $e) {
            list($y, $m, $d, $h, $i, $s) = preg_split('/[: -]/', $e->date);
            $time = mktime($h, $i, $s, $m, $d, $y);
            $e->date = date('d F Y - H:i', $time);
        }
        return $c;
    }

    public function readById($id) {
        $dao = new ContentsDB;
        $e = $dao->readById($id);

        if ($e) {
            // Transforma o formato americano de data no formato aceito pelo componente datetime-local
            list($y, $m, $d, $h, $i, $s) = preg_split('/[: -]/', $e->date);
            $time = mktime($h, $i, $s, $m, $d, $y);
            //$e->date = date('d F Y - H:i', $time); // Antigo formato suportado pelo chrome.
            $e->date = date('Y-m-d\TH:i:s', $time);
        }

        return $e;
    }

    public function deleteById($id) {
        $dao = new ContentsDB;
        $dao->deleteById($id);
    }

    public function save($e) {
        $dao = new ContentsDB;

		if ($e->date) {
			if (\DateTime::createFromFormat('d F Y - H:i', $e->date)) {
				list($d, $m, $y, $h, $i) = preg_split('/(:| - | )/', $e->date);

				$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
				$time = mktime($h, $i, 0, array_flip($months)[$m]+1, $d, $y);
				$e->date = date('Y-m-d H:i:s', $time);
			} elseif(\DateTime::createFromFormat('Y-m-d\TH:i', $e->date)){
				list($y, $m, $d, $h, $i) = preg_split('/[-T:]/', $e->date);
				$time = mktime($h, $i, 0, $m, $d, $y);
				$e->date = date('Y-m-d H:i:s', $time);
			}
		}
		
        if ($e->id) {
            $dao->update($e);
        } else {
            $dao->create($e);
        }
		
        return $e;
    }
}
