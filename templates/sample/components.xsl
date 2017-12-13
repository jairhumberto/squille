<?xml version='1.0' encoding='UTF-8'?>

<xsl:transform version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:tpl='http://www.squille.com/2018/XSL/Template'>
	
	<xsl:output method="xml" indent="yes"/>
    <xsl:template match="node()|@*">
        <xsl:copy>
            <xsl:apply-templates select="node()|@*"/>
        </xsl:copy>
    </xsl:template>
	
	<!-- componentes gerais -->
	<xsl:template match="content[@component='banner']" tpl:content="banner">
        <div data-src='{text//img/@src}'><xsl:comment/></div>
    </xsl:template>
    
	<xsl:template match="content[@component='raw']" tpl:content="raw">
        <xsl:copy-of select='text/node()'/>
    </xsl:template>
    
    <!-- componentes de categorias -->
    <xsl:template match="category[@component='categoria-de-produto']" tpl:category="categoria-de-produto">
        <section class='category'>
            <h2><a name='{@description}'><xsl:comment/></a><xsl:value-of select='@description'/></h2>
            <div class='itens'>
                <xsl:for-each select="contents/content">
                    <div class='item'>
                        <a href='{text//img[1]/@src}' class='fancybox'>
                            <div class='image'>
                                <img src='{text//img[1]/@src}' alt='{text/h1}'/>
                            </div>
                            <p class='info'><xsl:value-of select='text/h1'/></p>
                        </a>
                    </div>
                </xsl:for-each>
            </div>
        </section>
    </xsl:template>
    
    <!-- menus -->
	<xsl:template match="menu[@component='horizontal-dotted']" tpl:menu="horizontal-dotted">
    	<ul class='dot-separated'>
	    	<xsl:for-each select='link'>
	    		<li><a href='{@href}' class='scroller'><xsl:value-of select='text()'/></a></li>
	    	</xsl:for-each>
    	</ul>
    </xsl:template>
</xsl:transform>