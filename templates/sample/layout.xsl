<?xml version='1.0' encoding='UTF-8'?>

<xsl:transform 	version='1.0'
				xmlns:xsl='http://www.w3.org/1999/XSL/Transform'
				xmlns:tpl='http://www.squille.com/2018/XSL/Template'>
    <xsl:template match='/'>
    	<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html&gt;</xsl:text>
        <html lang='pt'>
            <head>
                <meta charset='utf-8'/>
                <title>Toknew Decorações</title>

                <link rel='stylesheet' href='http://assets-toknew.squille.com/css/style.css' type='text/css'/>
                <link rel='stylesheet' href='http://assets-toknew.squille.com/scripts/camerajs/css/camera.css' type='text/css'/>
				
				<!-- fancybox -->
				<link rel='stylesheet' href='http://assets-toknew.squille.com/scripts/fancybox/jquery.fancybox-1.3.4.css' type='text/css'/>
				
				<!-- adwords -->
				<script async='async' src='https://www.googletagmanager.com/gtag/js?=AW-995362299'><xsl:comment/></script>
				<script src='https://assets-toknew.squille.com/scripts/adwords.js'><xsl:comment/></script>
            </head>
            <body>
                <div class='page'>
                    <header>
                        <div class='container' tpl:section='header'>
                            <a href='/'><h1 class='logo'>Toknew</h1></a>
                            <ul class='top dash-separated'>
                                <li>(62) 9 98103 0490</li>
                                <li><a href='#requestquote' class='scroller'>Solicite um Orçamento</a></li>
                            </ul>
                            <xsl:copy-of select='//*[@section="header"]'/>
                        </div>
                    </header>

                    <div class='content'>
                        <div class='banner' tpl:section='banner'>
                            <div class='viewport'>
                                <xsl:copy-of select='//*[@section="banner"]'/>
                            </div>
                        </div>

                        <div class='panel'>
                            <div class='container' tpl:section='panel'>
                                <xsl:copy-of select='//*[@section="panel"]'/>
                            </div>
                        </div>

                        <div class='products'>
                            <div class='container' tpl:section='products'>
                                <xsl:copy-of select='//*[@section="products"]'/>
                            </div>
                        </div>

                        <form method='post' action='http://assets-toknew.squille.com/php/requestquote.php'>
                            <div class='container'>
                                <h2><a name='requestquote'><xsl:comment/></a>Orçamento</h2>

                                <div class='name'>
                                    <label for='name' class='field'>Nome</label>
                                    <input name='name' id='name'/>
                                </div>

                                <p class='notice'>
                                    Preencha o <span class='destaque'>telefone</span> ou o <span class='destaque'>e-mail</span>, de acordo com a sua preferência de contato.
                                </p>

                                <div class='phone'>
                                    <label for='phone' class='field'>Telefone</label>
                                    <input type='phone' name='phone' id='phone'/>
                                </div>

                                <div class='email'>
                                    <label for='email' class='field'>E-mail</label>
                                    <input type='email' name='email' id='email'/>
                                </div>

                                <div class='note'>
                                    <label for='note' class='dot-separated field'><span>Observações</span><span class='opcional'>Opcional</span></label>
                                    <textarea name='note' id='note'><xsl:comment/></textarea>
                                </div>

                                <button>Enviar</button>
                            </div>
                        </form>
                    </div>
                    
                    <footer class='container'>
                        <p>© Toknew 2017</p>
                        <p>Proudly powered by Squille</p>
                    </footer>
                </div>
            </body>

            <script src='http://assets-toknew.squille.com/scripts/jquery.min.js'><xsl:comment/></script>
            <script src='http://assets-toknew.squille.com/scripts/camerajs/scripts/jquery.mobile.customized.min.js'><xsl:comment/></script>
            <script src='http://assets-toknew.squille.com/scripts/camerajs/scripts/jquery.easing.1.3.js'><xsl:comment/></script> 
            <script src='http://assets-toknew.squille.com/scripts/camerajs/scripts/camera.min.js'><xsl:comment/></script>
            <script src='http://assets-toknew.squille.com/scripts/masked-input/masked.input.js'><xsl:comment/></script>
            <script src='http://assets-toknew.squille.com/scripts/jquery-bez/jquery.bez.js'><xsl:comment/></script>
            <script src='http://assets-toknew.squille.com/scripts/jquery-validate/jquery.validate.min.js'><xsl:comment/></script>
			
			<!-- fancybox -->
            <script src='http://assets-toknew.squille.com/scripts/fancybox/jquery.fancybox-1.3.4.pack.js'><xsl:comment/></script>
            <script src='http://assets-toknew.squille.com/scripts/fancybox/jquery.easing-1.3.pack.js'><xsl:comment/></script>
            <script src='http://assets-toknew.squille.com/scripts/fancybox/jquery.mousewheel-3.0.4.pack.js'><xsl:comment/></script>
			
			<!-- main script -->
            <script src='http://assets-toknew.squille.com/scripts/script.js'><xsl:comment/></script>
        </html>
    </xsl:template>
</xsl:transform>
