<?xml version='1.0' encoding='UTF-8'?>

<xsl:transform 	version='1.0'
				xmlns:xsl='http://www.w3.org/1999/XSL/Transform'
				xmlns:tpl='http://www.weblight.com.br/2015/XSL/Template'>

    <xsl:template match='/'>
    	<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html&gt;</xsl:text>
		<html lang='en'>
			<head>
				<meta charset='utf-8'/>
				<title>Squille - Simple and Flexible</title>
				
				<meta name='viewport' content='width=device-width, user-scalable=no'/>
				<meta name='HandheldFriendly' content='true'/>
				<meta name='apple-mobile-web-app-capable' content='YES'/>

				<link rel='stylesheet' href='http://static.squille.com/css/common.css' type='text/css'/>
				<link rel='stylesheet' href='http://static.squille.com/css/internal.css' type='text/css'/>
			</head>
			<body>
				<header tpl:section='header'>
					<a href='/' class='logo'><img src='http://static.squille.com/images/logo-white.png' width='28' height='28' alt='logotipo'/></a>
					<xsl:copy-of select='//*[@section="header"]'/>
				</header>
				<section class='content' tpl:section='content'>
					<xsl:copy-of select='//*[@section="content"]'/>
				</section>
				<footer tpl:section='footer'><xsl:copy-of select='//*[@section="footer"]'/></footer>
			</body>
		</html>
    </xsl:template>
</xsl:transform>
