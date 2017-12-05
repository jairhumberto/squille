<?php
function FileMimeType($filename) {
	$mime_types = array(
		'txt' => 'text/plain',
		'htm' => 'text/html',
		'html' => 'text/html',
		'php' => 'text/html',
		'css' => 'text/css',
		'js' => 'application/javascript',
		'json' => 'application/json',
		'xml' => 'text/xml',
		'swf' => 'application/x-shockwave-flash',
		'flv' => 'video/x-flv',

		// images
		'png' => 'image/png',
		'jpe' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'jpg' => 'image/jpeg',
		'gif' => 'image/gif',
		'bmp' => 'image/bmp',
		'ico' => 'image/vnd.microsoft.icon',
		'tiff' => 'image/tiff',
		'tif' => 'image/tiff',
		'svg' => 'image/svg+xml',
		'svgz' => 'image/svg+xml',

		// archives
		'zip' => 'application/zip',
		'rar' => 'application/x-rar-compressed',
		'exe' => 'application/x-msdownload',
		'msi' => 'application/x-msdownload',
		'cab' => 'application/vnd.ms-cab-compressed',

		// audio/video
		'mp3' => 'audio/mpeg',
		'qt' => 'video/quicktime',
		'mov' => 'video/quicktime',

		// adobe
		'pdf' => 'application/pdf',
		'psd' => 'image/vnd.adobe.photoshop',
		'ai' => 'application/postscript',
		'eps' => 'application/postscript',
		'ps' => 'application/postscript',

		// ms office
		'doc' => 'application/msword',
		'rtf' => 'application/rtf',
		'xls' => 'application/vnd.ms-excel',
		'ppt' => 'application/vnd.ms-powerpoint',

		// open office
		'odt' => 'application/vnd.oasis.opendocument.text',
		'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
	);

	@$ext = strtolower(array_pop(explode('.', $filename)));

	if (array_key_exists($ext, $mime_types)) {
		return $mime_types[$ext];
	}
	elseif (function_exists('finfo_open')) {
		$finfo = finfo_open(FILEINFO_MIME);
		$mimetype = finfo_file($finfo, $filename);
		finfo_close($finfo);
		return $mimetype;
	}
	else {
		return 'application/octet-stream';
	}
}
function mimetype($file) {
	$parts = explode(".", $file);
	$extension = $parts[count($parts) - 1];
	switch($extension) {
		case "jpg":
		case "jpeg":
			return "image/jpeg";
		case "png":
			return "image/png";
		case "gif":
			return "image/gif";
		case "xml":
			return "text/xml";
		default:
			return "file";
	}
}

function recursiveunlink($dir) {
    if (substr($dir, -1) != "/") $dir .= "/";

    $hd = opendir($dir);
    while (false !== ($file = readdir($hd))) {
        if ($file != "." && $file != "..") {
            if (is_dir($dir . $file)) {
                recursiveunlink($dir . $file);
            } else {
                unlink($dir . $file);
            }
        }
    }
    closedir($hd);

    rmdir($dir);
}

try {
	if (!@file_exists(sprintf(__DIR__ . '/assets%s', !$_POST['url'])) || preg_match('~^/?\.{1,2}/|/\.{1,2}/|/\.{1,2}$~', $_POST["url"]) || !$_POST["url"]) {
		$url = "/";
	} else {
		if ($_POST['url'] == 'NaN' || $_POST['url'] == 'null' || $_POST['url'] == 'undefined') {
			$url = "/";
		} else {
			$url = $_POST["url"];
		}
	}

	if (substr($url, -1) != "/") $url .= "/";

	$pasta = sprintf(__DIR__ . '/assets%s', $url);

	switch(@$_POST["opt"]) {
		case 1: // Nova pasta.
			$nome = "Nova pasta";
			$i = 0;
			while (file_exists($pasta . $nome)) {
				$nome = sprintf("Nova pasta (%d)", ++$i);
			}
			@mkdir($pasta . $nome);
		break;
		case 2: // Excluindo ítens.
			if ($_POST["files"]) {
				$files = explode(",", $_POST["files"]);
				foreach ($files as $file) {
					// Verificando se é arquivo ou diretorio
					if (is_dir($pasta . $file)) {
						recursiveunlink($pasta . $file);
					} else {
						unlink($pasta . $file);
					}
				}
			}
		break;
		case 3: // Renomeando ítens.
			rename($pasta . $_POST["oldname"], $pasta . $_POST["newname"]);
		break;
		case 4: // Obtendo a permissão da pasta
			if (@$file) {
				echo substr(sprintf('%o', fileperms($pasta . $file)), -3);
			} else {
				echo substr(sprintf('%o', fileperms($pasta)), -3);
			}

			// Dono do arquivo.

			/*$php = trim(`whoami`);
			$owner = posix_getpwuid(fileowner($pasta));
			$owner = trim($owner['name']);*/

			if (false && $php == $owner) {
				echo ":-:1";
			} else {
				echo ":-:0";
			}

			die;
		break;
		case 5:
			if ($file) {
				chmod($pasta . $file, octdec($_POST['prm']));
			} else {
				chmod($pasta, octdec($_POST['prm']));
			}
		break;
	}

	$handle = opendir($pasta);
	$diretorios = array();
	while (false !== ($file = readdir($handle))) {
		if ($file != ".." && $file != ".") {
			if (is_dir($pasta . $file)) {
				$diretorios[] = $file;
			} else {
				$arquivos[] = $file;
			}
		}
	}
	closedir($handle);

	$xml = "<?xml version='1.0' encoding='ISO-8859-1'?>";
	$xml .= sprintf("<pasta url='%s'>", $url);
	$xml .= "<diretorios>";
	if (is_array(@$diretorios)) {
		foreach ($diretorios as $diretorio) {
			$xml .= sprintf("<diretorio name='%s' type='dir'/>", $diretorio);
		}
	}
	$xml .= "</diretorios>";

	$xml .= "<arquivos>";
	if (is_array(@$arquivos)) {
		foreach ($arquivos as $arquivo) {
			$xml .= sprintf("<arquivo name='%s' tamanho='%d bytes' type='%s' url='%s' mime='%s'/>",
					$arquivo,
					filesize($pasta . $arquivo),
					str_replace("/", "_", mimetype($arquivo)),
					strtolower(preg_replace('~^([a-zA-Z]+).*$~', '$1',
							$_SERVER["SERVER_PROTOCOL"])) . "://192.168.1.3/assets" . $url . $arquivo,
					FileMimeType($pasta . $arquivo)
			);
		}
	}
	$xml .= "</arquivos>";
	$xml .= "</pasta>";
} catch(\Exception $e) {
	$xml = "<?xml version='1.0' encoding='UTF-8'?>";
	$xml .= sprintf("<erro>%s</erro>", utf8_encode($e->getMessage()));
}

header("Content-type: text/xml;charset=utf-8");
echo $xml;
