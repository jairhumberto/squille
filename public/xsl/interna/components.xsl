<?xml version='1.0' encoding='UTF-8'?>

<xsl:transform version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:tpl='http://www.weblight.com.br/2015/XSL/Template'>
	
	<xsl:output method="xml" indent="yes"/>
    <xsl:template match="node()|@*">
        <xsl:copy>
            <xsl:apply-templates select="node()|@*"/>
        </xsl:copy>
    </xsl:template>
	
	<!-- componentes gerais -->
	<xsl:template match="content[@component='artigo']" tpl:content="artigo">
        <xsl:copy-of select='text/node()'/>
    </xsl:template>
    

    <!-- menus -->
	<xsl:template match="menu[@component='simple']" tpl:menu="simple">
    	<ul>
	    	<xsl:for-each select='link'>
	    		<li><a href='{@href}'><xsl:value-of select='text()'/></a></li>
	    	</xsl:for-each>
    	</ul>
    </xsl:template>
</xsl:transform>
