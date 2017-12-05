<?php
namespace Admin\Domain;

class FilesDomain {
	public function upload() {
		$erros = array();
		$target = sprintf(PUBLIC_DIR . '/assets%s', $_POST['navurl']);
		
		for ($i=0; $i < count($_FILES['arquivo']['tmp_name']); $i++) {
			$cod = $_FILES['arquivo']['error'][$i];
			
			if ($cod == UPLOAD_ERR_INI_SIZE || $cod == UPLOAD_ERR_FORM_SIZE) {
				$erros[] = sprintf('O arquivo "%s" possui tamanho acima do limite', $_FILES['arquivo']['name'][$i]);
			}
			
			if ($cod == UPLOAD_ERR_PARTIAL || $cod == UPLOAD_ERR_NO_FILE || $cod == UPLOAD_ERR_EXTENSION) {
				$erros[] = sprintf('Houve um erro no envio do arquivo "%s"', $_FILES['arquivo']['name'][$i]);
			}
			
			if ($cod == UPLOAD_ERR_NO_TMP_DIR) {
				throw new DataException('Diretório temporário não encontrado');
			}
			
			if ($cod == UPLOAD_ERR_CANT_WRITE) {
				throw new DataException('Diretório temporário sem permissão de escrita');
			}

			if (is_uploaded_file($_FILES['arquivo']['tmp_name'][$i])) {
				if (!move_uploaded_file($_FILES['arquivo']['tmp_name'][$i], $target . $_FILES['arquivo']['name'][$i])) {
					$erros[] = sprintf('O arquivo "%s" não pode ser movido para o destino', $_FILES['arquivo']['name'][$i]);
				}
			}
			
			chmod($target . $_FILES['arquivo']['name'][$i], 0777);
		}
		
		if ($erros) {
			throw new DataException(implode("<br/>", $erros));
		}
	}
}
